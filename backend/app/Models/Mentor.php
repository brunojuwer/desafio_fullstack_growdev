<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mentor extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'cpf',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function booted()
    {
        static::creating(fn(Mentor $mentor) => $mentor->id = Str::uuid());
    }

    public static function search($value)
    {
        $query = static::query();
        $columns = ['name', 'cpf', 'email'];
        if ($value) {
            $query->where(function ($query) use ($columns, $value) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$value}%");
                }
            });
        }

        return $query;
    }
}
