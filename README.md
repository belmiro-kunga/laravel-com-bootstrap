# 🚀 Sistema de Denúncias Corporativas

Um sistema completo de whistleblowing (denúncias corporativas) desenvolvido em Laravel 10 com interface moderna e funcionalidades avançadas.

## ✨ Características Principais

### 🔒 **Denúncias Anônimas**
- Sistema seguro para denúncias anônimas
- Criptografia de dados sensíveis
- Proteção da identidade do denunciante
- Rastreamento por protocolo único

### 📊 **Dashboard Administrativo**
- Relatórios em tempo real
- Métricas e estatísticas
- Gráficos interativos
- Filtros avançados

### 👥 **Gestão de Usuários**
- Múltiplos níveis de acesso
- Controle de permissões granular
- Auditoria de ações
- Gestão de responsáveis

### 🔄 **Workflow de Denúncias**
- Status personalizáveis
- Notificações automáticas
- Histórico completo
- Anexos de arquivos

### 📱 **Interface Responsiva**
- Design moderno com Bootstrap 5
- Interface adaptável (mobile/desktop)
- UX otimizada
- Acessibilidade

## 🚀 **Instalação Rápida**

### **Opção 1: Wizard de Instalação (Recomendado)**

O sistema agora inclui um **Wizard de Instalação** completo que facilita todo o processo:

1. **Upload dos arquivos** para seu servidor
2. **Acesse o domínio** - o wizard será ativado automaticamente
3. **Siga os passos**:
   - Verificação de requisitos
   - Configuração do banco de dados
   - Criação do usuário administrador
   - Instalação automática

```bash
# Acesse: http://seudominio.com
# O wizard guiará você através de todo o processo!
```

### **Opção 2: Instalação Manual**

```bash
# 1. Clone o repositório
git clone https://github.com/seuusuario/laravel-com-bootstrap.git
cd laravel-com-bootstrap

# 2. Instale as dependências
composer install
npm install

# 3. Configure o ambiente
cp .env.example .env
php artisan key:generate

# 4. Configure o banco de dados no .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_denuncia
DB_USERNAME=root
DB_PASSWORD=

# 5. Execute as migrações
php artisan migrate

# 6. Execute os seeders
php artisan db:seed

# 7. Compile os assets
npm run build

# 8. Configure o storage
php artisan storage:link

# 9. Otimize o sistema
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📋 **Requisitos do Sistema**

- **PHP**: 8.1 ou superior
- **MySQL**: 5.7 ou superior
- **Composer**: Última versão
- **Node.js**: 16+ (opcional, para desenvolvimento)
- **Extensões PHP**: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, Fileinfo, GD

## 🎯 **Funcionalidades Detalhadas**

### **Para Denunciantes**
- ✅ Formulário de denúncia anônima
- ✅ Upload de anexos
- ✅ Rastreamento por protocolo
- ✅ Notificações de status
- ✅ Interface responsiva

### **Para Administradores**
- ✅ Dashboard completo
- ✅ Gestão de denúncias
- ✅ Relatórios avançados
- ✅ Configurações do sistema
- ✅ Gestão de usuários

### **Para Responsáveis**
- ✅ Lista de denúncias atribuídas
- ✅ Atualização de status
- ✅ Comentários internos
- ✅ Notificações automáticas

## 🔧 **Configuração Avançada**

### **Personalização**
```php
// Configurar categorias de denúncia
php artisan tinker
>>> App\Models\Categoria::create(['nome' => 'Nova Categoria']);

// Configurar status do workflow
>>> App\Models\Status::create(['nome' => 'Em Análise', 'cor' => '#ffc107']);
```

### **Configurações do Sistema**
```php
// Configurações via SystemConfig
SystemConfig::setValue('site_name', 'Meu Sistema', 'string', 'frontend');
SystemConfig::setValue('maintenance_mode', 'false', 'boolean', 'system');
```

## 🚀 **Deploy em Produção**

### **Hostinger (Recomendado)**
1. Upload via File Manager ou FTP
2. Configure o banco no cPanel
3. Acesse o domínio
4. Siga o wizard de instalação
5. Sistema pronto!

### **Outros Provedores**
- Funciona em qualquer hospedagem PHP
- Suporte a MySQL/MariaDB
- Configuração via wizard

## 🔒 **Segurança**

### **Implementado**
- ✅ Criptografia de dados sensíveis
- ✅ Proteção CSRF
- ✅ Validação de inputs
- ✅ Sanitização de dados
- ✅ Controle de acesso granular
- ✅ Auditoria de ações

### **Recomendações**
- 🔒 Configure HTTPS
- 🔒 Altere senhas padrão
- 🔒 Faça backup regular
- 🔒 Mantenha o sistema atualizado
- 🔒 Remova o wizard após instalação

## 📊 **Estrutura do Banco**

### **Tabelas Principais**
- `users` - Usuários do sistema
- `denuncias` - Denúncias anônimas
- `categorias` - Categorias de denúncia
- `status` - Status do workflow
- `system_configs` - Configurações do sistema
- `audit_logs` - Log de auditoria

## 🎨 **Interface**

### **Design System**
- **Framework**: Bootstrap 5
- **Ícones**: Font Awesome 6
- **Cores**: Paleta profissional
- **Tipografia**: Sistema moderno
- **Componentes**: Reutilizáveis

### **Responsividade**
- ✅ Mobile First
- ✅ Tablet otimizado
- ✅ Desktop completo
- ✅ Acessibilidade WCAG

## 📞 **Suporte**

### **Documentação**
- [Wizard de Instalação](WIZARD-INSTALLATION.md)
- [Guia de Deploy](deploy-hostinger.md)
- [Checklist de Deploy](checklist-deploy.md)

### **Problemas Comuns**
1. **Erro de permissões** - Configure 755/775
2. **Banco não conecta** - Verifique credenciais
3. **Wizard não aparece** - Verifique arquivo .env
4. **Assets não carregam** - Execute `npm run build`

## 🤝 **Contribuição**

1. Fork o projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 📄 **Licença**

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 🎉 **Agradecimentos**

- Laravel Framework
- Bootstrap Team
- Font Awesome
- Comunidade PHP

---

**🚀 Sistema de Denúncias - Tornando as organizações mais transparentes e seguras!**
