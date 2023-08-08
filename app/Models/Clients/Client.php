<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasFactory;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'doc_customer',
        'name',
        'email',
        'phone',
        'business_address',
        'api_status',
        'active',
        'address_delivery',
        'state',
        'city',
        'type_tax_1',
        'credit_limit',
        'web_customer',
        'local_customer'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeEmail($query, string $email)
    {
        if ($email) {
            return $query->where('email','like','%'.$email.'%');
        }
    }

    public function scopeName($query, string $name)
    {
        if ($name) {
            return $query->where('name','like','%'.$name.'%');
        }
    }
    
    public function scopeDni($query, string $dni)
    {
        if ($dni) {
            return $query->where('doc_customer','like','%'.$dni.'%');
        }
    }

    public function scopeActive($query, string $active)
    {
        if ($active) {
            return $query->where('active',$active);
        }
    }

    public function scopeStatus($query, string $status)
    {
        if ($status) {
            return $query->where('api_status',$status);
        }
    }
}
