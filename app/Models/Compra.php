<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'adscripciones';

    protected $fillable = [
        'numero',
        'anio',
        'inicio_publicidad',
        'cierre_publicidad',
        'inicio_inscripcion',
        'cierre_inscripcion',
        'fecha_adscripcion',
        'cliente_id',
        'tipo_adscripcion',
        'modalidad_adscripcion',
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
        return $this->hasMany(EstadoAdscripcion::class);
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

    // Mantener nombres legacy para no tocar vistas/controladores
    public function asignaturas()
    {
        return $this->belongsToMany(Venta::class, 'adscripcion_asignatura')->withTimestamps();
    }

    public function departamentos()
    {
        return $this->belongsToMany(Departamento::class, 'adscripcion_departamento')->withTimestamps();
    }

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'adscripcion_carrera')->withTimestamps();
    }

    public function docentes()
    {
        return $this->belongsToMany(Reparto::class, 'adscripcion_docente')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Vehiculo::class, 'adscripcion_estudiante')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function veedores()
    {
        return $this->belongsToMany(Vendedor::class, 'adscripcion_veedor')->withTimestamps();
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'adscripcion_proveedor')->withTimestamps();
    }

    public function docentesTitulares()
    {
        return $this->belongsToMany(Reparto::class, 'adscripcion_docente')
            ->wherePivot('tipo', 'titular')
            ->withTimestamps();
    }

    public function docentesSuplentes()
    {
        return $this->belongsToMany(Reparto::class, 'adscripcion_docente')
            ->wherePivot('tipo', 'suplente')
            ->withTimestamps();
    }

    public function estudiantesTitulares()
    {
        return $this->belongsToMany(Vehiculo::class, 'adscripcion_estudiante')
            ->wherePivot('tipo', 'titular')
            ->withTimestamps();
    }

    public function estudiantesSuplentes()
    {
        return $this->belongsToMany(Vehiculo::class, 'adscripcion_estudiante')
            ->wherePivot('tipo', 'suplente')
            ->withTimestamps();
    }

    public function designado()
    {
        return $this->belongsTo(Proveedor::class, 'designado_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoAdscripcion::class, 'adscripcion_id');
    }
}
