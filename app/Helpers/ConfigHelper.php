<?php

namespace App\Helpers;

use App\Models\SystemConfig;
use Illuminate\Support\Facades\Cache;

class ConfigHelper
{
    /**
     * Buscar valor de configuração com cache
     */
    public static function get($key, $default = null)
    {
        // Forçar busca direta no banco sem cache
        $config = SystemConfig::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

    /**
     * Buscar configuração como boolean
     */
    public static function getBool($key, $default = false)
    {
        $value = self::get($key, $default);
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Buscar configuração como integer
     */
    public static function getInt($key, $default = 0)
    {
        $value = self::get($key, $default);
        return (int) $value;
    }

    /**
     * Buscar configuração como JSON
     */
    public static function getJson($key, $default = [])
    {
        $value = self::get($key, $default);
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return $decoded !== null ? $decoded : $default;
        }
        return $value;
    }

    /**
     * Definir valor de configuração
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $description = null)
    {
        $config = SystemConfig::setValue($key, $value, $type, $group, $description);
        
        // Limpar cache específico
        Cache::forget("config.{$key}");
        Cache::forget('system_configs');
        
        return $config;
    }

    /**
     * Buscar todas as configurações públicas
     */
    public static function getPublicConfigs()
    {
        return Cache::remember('public_configs', 3600, function () {
            return SystemConfig::where('is_public', true)->get();
        });
    }

    /**
     * Verificar se sistema está em manutenção
     */
    public static function isMaintenanceMode()
    {
        return self::getBool('maintenance_mode', false);
    }

    /**
     * Obter mensagem de manutenção
     */
    public static function getMaintenanceMessage()
    {
        return self::get('maintenance_message', 'Sistema em manutenção. Volte em breve.');
    }

    /**
     * Obter configurações de email
     */
    public static function getEmailConfigs()
    {
        return [
            'from_name' => self::get('email_from_name', 'Sistema de Denúncias'),
            'from_address' => self::get('email_from_address', 'noreply@denuncias.ao'),
            'notifications_enabled' => self::getBool('email_notifications_enabled', true)
        ];
    }

    /**
     * Obter configurações de frontend
     */
    public static function getFrontendConfigs()
    {
        return [
            'site_name' => self::get('site_name', 'Sistema de Denúncias Corporativas'),
            'site_description' => self::get('site_description', 'Sistema seguro para denúncias corporativas'),
            'primary_color' => self::get('primary_color', '#007bff'),
            'logo_url' => self::get('logo_url', '/images/logo.png'),
            'favicon_url' => self::get('favicon_url', '/favicon.ico')
        ];
    }

    /**
     * Obter configurações de segurança
     */
    public static function getSecurityConfigs()
    {
        return [
            'max_file_size' => self::getInt('max_file_size', 10485760),
            'allowed_file_types' => self::getJson('allowed_file_types', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'txt']),
            'session_timeout' => self::getInt('session_timeout', 3600)
        ];
    }

    /**
     * Limpar todos os caches de configuração
     */
    public static function clearCache()
    {
        $configs = SystemConfig::all();
        foreach ($configs as $config) {
            Cache::forget("config.{$config->key}");
        }
        Cache::forget('system_configs');
        Cache::forget('public_configs');
    }
} 