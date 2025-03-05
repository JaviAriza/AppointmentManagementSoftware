<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Añadido para consultas directas
use Illuminate\Support\Facades\Log; // Añadido para logging

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

    /**
     * Muestra el dashboard del cliente con sus vehículos
     * Mejorado con depuración y consulta directa
     */
    public function mostrarFormulario()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Logging para depuración
        Log::info('Usuario autenticado:', ['id' => $user->id, 'email' => $user->email]);

        // Intentar obtener el cliente de diferentes maneras

        // 1. Primero, intentar obtener el cliente por email
        $clientByEmail = Client::where('email', $user->email)->first();

        // 2. Si no funciona, intentar obtener el cliente por ID (asumiendo que el ID del usuario podría ser el mismo que el ID del cliente)
        $clientById = $clientByEmail ?? Client::find($user->id);

        // 3. Si aún no funciona, intentar una consulta directa a la base de datos
        if (!$clientById) {
            // Consulta directa a la tabla clients
            $clientFromDB = DB::table('clients')->where('email', $user->email)->first();

            // Si encontramos el cliente en la base de datos, convertirlo a un modelo Client
            if ($clientFromDB) {
                $clientById = new Client();
                $clientById->id = $clientFromDB->id;
                $clientById->name = $clientFromDB->name;
                $clientById->email = $clientFromDB->email;
            }
        }

        // Usar el cliente que hayamos encontrado
        $client = $clientById;

        // Logging para depuración
        if ($client) {
            Log::info('Cliente encontrado:', ['id' => $client->id, 'email' => $client->email]);
        } else {
            Log::warning('No se encontró el cliente para el usuario:', ['user_id' => $user->id, 'email' => $user->email]);
        }

        // Si no encontramos el cliente, mostrar la vista sin vehículos
        if (!$client) {
            return view('dashboard.client', [
                'vehicles' => [],
                'debug' => [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'message' => 'No se encontró el cliente asociado a este usuario'
                ]
            ]);
        }

        // Intentar obtener los vehículos de diferentes maneras

        // 1. Primero, intentar usar la relación del modelo
        try {
            $vehiclesByRelation = $client->vehicles;
        } catch (\Exception $e) {
            $vehiclesByRelation = [];
            Log::error('Error al obtener vehículos por relación:', ['error' => $e->getMessage()]);
        }

        // 2. Si no funciona, intentar una consulta directa
        $vehiclesByQuery = Vehicle::where('client_id', $client->id)->get();

        // 3. Si aún no funciona, intentar una consulta directa a la base de datos
        $vehiclesFromDB = DB::table('vehicle')->where('client_id', $client->id)->get();

        // Logging para depuración
        Log::info('Vehículos encontrados:', [
            'por_relacion' => count($vehiclesByRelation),
            'por_query' => count($vehiclesByQuery),
            'desde_db' => count($vehiclesFromDB)
        ]);

        // Usar los vehículos que hayamos encontrado (preferir la consulta directa para este caso)
        $vehicles = count($vehiclesByQuery) > 0 ? $vehiclesByQuery : $vehiclesFromDB;

        // Pasar los vehículos y la información de depuración a la vista
        return view('dashboard.client', [
            'vehicles' => $vehicles,
            'client' => $client,
            'debug' => [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'client_id' => $client->id,
                'client_email' => $client->email,
                'vehicles_count' => count($vehicles),
                'vehicles_by_relation' => count($vehiclesByRelation),
                'vehicles_by_query' => count($vehiclesByQuery),
                'vehicles_from_db' => count($vehiclesFromDB)
            ]
        ]);
    }

    /**
     * Procesa el formulario web para crear un vehículo
     * Mejorado con depuración y manejo de errores
     */
    public function guardarVehiculo(Request $request)
    {
        // Validamos los datos del formulario
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'license_plate' => 'required|string|unique:vehicle,license_plate',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Logging para depuración
        Log::info('Guardando vehículo para usuario:', ['id' => $user->id, 'email' => $user->email]);

        // Intentar obtener el cliente de diferentes maneras (igual que en mostrarFormulario)
        $clientByEmail = Client::where('email', $user->email)->first();
        $clientById = $clientByEmail ?? Client::find($user->id);

        if (!$clientById) {
            $clientFromDB = DB::table('clients')->where('email', $user->email)->first();

            if ($clientFromDB) {
                $clientById = new Client();
                $clientById->id = $clientFromDB->id;
                $clientById->name = $clientFromDB->name;
                $clientById->email = $clientFromDB->email;
            }
        }

        $client = $clientById;

        // Si no encontramos el cliente, mostrar un error
        if (!$client) {
            Log::error('No se encontró el cliente al guardar vehículo:', ['user_id' => $user->id, 'email' => $user->email]);

            return redirect()->back()
                ->with('error', 'No se pudo encontrar el cliente asociado a su cuenta. Por favor, contacte al administrador.')
                ->withInput();
        }

        try {
            // Crear el vehículo con los datos validados
            $vehicle = new Vehicle();
            $vehicle->client_id = $client->id;
            $vehicle->brand = $request->brand;
            $vehicle->model = $request->model;
            $vehicle->year = $request->year;
            $vehicle->license_plate = $request->license_plate;
            $vehicle->validated = false;
            $vehicle->status = 'In queue';
            $vehicle->save();

            // Logging para depuración
            Log::info('Vehículo guardado correctamente:', [
                'id' => $vehicle->id,
                'client_id' => $vehicle->client_id,
                'brand' => $vehicle->brand,
                'model' => $vehicle->model
            ]);

            // Verificar que el vehículo se guardó correctamente
            $savedVehicle = Vehicle::find($vehicle->id);

            if (!$savedVehicle) {
                Log::error('El vehículo no se guardó correctamente:', ['vehicle_id' => $vehicle->id]);

                return redirect()->back()
                    ->with('error', 'El vehículo no se guardó correctamente. Por favor, inténtelo de nuevo.')
                    ->withInput();
            }

            // Redirigir al dashboard con un mensaje de éxito
            // Usamos route() para asegurarnos de que pase por el controlador
            return redirect()->route('dashboard.client')
                ->with('success', 'Vehículo registrado correctamente');

        } catch (\Exception $e) {
            // Logging para depuración
            Log::error('Error al guardar vehículo:', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Error al guardar el vehículo: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Crear un nuevo vehículo (API)
    public function crearVehiculo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'license_plate' => 'required|string|unique:vehicle,license_plate',
            'validated' => 'boolean',
            'status' => 'required|in:In queue,In reparation,Reparated',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $vehicle = Vehicle::create($validator->validated());
        return response()->json($vehicle, 201);
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

