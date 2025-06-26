<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles,SoftDeletes;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_apellido',
        'email',
        'password',
        'fecha_ingreso',
        'estado',
        'genero',
        'fotografia',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute()
    {
        return $this->nombre_apellido;
    }
}
