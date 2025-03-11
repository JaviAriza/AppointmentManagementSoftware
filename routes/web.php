<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return view('auth.login'); // // Vista
})->name('login');

// Proceso de login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Página de registro (formulario)
Route::get('/register', function () {
    return view('auth.register'); // Vista
})->name('register');

// Proceso de registro
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Dashboards después del login
Route::get('/dashboard-client', function () {
    return view('dashboard.client'); // Asegúrate de tener esta vista en resources/views/dashboard/client.blade.php
})->middleware('auth')->name('dashboard.client');

Route::get('/dashboard-mechanic', function () {
    return view('dashboard.mechanic'); // Asegúrate de tener esta vista en resources/views/dashboard/mechanic.blade.php
})->middleware('auth')->name('dashboard.mechanic');


// Nueva ruta: Procesa el formulario para guardar un vehículo
// Usa el middleware 'auth' para asegurar que solo usuarios autenticados puedan acceder
Route::post('/vehicle/guardar', [VehicleController::class, 'guardarVehiculo'])->middleware('auth')->name('vehicle.guardar');

// Rutas API para vehículos (mantener las existentes)
// Agrupadas con el prefijo 'api' para mantener la organización
Route::prefix('api')->group(function () {
    Route::post('/vehicles', [VehicleController::class, 'crearVehiculo']);
    Route::get('/vehicle/obtener', [VehicleController::class, 'obtenerVehiculos'])->name('vehicle.obtener');
});


