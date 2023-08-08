<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    // agregado para los permisos
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'dni',
        'country',
        'state',
        'address',
        'telephone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeEmail($query, string $email)
    {
        if ($email) {
            return $query->where('email',"$email");
        }
    }

    public function scopeName($query, string $name)
    {
        if ($name) {
            return $query->where('name','like','%'.$name.'%');
        }
    }

    public function scopeUserId($query, string $user_id)
    {
        if ($user_id) {
            return $query->where('user_id','like','%'.$user_id.'%');
        }
    }
}
