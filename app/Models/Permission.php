<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Permission extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'group',
        'active',
        'order'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relacionamentos
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions')
                    ->withPivot('granted', 'granted_at', 'granted_by')
                    ->withTimestamps();
    }

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Acessors
    public function getIsMenuAttribute()
    {
        return $this->category === 'menu';
    }

    public function getIsFunctionAttribute()
    {
        return $this->category === 'function';
    }

    // Métodos
    public function isGrantedToUser($userId)
    {
        return $this->userPermissions()
                   ->where('user_id', $userId)
                   ->where('granted', true)
                   ->exists();
    }

    public function grantToUser($userId, $grantedBy = null)
    {
        return $this->userPermissions()->updateOrCreate(
            ['user_id' => $userId],
            [
                'granted' => true,
                'granted_at' => now(),
                'granted_by' => $grantedBy
            ]
        );
    }

    public function revokeFromUser($userId)
    {
        return $this->userPermissions()
                   ->where('user_id', $userId)
                   ->update(['granted' => false]);
    }
}
