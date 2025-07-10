<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Auditable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ativo',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ativo' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // Relacionamentos
    public function denunciasResponsavel()
    {
        return $this->hasMany(Denuncia::class, 'responsavel_id');
    }

    public function denuncias()
    {
        return $this->hasMany(Denuncia::class, 'responsavel_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')
                    ->withPivot('granted', 'granted_at', 'granted_by')
                    ->withTimestamps();
    }

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeResponsaveis($query)
    {
        return $query->whereIn('role', ['admin', 'responsavel']);
    }

    // Acessors
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    public function getIsResponsavelAttribute()
    {
        return in_array($this->role, ['admin', 'responsavel']);
    }

    public function getRoleLabelAttribute()
    {
        $labels = [
            'admin' => 'Administrador',
            'responsavel' => 'Responsável',
            'usuario' => 'Usuário'
        ];
        return $labels[$this->role] ?? 'Usuário';
    }

    public function getRoleCorAttribute()
    {
        $cores = [
            'admin' => 'danger',
            'responsavel' => 'warning',
            'usuario' => 'info'
        ];
        return $cores[$this->role] ?? 'info';
    }

    public function getDenunciasPendentesCountAttribute()
    {
        return $this->denunciasResponsavel()
                   ->whereNotIn('status_id', Status::finalizadores()->pluck('id'))
                   ->count();
    }

    public function getDenunciasAtrasadasCountAttribute()
    {
        return $this->denunciasResponsavel()->atrasadas()->count();
    }

    // Métodos
    public function podeGerenciarDenuncias()
    {
        return $this->is_admin || $this->is_responsavel;
    }

    public function podeVerTodasDenuncias()
    {
        return $this->is_admin;
    }

    public function podeGerenciarUsuarios()
    {
        return $this->is_admin;
    }

    public function podeGerenciarCategorias()
    {
        return $this->is_admin;
    }

    public function podeGerenciarStatus()
    {
        return $this->is_admin;
    }

    public function podeVerRelatorios()
    {
        return $this->is_admin || $this->is_responsavel;
    }

    public function podeVerComentariosInternos()
    {
        return $this->is_admin || $this->is_responsavel;
    }

    public function podeVerEvidenciasPrivadas()
    {
        return $this->is_admin || $this->is_responsavel;
    }

    // Métodos de permissões personalizadas
    public function hasPermission($permissionSlug)
    {
        // Se for admin, tem todas as permissões
        if ($this->is_admin) {
            return true;
        }

        return $this->permissions()
                   ->where('slug', $permissionSlug)
                   ->where('active', true)
                   ->wherePivot('granted', true)
                   ->exists();
    }

    public function hasAnyPermission($permissionSlugs)
    {
        if (!is_array($permissionSlugs)) {
            $permissionSlugs = [$permissionSlugs];
        }

        // Se for admin, tem todas as permissões
        if ($this->is_admin) {
            return true;
        }

        return $this->permissions()
                   ->whereIn('slug', $permissionSlugs)
                   ->where('active', true)
                   ->wherePivot('granted', true)
                   ->exists();
    }

    public function hasAllPermissions($permissionSlugs)
    {
        if (!is_array($permissionSlugs)) {
            $permissionSlugs = [$permissionSlugs];
        }

        // Se for admin, tem todas as permissões
        if ($this->is_admin) {
            return true;
        }

        $userPermissions = $this->permissions()
                               ->whereIn('slug', $permissionSlugs)
                               ->where('active', true)
                               ->wherePivot('granted', true)
                               ->pluck('slug')
                               ->toArray();

        return count(array_intersect($permissionSlugs, $userPermissions)) === count($permissionSlugs);
    }

    public function getGrantedPermissions()
    {
        return $this->permissions()
                   ->where('active', true)
                   ->wherePivot('granted', true)
                   ->orderBy('order')
                   ->orderBy('name')
                   ->get();
    }

    public function getMenuPermissions()
    {
        return $this->permissions()
                   ->where('active', true)
                   ->where('category', 'menu')
                   ->wherePivot('granted', true)
                   ->orderBy('order')
                   ->orderBy('name')
                   ->get();
    }

    public function grantPermission($permissionSlug, $grantedBy = null)
    {
        $permission = Permission::where('slug', $permissionSlug)->first();
        
        if (!$permission) {
            return false;
        }

        return $permission->grantToUser($this->id, $grantedBy);
    }

    public function revokePermission($permissionSlug)
    {
        $permission = Permission::where('slug', $permissionSlug)->first();
        
        if (!$permission) {
            return false;
        }

        return $permission->revokeFromUser($this->id);
    }

    public function syncPermissions($permissionSlugs, $grantedBy = null)
    {
        // Revogar todas as permissões atuais
        $this->userPermissions()->update(['granted' => false]);

        // Conceder as novas permissões
        foreach ($permissionSlugs as $slug) {
            $this->grantPermission($slug, $grantedBy);
        }

        return true;
    }
}
