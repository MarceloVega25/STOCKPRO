<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adscripcion extends Model 
{
    protected $table = 'adscripciones'; // <- Forzamos el nombre correcto}
    
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'numero',
        'anio',
        'inicio_publicidad',
        'cierre_publicidad',
        'inicio_inscripcion',
        'cierre_inscripcion',
        'fecha_adscripcion',
        'jerarquia_id',
        'tipo_adscripcion',
        'modalidad_adscripcion',
        'expediente',
        'observaciones',
        'estado',
        'comentario', 
        'designado_id',

    ];

    // Relación con jerarquía
    public function jerarquia()
    {
        return $this->belongsTo(Jerarquia::class);
    }

    // Relación con estados (bitácora)
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

    // Accesor para mostrar el código "numero/año"
    public function getCodigoAttribute()
    {
        return $this->numero . '/' . $this->anio;
    }

    // Relaciones con tablas intermedias
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'adscripcion_asignatura')->withTimestamps();
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
        return $this->belongsToMany(Docente::class, 'adscripcion_docente')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'adscripcion_estudiante')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function veedores()
    {
        return $this->belongsToMany(Veedor::class, 'adscripcion_veedor')->withTimestamps();
    }

    public function adscriptos()
    {
        return $this->belongsToMany(Adscripto::class, 'adscripcion_adscripto')->withTimestamps();
    }

    // Relaciones filtradas (docentes)
    public function docentesTitulares()
{
    return $this->belongsToMany(Docente::class, 'adscripcion_docente')
        ->wherePivot('tipo', 'titular')
        ->withTimestamps();
}

public function docentesSuplentes()
{
    return $this->belongsToMany(Docente::class, 'adscripcion_docente')
        ->wherePivot('tipo', 'suplente')
        ->withTimestamps();
}


    // Relaciones filtradas (estudiantes)
    public function estudiantesTitulares()
    {
        return $this->belongsToMany(Estudiante::class, 'adscripcion_estudiante')
            ->wherePivot('tipo', 'titular')
            ->withTimestamps();
    }

    public function estudiantesSuplentes()
    {
        return $this->belongsToMany(Estudiante::class, 'adscripcion_estudiante')
            ->wherePivot('tipo', 'suplente')
            ->withTimestamps();
    }

    public function designado()
{
    return $this->belongsTo(\App\Models\Adscripto::class, 'designado_id');
}

public function seguimientos()
{
    return $this->hasMany(\App\Models\SeguimientoAdscripcion::class, 'adscripcion_id');
}


}
