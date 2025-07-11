<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RastreamentoController;
use App\Http\Controllers\UserController;
use App\Services\AuditService;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\SystemConfigController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EmailConfigController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Middleware de manutenção para todas as rotas
Route::middleware(['maintenance'])->group(function () {
    
    // Rota pública para denúncias
    Route::get('/', [WelcomeController::class, 'index'])->name('home')->middleware('no-cache');
    


// Rotas de autenticação
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $credentials = request()->only('email', 'password');
    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();
        // Log de auditoria de login
        AuditService::logLogin(Auth::user());
        return redirect()->intended(route('dashboard.index'));
    }
    return back()->withErrors([
        'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
    ]);
})->name('login.post');

Route::post('/logout', function () {
    $user = Auth::user();
    // Log de auditoria de logout
    if ($user) {
        AuditService::logLogout($user);
    }
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    $redirectTo = request('redirect_to');
    if ($redirectTo) {
        return redirect($redirectTo);
    }
    return redirect()->route('home');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    $validated = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'user', // Usuário padrão
    ]);

    Auth::login($user);
    return redirect()->route('dashboard.index');
})->name('register.post');

// Rotas públicas para denúncias anônimas
Route::get('/denuncia', [DenunciaController::class, 'formularioPublico'])->name('denuncias.formulario-publico');
Route::post('/denuncia', [DenunciaController::class, 'salvarPublica'])->name('denuncias.salvar-publica');

