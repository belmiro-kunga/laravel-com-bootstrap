# ✅ Checklist de Deploy - Hostinger

## 📋 Pré-Deploy (Local)
- [ ] `composer install --optimize-autoloader --no-dev` ✅
- [ ] `npm run build` ✅
- [ ] Testar sistema localmente ✅

## 🌐 Na Hostinger

### 1. Banco de Dados
- [ ] Criar banco MySQL no cPanel
- [ ] Anotar nome do banco, usuário e senha
- [ ] Testar conexão

### 2. Upload de Arquivos
- [ ] Acessar File Manager no cPanel
- [ ] Criar pasta `sistema` em `public_html`
- [ ] Upload de TODOS os arquivos do projeto
- [ ] Verificar se não faltou nenhum arquivo

### 3. Configuração
- [ ] Copiar `.env.example` para `.env`
- [ ] Configurar credenciais do banco no `.env`
- [ ] Configurar `APP_URL` no `.env`
- [ ] Configurar `APP_DEBUG=false`
- [ ] Configurar email SMTP (se necessário)

### 4. Execução de Comandos
- [ ] Acessar Terminal SSH (se disponível)
- [ ] Navegar para pasta do projeto
- [ ] `php artisan key:generate`
- [ ] `php artisan migrate --force`
- [ ] `php artisan db:seed --force`
- [ ] `php artisan storage:link`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`

### 5. Configuração Web
- [ ] Configurar subdomínio OU
- [ ] Configurar `.htaccess` na raiz
- [ ] Testar acesso ao sistema

### 6. Permissões
- [ ] `chmod -R 755 storage`
- [ ] `chmod -R 755 bootstrap/cache`
- [ ] `chmod 644 .env`

### 7. Testes Finais
- [ ] Acessar URL do sistema
- [ ] Testar login: `admin@admin.com` / `password`
- [ ] Testar criação de denúncia
- [ ] Testar upload de arquivos
- [ ] Testar rastreamento público
- [ ] Verificar se assets carregam corretamente

## 🔧 Problemas Comuns

### Erro 500
- [ ] Verificar permissões das pastas
- [ ] Verificar logs em `storage/logs/laravel.log`
- [ ] Temporariamente ativar `APP_DEBUG=true`

### Erro de Banco
- [ ] Verificar credenciais no `.env`
- [ ] Testar conexão com banco
- [ ] Verificar se migrações foram executadas

### Assets não carregam
- [ ] Verificar se `npm run build` foi executado
- [ ] Verificar se pasta `public/build` existe
- [ ] Verificar permissões da pasta `public`

### Upload não funciona
- [ ] Verificar permissões da pasta `storage`
- [ ] Verificar se link simbólico foi criado
- [ ] Verificar configurações de upload no PHP

## 📞 Suporte
- [ ] Logs do sistema: `storage/logs/laravel.log`
- [ ] Logs do servidor: cPanel → Logs
- [ ] Suporte Hostinger: Chat ou Ticket

## 🔒 Segurança
- [ ] `APP_DEBUG=false` em produção
- [ ] Senhas fortes para banco de dados
- [ ] HTTPS configurado
- [ ] Arquivos sensíveis protegidos
- [ ] Backup do banco de dados

## 📊 Monitoramento
- [ ] Configurar monitoramento de erros
- [ ] Backup automático do banco
- [ ] Monitoramento de performance
- [ ] Logs de acesso

---

**🎉 Sistema Deployado com Sucesso!** 