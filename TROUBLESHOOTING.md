# 🔧 Solução de Problemas - Wizard de Instalação

## ❌ Erro 500 Após Instalação

### **Problema:**
Após executar o wizard de instalação, o sistema apresenta erro 500.

### **Causas Comuns:**

#### 1. **Banco de Dados Não Configurado**
```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it
```

**Solução:**
- Verifique se o MySQL está rodando
- Configure as credenciais corretas no `.env`
- Teste a conexão no wizard

#### 2. **Coluna `deleted_at` Não Existe**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'categorias.deleted_at'
```

**Solução:**
- Execute as migrações: `php artisan migrate`
- Verifique se todas as migrações foram executadas: `php artisan migrate:status`

#### 3. **Arquivo `.env` Não Existe**
```
Configuration cache cleared successfully
```

**Solução:**
```bash
# Copiar arquivo de exemplo
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar banco de dados no .env
```

### **Soluções Rápidas:**

#### **Opção 1: Modo Demo (Recomendado para Testes)**
1. Acesse o wizard: `http://127.0.0.1:8000`
2. Siga até a página de configuração
3. Clique em **"Modo Demo"**
4. Sistema será marcado como instalado sem banco

#### **Opção 2: Instalação Completa**
1. Configure o MySQL
2. Crie o banco de dados
3. Configure o `.env`
4. Execute o wizard normalmente

#### **Opção 3: Reset Completo**
```bash
# Remover arquivo de instalação
rm storage/installed

# Limpar caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Testar novamente
php artisan install:test
```

## 🔍 **Diagnóstico**

### **Comando de Teste**
```bash
php artisan install:test
```

### **Verificar Status**
```bash
# Status das migrações
php artisan migrate:status

# Verificar arquivo .env
php artisan config:show

# Testar conexão com banco
php artisan tinker
>>> DB::connection()->getPdo();
```

### **Logs de Erro**
```bash
# Ver logs do Laravel
tail -f storage/logs/laravel.log

# Ver logs do servidor web
tail -f /var/log/apache2/error.log
```

## 🛠️ **Configuração do Banco de Dados**

### **MySQL Local**
```bash
# Instalar MySQL (Ubuntu/Debian)
sudo apt install mysql-server

# Iniciar MySQL
sudo systemctl start mysql

# Criar banco
mysql -u root -p
CREATE DATABASE sistema_denuncia;
```

### **Configuração .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_denuncia
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

### **XAMPP/WAMP**
- Inicie o Apache e MySQL
- Crie o banco via phpMyAdmin
- Configure o `.env` com as credenciais

## 🚀 **Deploy em Produção**

### **Hostinger**
1. Upload dos arquivos
2. Configure o banco no cPanel
3. Acesse o domínio
4. Siga o wizard
5. Configure credenciais corretas

### **Outros Provedores**
- Verifique se o MySQL está disponível
- Configure as credenciais corretas
- Teste a conexão antes da instalação

## 📋 **Checklist de Verificação**

### **Antes da Instalação**
- [ ] MySQL rodando
- [ ] Banco de dados criado
- [ ] Arquivo `.env` configurado
- [ ] Chave da aplicação gerada
- [ ] Permissões de diretórios corretas

### **Durante a Instalação**
- [ ] Teste de conexão com banco
- [ ] Migrações executadas
- [ ] Seeders executados
- [ ] Usuário admin criado
- [ ] Sistema marcado como instalado

### **Após a Instalação**
- [ ] Sistema acessível
- [ ] Login funcionando
- [ ] Dashboard carregando
- [ ] Funcionalidades básicas OK

## 🆘 **Suporte**

### **Problemas Persistentes**
1. Verifique os logs: `storage/logs/laravel.log`
2. Teste o modo demo primeiro
3. Verifique a configuração do banco
4. Execute o comando de teste: `php artisan install:test`

### **Comandos Úteis**
```bash
# Testar wizard
php artisan install:test

# Limpar caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Verificar status
php artisan migrate:status

# Reset completo
rm storage/installed
```

---

**💡 Dica: Use sempre o "Modo Demo" para testar o wizard antes da instalação completa!** 