// Rotas públicas para rastreamento
Route::get('/rastreamento-publico', [RastreamentoController::class, 'publico'])->name('rastreamento.publico');
Route::get('/rastreamento-publico/buscar', [RastreamentoController::class, 'publicoBuscar'])->name('rastreamento.publico.buscar');
Route::get('/rastreamento-publico/{protocolo}/download', [RastreamentoController::class, 'downloadPDF'])->name('rastreamento.publico.download');
Route::get('/rastreamento-publico/{protocolo}/resultado', [RastreamentoController::class, 'publicoResultado'])->name('rastreamento.publico.resultado');
// Nova rota para resposta pública
Route::post('/rastreamento-publico/{protocolo}/mensagem/{comentario}/responder', [ComentarioController::class, 'responderMensagemPublica'])->name('rastreamento.publico.responder');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/relatorios', [DashboardController::class, 'relatorios'])->name('dashboard.relatorios');
    Route::get('/dashboard/exportar', [DashboardController::class, 'exportarRelatorio'])->name('dashboard.exportar');
    Route::get('/dashboard/api-dados', [DashboardController::class, 'apiDados'])->name('dashboard.api-dados');
    
    // Denúncias
    Route::resource('denuncias', DenunciaController::class);
    Route::post('/denuncias/{denuncia}/alterar-status', [DenunciaController::class, 'alterarStatus'])->name('denuncias.alterar-status');
    Route::post('/denuncias/{denuncia}/atribuir-responsavel', [DenunciaController::class, 'atribuirResponsavel'])->name('denuncias.atribuir-responsavel');
    
    // Comentários
    Route::post('/denuncias/{denuncia}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::put('/comentarios/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
    Route::post('/comentarios/{comentario}/toggle-importante', [ComentarioController::class, 'toggleImportante'])->name('comentarios.toggle-importante');
    
    // Mensagens
    Route::post('/denuncias/{denuncia}/enviar-mensagem', [ComentarioController::class, 'enviarMensagem'])->name('comentarios.enviar-mensagem');
    Route::post('/comentarios/{comentario}/responder', [ComentarioController::class, 'responderMensagem'])->name('comentarios.responder');
    Route::get('/denuncias/{denuncia}/mensagens', [ComentarioController::class, 'listarMensagens'])->name('comentarios.mensagens');
    
    // Evidências
    Route::post('/denuncias/{denuncia}/evidencias', [EvidenciaController::class, 'store'])->name('evidencias.store');
    Route::get('/evidencias/{evidencia}', [EvidenciaController::class, 'show'])->name('evidencias.show');
    Route::get('/evidencias/{evidencia}/download', [EvidenciaController::class, 'download'])->name('evidencias.download');
    Route::get('/evidencias/{evidencia}/preview', [EvidenciaController::class, 'preview'])->name('evidencias.preview');
    Route::put('/evidencias/{evidencia}', [EvidenciaController::class, 'update'])->name('evidencias.update');
    Route::delete('/evidencias/{evidencia}', [EvidenciaController::class, 'destroy'])->name('evidencias.destroy');
    Route::post('/evidencias/{evidencia}/toggle-publico', [EvidenciaController::class, 'togglePublico'])->name('evidencias.toggle-publico');
    
    // Categorias
    Route::resource('categorias', CategoriaController::class);
    Route::post('/categorias/{categoria}/toggle-ativo', [CategoriaController::class, 'toggleAtivo'])->name('categorias.toggle-ativo');
    Route::get('/categorias/{categoria}/estatisticas', [CategoriaController::class, 'estatisticas'])->name('categorias.estatisticas');
    
    // Rotas AJAX
    Route::get('/denuncias/{denuncia}/comentarios', [ComentarioController::class, 'listarComentarios'])->name('comentarios.listar');
    Route::post('/denuncias/{denuncia}/comentarios-ajax', [ComentarioController::class, 'adicionarComentarioAjax'])->name('comentarios.ajax');
    Route::get('/denuncias/{denuncia}/evidencias', [EvidenciaController::class, 'listarEvidencias'])->name('evidencias.listar');
    Route::post('/denuncias/{denuncia}/evidencias-ajax', [EvidenciaController::class, 'uploadAjax'])->name('evidencias.ajax');
    Route::get('/categorias-select', [CategoriaController::class, 'listarParaSelect'])->name('categorias.select');

    // Rotas de rastreamento (públicas para usuários logados)
    Route::get('/rastreamento', [RastreamentoController::class, 'index'])->name('rastreamento.index');
    Route::get('/rastreamento/{protocolo}', [RastreamentoController::class, 'show'])->name('rastreamento.show');
    Route::get('/rastreamento/buscar', [RastreamentoController::class, 'buscar'])->name('rastreamento.buscar');
    Route::get('/rastreamento/{protocolo}/status', [RastreamentoController::class, 'apiStatus'])->name('rastreamento.status');

    // Usuários
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-ativo', [UserController::class, 'toggleAtivo'])->name('users.toggle-ativo');
    Route::post('/users/{user}/alterar-senha', [UserController::class, 'alterarSenha'])->name('users.alterar-senha');
    Route::get('/perfil', [UserController::class, 'perfil'])->name('users.perfil');
    Route::post('/perfil', [UserController::class, 'atualizarPerfil'])->name('users.atualizar-perfil');
    
    // Permissões de Usuários
    Route::get('/users/{user}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
    Route::post('/users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update');
    Route::post('/users/{user}/permissions/grant', [UserController::class, 'grantPermission'])->name('users.permissions.grant');
    Route::post('/users/{user}/permissions/revoke', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
    
    // Auditoria
    Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
    Route::get('/audit/dashboard', [AuditController::class, 'dashboard'])->name('audit.dashboard');
    Route::get('/audit/export', [AuditController::class, 'export'])->name('audit.export');
    Route::post('/audit/cleanup', [AuditController::class, 'cleanup'])->name('audit.cleanup');
    Route::get('/audit/{auditLog}', [AuditController::class, 'show'])->name('audit.show');
    
    // Notificações
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    
    // Configurações do Sistema
    Route::resource('system-config', SystemConfigController::class);
    Route::post('/system-config/update-multiple', [SystemConfigController::class, 'updateMultiple'])->name('system-config.update-multiple');

    // Configuração de Email
    Route::get('/email-config', [EmailConfigController::class, 'index'])->name('email-config.index');
    Route::post('/email-config', [EmailConfigController::class, 'update'])->name('email-config.update');
    Route::post('/email-config/test', [EmailConfigController::class, 'test'])->name('email-config.test');
    Route::get('/email-config/validate', [EmailConfigController::class, 'validateCurrentConfig'])->name('email-config.validate');

    // Permissões
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);

    // Novas rotas para ação em massa de usuários
    Route::post('/users/mass-action', [UserController::class, 'massAction'])->name('users.mass-action');

    // Rota amigável para /admin
    Route::get('/admin', function() {
        return redirect()->route('dashboard.index');
    });
}); // Fechamento do grupo de rotas autenticadas

}); // Fechamento do grupo de manutenção

// Rota de fallback
Route::fallback(function() {
    return response()->view('errors.404', [], 404);
});

Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
