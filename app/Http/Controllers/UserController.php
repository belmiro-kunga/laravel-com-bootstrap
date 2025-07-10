<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\AuditService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('usuarios.view')) {
            abort(403, 'Acesso negado.');
        }

        $query = User::withCount(['denunciasResponsavel', 'denunciasResponsavel as denuncias_pendentes_count' => function($q) {
            $q->whereNotIn('status_id', \App\Models\Status::finalizadores()->pluck('id'));
        }]);

        // Filtro de busca
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por role
        if (request('role')) {
            $query->where('role', request('role'));
        }

        // Filtro por status
        if (request('status') !== null) {
            $query->where('ativo', request('status'));
        }

        // Ordenação
        $sort = request('sort', 'name');
        $order = request('order', 'asc');
        
        if (in_array($sort, ['name', 'email', 'role', 'ativo', 'created_at', 'last_login_at'])) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Paginação
        $perPage = request('per_page', 15);
        if (!in_array($perPage, [15, 30, 50])) {
            $perPage = 15;
        }

        $users = $query->paginate($perPage);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('usuarios.create')) {
            abort(403, 'Acesso negado.');
        }

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('usuarios.create')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'responsavel', 'usuario'])],
            'ativo' => 'boolean'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'ativo' => $request->boolean('ativo', true)
            ]);

            return redirect()->route('users.index')
                           ->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.view')) {
            abort(403, 'Acesso negado.');
        }

        $user->load(['denunciasResponsavel' => function($query) {
            $query->with(['status', 'categoria'])
                  ->orderBy('created_at', 'desc')
                  ->limit(10);
        }, 'comentarios']);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.edit')) {
            abort(403, 'Acesso negado.');
        }

        // Se for requisição AJAX, retornar JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.edit')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'responsavel', 'usuario'])],
            'ativo' => 'boolean'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'ativo' => $request->boolean('ativo', true)
            ];

            // Só atualizar senha se foi fornecida
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('users.index')
                           ->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.delete')) {
            abort(403, 'Acesso negado.');
        }

        // Não permitir excluir o próprio usuário
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Não é possível excluir seu próprio usuário.');
        }

        // Verificar se há denúncias associadas
        if ($user->denunciasResponsavel()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um usuário que possui denúncias associadas.');
        }

        try {
            $user->delete();

            return redirect()->route('users.index')
                           ->with('success', 'Usuário excluído com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }

    /**
     * Toggle ativo/inativo
     */
    public function toggleAtivo(User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.edit')) {
            abort(403, 'Acesso negado.');
        }

        // Não permitir desativar o próprio usuário
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Não é possível desativar seu próprio usuário.');
        }

        try {
            $user->update(['ativo' => !$user->ativo]);

            $mensagem = $user->ativo 
                ? 'Usuário ativado com sucesso!' 
                : 'Usuário desativado com sucesso!';

            return redirect()->route('users.index')
                           ->with('success', $mensagem);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar status do usuário: ' . $e->getMessage());
        }
    }

    /**
     * Alterar senha do usuário
     */
    public function alterarSenha(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.edit')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            $user->update(['password' => Hash::make($request->password)]);
            // Log de auditoria de alteração de senha
            AuditService::logPasswordChanged($user);

            return redirect()->route('users.index')
                           ->with('success', 'Senha alterada com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar senha: ' . $e->getMessage());
        }
    }

    /**
     * Perfil do usuário logado
     */
    public function perfil()
    {
        $user = Auth::user();
        
        return view('users.perfil', compact('user'));
    }

    /**
     * Atualizar perfil do usuário logado
     */
    public function atualizarPerfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password_atual' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        try {
            // Verificar senha atual se fornecida
            if ($request->filled('password_atual')) {
                if (!Hash::check($request->password_atual, $user->password)) {
                    return back()->withInput()->with('error', 'Senha atual incorreta.');
                }
            }

            $data = [
                'name' => $request->name,
                'email' => $request->email
            ];

            // Só atualizar senha se foi fornecida
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            // Log de auditoria de alteração de senha, se senha foi alterada
            if ($request->filled('password')) {
                AuditService::logPasswordChanged($user);
            }

            return redirect()->route('users.perfil')
                           ->with('success', 'Perfil atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar permissões do usuário
     */
    public function permissions(User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.manage_permissions')) {
            abort(403, 'Acesso negado.');
        }

        $permissions = \App\Models\Permission::active()->ordered()->get();
        $userPermissions = $user->getGrantedPermissions()->pluck('slug')->toArray();

        return view('users.permissions', compact('user', 'permissions', 'userPermissions'));
    }

    /**
     * Atualizar permissões do usuário
     */
    public function updatePermissions(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.manage_permissions')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id'
        ]);

        try {
            $permissions = $request->input('permissions', []);
            // Sincronizar permissões usando IDs
            $user->permissions()->sync($permissions);

            return redirect()->route('users.permissions', $user)
                           ->with('success', 'Permissões atualizadas com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar permissões: ' . $e->getMessage());
        }
    }

    /**
     * Conceder permissão específica
     */
    public function grantPermission(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.manage_permissions')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'permission' => 'required|string|exists:permissions,slug'
        ]);

        try {
            $user->grantPermission($request->permission, Auth::id());
            // Log de auditoria de concessão de permissão
            $permission = \App\Models\Permission::where('slug', $request->permission)->first();
            AuditService::logPermissionGranted($user, $permission, Auth::user());

            return response()->json([
                'success' => true,
                'message' => 'Permissão concedida com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao conceder permissão: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revogar permissão específica
     */
    public function revokePermission(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('usuarios.manage_permissions')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'permission' => 'required|string|exists:permissions,slug'
        ]);

        try {
            $user->revokePermission($request->permission);
            // Log de auditoria de revogação de permissão
            $permission = \App\Models\Permission::where('slug', $request->permission)->first();
            AuditService::logPermissionRevoked($user, $permission, Auth::user());

            return response()->json([
                'success' => true,
                'message' => 'Permissão revogada com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao revogar permissão: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ação em massa para ativar/desativar usuários
     */
    public function massAction(Request $request)
    {
        if (!Auth::user()->hasPermission('usuarios.edit')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'action' => 'required|in:ativar,desativar,resetar_senha',
            'users' => 'required|array',
            'users.*' => 'integer|exists:users,id',
        ]);

        $ids = $request->input('users', []);
        $action = $request->input('action');
        $count = 0;

        if ($action === 'ativar') {
            $count = User::whereIn('id', $ids)->update(['ativo' => true]);
        } elseif ($action === 'desativar') {
            $count = User::whereIn('id', $ids)->update(['ativo' => false]);
        } elseif ($action === 'resetar_senha') {
            $novaSenha = 'Senha123!';
            $count = User::whereIn('id', $ids)->update(['password' => \Hash::make($novaSenha)]);
            return redirect()->route('users.index')
                ->with('success', "$count usuário(s) tiveram a senha resetada para '$novaSenha'. Oriente-os a alterar após o login.");
        }

        return redirect()->route('users.index')
            ->with('success', "$count usuário(s) atualizado(s) com sucesso!");
    }
}
