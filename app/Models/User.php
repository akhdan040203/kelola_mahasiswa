<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password', 
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function hasRole(string $roleName): bool{
        return $this->role?->name === $roleName;
    }

    public function hasPermission(string $permissionName): bool
    {

    if(!$this->role) return false;

    return $this->role->permissions()
    ->where('name', $permissionName)
    ->exists();
    }

    public function news (){
        return $this->hasMany(News::class, 'author_id');
    }
}
