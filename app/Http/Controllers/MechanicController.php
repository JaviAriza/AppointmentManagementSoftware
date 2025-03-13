<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

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
