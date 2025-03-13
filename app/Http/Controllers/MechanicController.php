<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;

class MechanicController extends Controller
{
    public function obtenerVehiculos()
    {
        try {
            $vehicles = Vehicle::whereIn('status', ['In queue', 'In repair'])->get();
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener vehículos'], 500);
        }
    }
    public function actualizarVehiculo(Request $request, $id)
    {
        try {
            // Buscar el vehículo por su ID
            $vehicle = Vehicle::findOrFail($id);

            // Validar los datos enviados en la solicitud
            $validated = $request->validate([
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'license_plate' => 'required|string|max:255',
                'status' => 'required|string|in:In queue,In repair,Repaired',
                'validated' => 'required|boolean',  // Correcto: 'validated'
            ]);

            // Actualizar el vehículo con los nuevos datos
            $vehicle->brand = $validated['brand'];
            $vehicle->model = $validated['model'];
            $vehicle->license_plate = $validated['license_plate'];
            $vehicle->status = $validated['status'];
            $vehicle->validated = $validated['validated'];  // Correcto: 'validated'
            $vehicle->save();  // Guardar los cambios

            // Responder con éxito
            return response()->json(['success' => 'Vehículo actualizado correctamente']);

        } catch (\Exception $e) {
            // En caso de error, devolver una respuesta con el código de estado 500
            return response()->json(['error' => 'Error al actualizar el vehículo: ' . $e->getMessage()], 500);
        }
    }




    public function eliminarVehiculo($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            return response()->json(['success' => 'Vehículo eliminado']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }

    public function crearVehiculo(Request $request)
    {
        try {
            $vehicle = new Vehicle();
            $vehicle->brand = $request->brand;
            $vehicle->model = $request->model;
            $vehicle->license_plate = $request->license_plate;
            $vehicle->status = $request->status;
            $vehicle->verified = $request->verified;
            $vehicle->save();

            return response()->json(['success' => 'Vehículo creado']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el vehículo'], 500);
        }
    }
}
