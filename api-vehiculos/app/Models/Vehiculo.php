<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';

    /**
     * Campos que se pueden asignar desde la petición (crear / actualizar).
     */
    protected $fillable = ['marca', 'modelo', 'anio', 'color'];

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
        ];
    }

    /**
     * Muestra las fechas en el JSON como "2026-11-14 08:30:00" (hora local).
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
