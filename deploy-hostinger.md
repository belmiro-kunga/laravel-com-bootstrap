# 🚀 Deploy na Hostinger - Guia Completo

## 📋 Pré-requisitos
- Conta na Hostinger com plano que suporte PHP 8.1+
- Acesso ao cPanel
- Acesso ao banco de dados MySQL

## 🔧 Passo a Passo

### 1. **Preparação do Projeto (Local)**
```bash
# Otimizar dependências para produção
composer install --optimize-autoloader --no-dev

# Compilar assets
npm run build
```

### 2. **Criar Banco de Dados na Hostinger**
1. Acesse o cPanel da Hostinger
2. Vá em "Bancos de Dados" → "MySQL Databases"
3. Crie um novo banco de dados:
   - Nome: `seudominio_sistema_denuncia`
   - Usuário: `seudominio_admin`
   - Senha: (senha forte)
4. Anote as credenciais

### 3. **Upload dos Arquivos**
1. Acesse o File Manager no cPanel
2. Vá para a pasta `public_html`
3. **IMPORTANTE**: Crie uma pasta para o projeto (ex: `sistema`)
4. Faça upload de TODOS os arquivos do projeto para esta pasta

### 4. **Configuração do .env**
1. No File Manager, localize o arquivo `.env.example`
2. Copie para `.env`
3. Edite o `.env` com as configurações da Hostinger:

```env
APP_NAME="Sistema de Denúncias"
APP_ENV=production
APP_KEY=base64:5Sprph1XOnBSVy/ZzHMjZegge9r2hkpd9yJ7HBfhZbU=
APP_DEBUG=false
APP_URL=https://seudominio.com/sistema

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=seudominio_sistema_denuncia
DB_USERNAME=seudominio_admin
DB_PASSWORD=sua_senha_aqui

MAIL_MAILER=smtp
MAIL_HOST=mail.seudominio.com
MAIL_PORT=587
MAIL_USERNAME=noreply@seudominio.com
MAIL_PASSWORD=sua_senha_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seudominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. **Configuração do Document Root**
**OPÇÃO A: Subdomínio (Recomendado)**
1. Crie um subdomínio: `sistema.seudominio.com`
2. Configure o Document Root para: `public_html/sistema/public`

**OPÇÃO B: Pasta no domínio principal**
1. Configure o `.htaccess` na raiz do `public_html`:

```apache
RewriteEngine On
RewriteRule ^(.*)$ sistema/public/$1 [L]
```

### 6. **Executar Comandos Laravel**
1. Acesse o Terminal SSH no cPanel (se disponível)
2. Navegue até a pasta do projeto
3. Execute os comandos:

```bash
# Gerar chave da aplicação
php artisan key:generate

# Executar migrações
php artisan migrate --force

# Executar seeders
php artisan db:seed --force

# Criar link simbólico do storage
php artisan storage:link

# Otimizar caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. **Configurar Permissões**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

### 8. **Configurar .htaccess**
Se não estiver usando subdomínio, crie um `.htaccess` na raiz:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ sistema/public/$1 [L]
</IfModule>
```

## 🔍 Verificações Finais

### Testar o Sistema
1. Acesse: `https://seudominio.com/sistema`
2. Teste o login: `admin@admin.com` / `password`
3. Verifique se todas as funcionalidades estão funcionando

### Problemas Comuns
1. **Erro 500**: Verificar permissões das pastas
2. **Erro de banco**: Verificar credenciais no `.env`
3. **Assets não carregam**: Verificar se o `npm run build` foi executado
4. **Upload não funciona**: Verificar permissões da pasta `storage`

## 📞 Suporte
Se encontrar problemas:
1. Verifique os logs em `storage/logs/laravel.log`
2. Temporariamente ative `APP_DEBUG=true` para ver erros
3. Entre em contato com o suporte da Hostinger se necessário

## 🔒 Segurança
- Mantenha `APP_DEBUG=false` em produção
- Use senhas fortes para o banco de dados
- Configure HTTPS
- Mantenha o Laravel atualizado 