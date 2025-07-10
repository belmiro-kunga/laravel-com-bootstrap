<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Registrar um log de auditoria
     */
    public static function log($event, $description = null, $auditable = null, $oldValues = null, $newValues = null, $metadata = [])
    {
        try {
            $user = Auth::user();
            
            return AuditLog::create([
                'event' => $event,
                'auditable_type' => $auditable ? get_class($auditable) : null,
                'auditable_id' => $auditable ? $auditable->id : null,
                'user_id' => $user ? $user->id : null,
                'user_type' => $user ? $user->role : null,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'description' => $description,
                'url' => Request::fullUrl(),
                'method' => Request::method(),
                'metadata' => $metadata
            ]);
        } catch (\Exception $e) {
            // Log do erro mas não interromper o fluxo
            \Log::error('Erro ao registrar log de auditoria: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log para criação de modelo
     */
    public static function logCreated($model, $description = null)
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} criado";
        
        return self::log('created', $description, $model, null, $model->getAttributes());
    }

    /**
     * Log para atualização de modelo
     */
    public static function logUpdated($model, $oldValues, $description = null)
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} atualizado";
        
        return self::log('updated', $description, $model, $oldValues, $model->getAttributes());
    }

    /**
     * Log para exclusão de modelo
     */
    public static function logDeleted($model, $description = null)
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} excluído";
        
        return self::log('deleted', $description, $model, $model->getAttributes(), null);
    }

    /**
     * Log para restauração de modelo (soft delete)
     */
    public static function logRestored($model, $description = null)
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} restaurado";
        
        return self::log('restored', $description, $model);
    }

    /**
     * Log para login
     */
    public static function logLogin($user, $description = null)
    {
        $description = $description ?? "Login realizado por {$user->name}";
        
        return self::log('login', $description, $user);
    }

    /**
     * Log para logout
     */
    public static function logLogout($user, $description = null)
    {
        $description = $description ?? "Logout realizado por {$user->name}";
        
        return self::log('logout', $description, $user);
    }

    /**
     * Log para alteração de senha
     */
    public static function logPasswordChanged($user, $description = null)
    {
        $description = $description ?? "Senha alterada por {$user->name}";
        
        return self::log('password_changed', $description, $user);
    }

    /**
     * Log para concessão de permissão
     */
    public static function logPermissionGranted($user, $permission, $grantedBy = null, $description = null)
    {
        $description = $description ?? "Permissão '{$permission->name}' concedida a {$user->name}";
        
        return self::log('permission_granted', $description, $user, null, null, [
            'permission_id' => $permission->id,
            'permission_name' => $permission->name,
            'granted_by' => $grantedBy ? $grantedBy->id : null
        ]);
    }

    /**
     * Log para revogação de permissão
     */
    public static function logPermissionRevoked($user, $permission, $revokedBy = null, $description = null)
    {
        $description = $description ?? "Permissão '{$permission->name}' revogada de {$user->name}";
        
        return self::log('permission_revoked', $description, $user, null, null, [
            'permission_id' => $permission->id,
            'permission_name' => $permission->name,
            'revoked_by' => $revokedBy ? $revokedBy->id : null
        ]);
    }

    /**
     * Log para upload de arquivo
     */
    public static function logFileUploaded($file, $model = null, $description = null)
    {
        $description = $description ?? "Arquivo '{$file->getClientOriginalName()}' enviado";
        
        return self::log('file_uploaded', $description, $model, null, null, [
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType()
        ]);
    }

    /**
     * Log para download de arquivo
     */
    public static function logFileDownloaded($file, $model = null, $description = null)
    {
        $description = $description ?? "Arquivo '{$file->nome_original}' baixado";
        
        return self::log('file_downloaded', $description, $model, null, null, [
            'file_name' => $file->nome_original,
            'file_size' => $file->tamanho,
            'file_type' => $file->tipo_mime
        ]);
    }

    /**
     * Log para adição de comentário
     */
    public static function logCommentAdded($comment, $description = null)
    {
        $description = $description ?? "Comentário adicionado à denúncia #{$comment->denuncia->protocolo}";
        
        return self::log('comment_added', $description, $comment);
    }

    /**
     * Log para alteração de status
     */
    public static function logStatusChanged($denuncia, $oldStatus, $newStatus, $description = null)
    {
        $description = $description ?? "Status alterado de '{$oldStatus->nome}' para '{$newStatus->nome}'";
        
        return self::log('status_changed', $description, $denuncia, [
            'status_id' => $oldStatus->id,
            'status_name' => $oldStatus->nome
        ], [
            'status_id' => $newStatus->id,
            'status_name' => $newStatus->nome
        ]);
    }

    /**
     * Log para atribuição de responsável
     */
    public static function logResponsibleAssigned($denuncia, $oldResponsible, $newResponsible, $description = null)
    {
        $oldName = $oldResponsible ? $oldResponsible->name : 'Nenhum';
        $newName = $newResponsible ? $newResponsible->name : 'Nenhum';
        $description = $description ?? "Responsável alterado de '{$oldName}' para '{$newName}'";
        
        return self::log('responsible_assigned', $description, $denuncia, [
            'responsible_id' => $oldResponsible ? $oldResponsible->id : null,
            'responsible_name' => $oldName
        ], [
            'responsible_id' => $newResponsible ? $newResponsible->id : null,
            'responsible_name' => $newName
        ]);
    }

    /**
     * Log para ação customizada
     */
    public static function logCustom($event, $description, $model = null, $metadata = [])
    {
        return self::log($event, $description, $model, null, null, $metadata);
    }

    /**
     * Log para rastreamento de denúncia (acesso público)
     */
    public static function logRastreamento($denuncia, $ip, $userAgent, $description = null)
    {
        $description = $description ?? "Consulta pública à denúncia #{$denuncia->protocolo}";
        
        return AuditLog::create([
            'event' => 'public_tracking',
            'auditable_type' => get_class($denuncia),
            'auditable_id' => $denuncia->id,
            'user_id' => null, // Usuário não autenticado
            'user_type' => 'public',
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'old_values' => null,
            'new_values' => null,
            'description' => $description,
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'metadata' => [
                'protocolo' => $denuncia->protocolo,
                'status' => $denuncia->status->nome,
                'categoria' => $denuncia->categoria->nome
            ]
        ]);
    }

    /**
     * Log para download de PDF de denúncia (acesso público)
     */
    public static function logDownloadPDF($denuncia, $ip, $userAgent, $description = null)
    {
        $description = $description ?? "Download de PDF da denúncia #{$denuncia->protocolo}";
        
        return AuditLog::create([
            'event' => 'public_pdf_download',
            'auditable_type' => get_class($denuncia),
            'auditable_id' => $denuncia->id,
            'user_id' => null, // Usuário não autenticado
            'user_type' => 'public',
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'old_values' => null,
            'new_values' => null,
            'description' => $description,
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'metadata' => [
                'protocolo' => $denuncia->protocolo,
                'status' => $denuncia->status->nome,
                'categoria' => $denuncia->categoria->nome
            ]
        ]);
    }
}