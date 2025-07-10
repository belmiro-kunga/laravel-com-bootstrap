<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todos os usuários do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->error('Nenhum usuário encontrado no sistema.');
            return;
        }
        
        $this->info('=== USUÁRIOS DO SISTEMA ===');
        $this->newLine();
        
        $headers = ['ID', 'Nome', 'Email', 'Função', 'Ativo', 'Criado em'];
        $rows = [];
        
        foreach ($users as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->role_label,
                $user->ativo ? 'Sim' : 'Não',
                $user->created_at->format('d/m/Y H:i')
            ];
        }
        
        $this->table($headers, $rows);
        
        $this->newLine();
        $this->info('=== CREDENCIAIS DE ACESSO ===');
        $this->newLine();
        
        foreach ($users as $user) {
            $this->line("👤 <fg=cyan>{$user->name}</> ({$user->role_label})");
            $this->line("   📧 Email: <fg=yellow>{$user->email}</>");
            
            // Definir senhas específicas para cada usuário
            $senha = '123456'; // senha padrão
            if ($user->email === 'compliance@empresa.com') {
                $senha = 'Whistle2024!';
            } elseif ($user->email === 'investigador@empresa.com') {
                $senha = 'Invest2024!';
            } elseif ($user->email === 'auditor@empresa.com') {
                $senha = 'Audit2024!';
            }
            
            $this->line("   🔑 Senha: <fg=red>{$senha}</>");
            $this->newLine();
        }
        
        $this->info('🎯 Para acessar o painel admin, use:');
        $this->line('   Email: compliance@empresa.com');
        $this->line('   Senha: Whistle2024!');
        $this->newLine();
        
        $this->info('🔍 Para investigações, use:');
        $this->line('   Email: investigador@empresa.com');
        $this->line('   Senha: Invest2024!');
        $this->newLine();
        
        $this->info('📊 Para auditoria, use:');
        $this->line('   Email: auditor@empresa.com');
        $this->line('   Senha: Audit2024!');
        $this->newLine();
    }
}
