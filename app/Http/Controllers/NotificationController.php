<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Listar notificações do usuário
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marcar notificação como lida
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Notificação marcada como lida.');
    }

    /**
     * Marcar todas as notificações como lidas
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    /**
     * Deletar notificação
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Notificação deletada.');
    }

    /**
     * Deletar todas as notificações
     */
    public function destroyAll()
    {
        $user = Auth::user();
        $user->notifications()->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Todas as notificações foram deletadas.');
    }

    /**
     * API para notificações não lidas (AJAX)
     */
    public function unread()
    {
        $user = Auth::user();
        $unreadCount = $user->unreadNotifications()->count();
        $unreadNotifications = $user->unreadNotifications()->take(5)->get();
        
        return response()->json([
            'count' => $unreadCount,
            'notifications' => $unreadNotifications->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->data['tipo'] ?? 'unknown',
                    'message' => $notification->data['mensagem'] ?? 'Notificação',
                    'data' => $notification->data['data'] ?? null,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            })
        ]);
    }
}
