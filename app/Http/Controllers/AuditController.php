<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuditController extends Controller
{
    /**
     * Display a listing of audit logs
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('auditoria.view')) {
            abort(403, 'Acesso negado.');
        }

        $query = AuditLog::with(['user', 'auditable']);

        // Filtros
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('auditable_type')) {
            $query->where('auditable_type', $request->auditable_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Ordenação
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        
        if (in_array($sort, ['created_at', 'event', 'user_id', 'auditable_type', 'ip_address'])) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Paginação
        $perPage = $request->get('per_page', 25);
        if (!in_array($perPage, [15, 25, 50, 100])) {
            $perPage = 25;
        }

        $logs = $query->paginate($perPage);

        // Dados para filtros
        $events = AuditLog::distinct()->pluck('event')->sort();
        $users = User::orderBy('name')->get();
        $auditableTypes = AuditLog::distinct()->pluck('auditable_type')->sort();

        // Estatísticas
        $stats = [
            'total' => AuditLog::count(),
            'today' => AuditLog::today()->count(),
            'this_week' => AuditLog::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month' => AuditLog::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('audit.index', compact('logs', 'events', 'users', 'auditableTypes', 'stats'));
    }

    /**
     * Display the specified audit log
     */
    public function show(AuditLog $auditLog)
    {
        if (!Auth::user()->hasPermission('auditoria.view')) {
            abort(403, 'Acesso negado.');
        }

        $auditLog->load(['user', 'auditable']);

        return view('audit.show', compact('auditLog'));
    }

    /**
     * Dashboard de auditoria
     */
    public function dashboard()
    {
        if (!Auth::user()->hasPermission('auditoria.view')) {
            abort(403, 'Acesso negado.');
        }

        // Estatísticas gerais
        $stats = [
            'total_logs' => AuditLog::count(),
            'today_logs' => AuditLog::today()->count(),
            'unique_users' => AuditLog::distinct('user_id')->count(),
            'unique_ips' => AuditLog::distinct('ip_address')->count(),
        ];

        // Logs por evento (últimos 30 dias)
        $eventsByDay = AuditLog::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, event, COUNT(*) as count')
            ->groupBy('date', 'event')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        // Top eventos
        $topEvents = AuditLog::selectRaw('event, COUNT(*) as count')
            ->groupBy('event')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        // Top usuários
        $topUsers = AuditLog::with('user')
            ->selectRaw('user_id, COUNT(*) as count')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        // Logs recentes
        $recentLogs = AuditLog::with(['user', 'auditable'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('audit.dashboard', compact('stats', 'eventsByDay', 'topEvents', 'topUsers', 'recentLogs'));
    }

    /**
     * Exportar logs para CSV
     */
    public function export(Request $request)
    {
        if (!Auth::user()->hasPermission('auditoria.export')) {
            abort(403, 'Acesso negado.');
        }

        $query = AuditLog::with(['user', 'auditable']);

        // Aplicar mesmos filtros do index
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('auditable_type')) {
            $query->where('auditable_type', $request->auditable_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        $filename = 'audit_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho
            fputcsv($file, [
                'ID',
                'Evento',
                'Descrição',
                'Usuário',
                'Tipo de Modelo',
                'ID do Modelo',
                'IP',
                'User Agent',
                'URL',
                'Método',
                'Valores Antigos',
                'Valores Novos',
                'Data/Hora'
            ]);

            // Dados
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->event_label,
                    $log->description,
                    $log->user ? $log->user->name : 'N/A',
                    $log->auditable_type_label,
                    $log->auditable_id,
                    $log->ip_address,
                    $log->user_agent,
                    $log->url,
                    $log->method,
                    json_encode($log->old_values),
                    json_encode($log->new_values),
                    $log->created_at->format('d/m/Y H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Limpar logs antigos
     */
    public function cleanup(Request $request)
    {
        if (!Auth::user()->hasPermission('auditoria.cleanup')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'days' => 'required|integer|min:30|max:365'
        ]);

        try {
            $deleted = AuditLog::where('created_at', '<', now()->subDays($request->days))->delete();

            return redirect()->route('audit.index')
                           ->with('success', "{$deleted} logs antigos foram removidos com sucesso!");

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao limpar logs: ' . $e->getMessage());
        }
    }
}
