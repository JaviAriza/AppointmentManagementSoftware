<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    /**
     * Ruta del archivo JSON donde se guardarán los vehículos.
     */
    private function getJsonFilePath($clientId)
    {
        return storage_path("app/vehicles_client_{$clientId}.json");
    }

    /**
     * Guarda los vehículos del cliente en un archivo JSON.
     */
    private function saveVehiclesToJson($clientId)
    {
        $vehicles = Vehicle::where('client_id', $clientId)->get();
        $filePath = $this->getJsonFilePath($clientId);
        File::put($filePath, json_encode($vehicles, JSON_PRETTY_PRINT));
    }

    /**
     * Muestra el formulario de registro de vehículos y obtiene los vehículos desde JSON.
     */
    public function mostrarFormulario()
    {
        $user = Auth::user();
        $client = Client::where('email', $user->email)->first() ?? Client::find($user->id);

        if (!$client) {
            return view('dashboard.client', ['vehicles' => [], 'debug' => ['message' => 'No se encontró el cliente']]);
        }

        $filePath = $this->getJsonFilePath($client->id);
        $vehicles = File::exists($filePath) ? json_decode(File::get($filePath)) : [];

        return view('dashboard.client', ['vehicles' => $vehicles, 'client' => $client]);
    }

    /**
     * Procesa el formulario para guardar un vehículo y actualiza el JSON.
     */
    public function guardarVehiculo(Request $request)
    {
        // Se mantiene el código original de inserción del vehículo
        $vehicle = new Vehicle();
        $vehicle->client_id = Auth::user()->id;
        $vehicle->brand = $request->brand;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->license_plate = $request->license_plate;
        $vehicle->validated = false;
        $vehicle->status = 'In queue';
        $vehicle->save();

        // Guardar vehículos actualizados en JSON
        $this->saveVehiclesToJson($vehicle->client_id);

        return redirect()->back()->with('success', 'Vehículo registrado correctamente.');
    }

    public function obtenerVehiculos()
    {

        $user = Auth::user();
        $client = Client::where('email', $user->email)->first() ?? Client::find($user->id);

        if (!$client) {
            return response()->json([]);
        }

        // Obtener vehículos directamente de la base de datos
        $vehicles = Vehicle::where('client_id', $client->id)->get();

        return response()->json($vehicles);
    }

}
