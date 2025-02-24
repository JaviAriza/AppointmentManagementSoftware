<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller

{
public function login(Request $request)
    {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Primero, intenta buscar el usuario en la tabla 'clientes'
    $cliente = User::where('email', $request->email)->first();

    if ($cliente && Hash::check($request->password, $cliente->password)) {
        Auth::login($cliente); // Si es encontrado en la tabla cliente
        return redirect()->intended('/dashboard');
    }

    // Si no se encuentra en 'clientes', intenta en la tabla 'mechanics'
    $mechanic = Mechanic::where('email', $request->email)->first();

    if ($mechanic && Hash::check($request->password, $mechanic->password)) {
        Auth::login($mechanic); // Si es encontrado en la tabla mechanic
        return redirect()->intended('/dashboard');
    }

    // Si no se encuentra en ninguna de las dos tablas
    return redirect()->back()->withErrors(['email' => 'Credenciales no válidas']);

}}
