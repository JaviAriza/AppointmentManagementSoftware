<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    // Obtener lista de vehículos
    public function obtenerVehiculos()
    {
        return response()->json(Vehicle::all(), 200);
    }

    // Obtener un vehículo por ID
    public function obtenerVehiculoId($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }
        return response()->json($vehicle, 200);
    }

    // Crear un nuevo vehículo
    public function crearVehiculo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:30',
            'license_plate' => 'required|string|unique:vehicles,license_plate',
            'validated' => 'boolean',
            'status' => 'required|in:In queue,In reparation,Reparated',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $vehicle = Vehicle::create($validator->validated());
        return response()->json($vehicle, 201);
    }

    // Actualizar un vehículo
    public function actualizarVehiculo(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $vehicle->update($validator->validated());
        return response()->json($vehicle, 200);
    }

    // Actualizar parcialmente un vehículo
    public function actualizarParcialVehiculo(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'brand' => 'sometimes|string|max:50',
            'model' => 'sometimes|string|max:50',
            'year' => 'sometimes|integer|digits:4|min:1900|max:' . date('Y'),
            'color' => 'sometimes|string|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $vehicle->update($validator->validated());
        return response()->json($vehicle, 200);
    }

    // Eliminar un vehículo
    public function eliminarVehiculo($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        $vehicle->delete();
        return response()->json(['message' => 'Vehículo eliminado'], 200);
    }
}
