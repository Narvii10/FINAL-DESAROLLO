<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehiculoRequest;
use App\Models\Vehiculo;
use Illuminate\Http\JsonResponse;

class VehiculoController extends Controller
{
    /**
     * GET /api/vehiculos — lista todos los vehículos.
     */
    public function index(): JsonResponse
    {
        return $this->json(Vehiculo::orderBy('id')->get(), 200);
    }

    /**
     * POST /api/vehiculos — crea un vehículo (201 Created).
     */
    public function store(VehiculoRequest $request): JsonResponse
    {
        $vehiculo = Vehiculo::create($request->validated());

        return $this->json($vehiculo->refresh(), 201);
    }

    /**
     * GET /api/vehiculos/{id} — consulta un vehículo por su id (404 si no existe).
     */
    public function show(Vehiculo $vehiculo): JsonResponse
    {
        return $this->json($vehiculo, 200);
    }

    /**
     * PUT /api/vehiculos/{id} — actualiza un vehículo.
     */
    public function update(VehiculoRequest $request, Vehiculo $vehiculo): JsonResponse
    {
        $vehiculo->update($request->validated());

        return $this->json($vehiculo, 200);
    }

    /**
     * DELETE /api/vehiculos/{id} — elimina un vehículo.
     */
    public function destroy(Vehiculo $vehiculo): JsonResponse
    {
        $id = $vehiculo->id;
        $vehiculo->delete();

        return $this->json(['mensaje' => 'Vehículo eliminado correctamente.', 'id' => $id], 200);
    }

    /**
     * Respuesta JSON que conserva tildes y eñes legibles.
     */
    private function json(mixed $datos, int $estado): JsonResponse
    {
        return response()->json($datos, $estado, [], JSON_UNESCAPED_UNICODE);
    }
}
