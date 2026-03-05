<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compras';

    protected $fillable = [
        'numero',
        'anio',
        'inicio_publicidad',
        'cierre_publicidad',
        'inicio_inscripcion',
        'cierre_inscripcion',
        'fecha_compra',
        'cliente_id',
        'tipo_compra',
        'modalidad_compra',
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
        return $this->hasMany(EstadoCompra::class, 'compra_id');
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
        return $this->belongsToMany(Venta::class, 'compra_venta')->withTimestamps();
    }

    public function departamentos()
    {
        return $this->belongsToMany(Departamento::class, 'compra_departamento')->withTimestamps();
    }

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'compra_carrera')->withTimestamps();
    }

    public function repartos()
    {
        return $this->belongsToMany(Reparto::class, 'compra_reparto')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'compra_vehiculo')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function vendedores()
    {
        return $this->belongsToMany(Vendedor::class, 'compra_vendedor')->withTimestamps();
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'compra_proveedor')->withTimestamps();
    }

    public function repartosTitulares()
    {
        return $this->belongsToMany(Reparto::class, 'compra_reparto')
            ->wherePivot('tipo', 'titular')
            ->withTimestamps();
    }

    public function repartosSuplentes()
    {
        return $this->belongsToMany(Reparto::class, 'compra_reparto')
            ->wherePivot('tipo', 'suplente')
            ->withTimestamps();
    }

    public function vehiculosTitulares()
    {
        return $this->belongsToMany(Vehiculo::class, 'compra_vehiculo')
            ->wherePivot('tipo', 'titular')
            ->withTimestamps();
    }

    public function vehiculosSuplentes()
    {
        return $this->belongsToMany(Vehiculo::class, 'compra_vehiculo')
            ->wherePivot('tipo', 'suplente')
            ->withTimestamps();
    }

    public function designado()
    {
        return $this->belongsTo(Proveedor::class, 'designado_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoCompra::class, 'compra_id');
    }
}
