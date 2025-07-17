#!/bin/bash

# Script de Deploy para Hostinger
# Execute este script após fazer upload dos arquivos

echo "🚀 Iniciando deploy do Sistema de Denúncias..."

# Verificar se estamos na pasta correta
if [ ! -f "artisan" ]; then
    echo "❌ Erro: Execute este script na pasta raiz do projeto Laravel"
    exit 1
fi

# Verificar se o .env existe
if [ ! -f ".env" ]; then
    echo "❌ Erro: Arquivo .env não encontrado. Copie o .env.example para .env primeiro"
    exit 1
fi

echo "📦 Instalando dependências..."
composer install --optimize-autoloader --no-dev --no-interaction

echo "🔧 Gerando chave da aplicação..."
php artisan key:generate --force

echo "🗄️ Executando migrações..."
php artisan migrate --force

echo "🌱 Executando seeders..."
php artisan db:seed --force

echo "🔗 Criando link simbólico do storage..."
php artisan storage:link

echo "⚡ Otimizando caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "📁 Configurando permissões..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env

echo "✅ Deploy concluído com sucesso!"
echo "🌐 Acesse seu sistema em: https://seudominio.com/sistema"
echo "👤 Login: admin@admin.com"
echo "�� Senha: password" 