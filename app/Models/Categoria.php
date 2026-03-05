<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias';

    protected $fillable = [
        'numero',
        'anio',
        'inicio_publicidad',
        'cierre_publicidad',
        'inicio_inscripcion',
        'cierre_inscripcion',
        'fecha_concurso',
        'cliente_id',
        'tipo_concurso',
        'modalidad_concurso',
        'expediente',
        'observaciones',
        'estado',
        'comentario',
        'designado_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function estados()
    {
        return $this->hasMany(EstadoCategoria::class);
    }

    public function registrarEstado($estado, $comentario = null)
    {
        $this->estados()->create([
            'estado' => $estado,
            'comentario' => $comentario,
        ]);
    }

    public function getCodigoAttribute()
    {
        return $this->numero . '/' . $this->anio;
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'categoria_venta')->withTimestamps();
    }

    public function departamentos()
    {
        return $this->belongsToMany(Departamento::class, 'categoria_departamento')->withTimestamps();
    }

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'categoria_carrera')->withTimestamps();
    }

    public function repartos()
    {
        return $this->belongsToMany(Reparto::class, 'categoria_reparto')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'categoria_vehiculo')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function vendedores()
    {
        return $this->belongsToMany(Vendedor::class, 'categoria_vendedor')->withTimestamps();
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'categoria_producto')->withTimestamps();
    }

    public function repartosTitulares()
    {
        return $this->belongsToMany(Reparto::class, 'categoria_reparto')
            ->wherePivot('tipo', 'titular')
            ->withTimestamps();
    }

    public function repartosSuplentes()
    {
        return $this->belongsToMany(Reparto::class, 'categoria_reparto')
            ->wherePivot('tipo', 'suplente')
            ->withTimestamps();
    }

    public function vehiculosTitulares()
    {
        return $this->belongsToMany(Vehiculo::class, 'categoria_vehiculo')
            ->wherePivot('tipo', 'titular')
            ->withTimestamps();
    }

    public function vehiculosSuplentes()
    {
        return $this->belongsToMany(Vehiculo::class, 'categoria_vehiculo')
            ->wherePivot('tipo', 'suplente')
            ->withTimestamps();
    }

    public function designado()
    {
        return $this->belongsTo(Producto::class, 'designado_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoCategoria::class)->orderBy('fecha', 'desc');
    }
}
