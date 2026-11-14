<?php

use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

/*
| Rutas de la API (Laravel agrega automáticamente el prefijo /api):
|
|   GET     /api/vehiculos              -> index    (listar)
|   POST    /api/vehiculos              -> store    (crear)
|   GET     /api/vehiculos/{vehiculo}   -> show     (consultar por id)
|   PUT     /api/vehiculos/{vehiculo}   -> update   (actualizar)
|   DELETE  /api/vehiculos/{vehiculo}   -> destroy  (eliminar)
*/

Route::apiResource('vehiculos', VehiculoController::class);
