<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Client;
use App\Models\Mechanic;
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

        $client = Client::where('email', $request->email)->first();

        if ($client && Hash::check($request->password, $client->password)) {
            Auth::login($client);
            return redirect()->intended('/dashboard-client');
        }

        $mechanic = Mechanic::where('email', $request->email)->first();

        if ($mechanic && Hash::check($request->password, $mechanic->password)) {
            Auth::login($mechanic);
            return redirect()->intended('/dashboard-mechanic');
        }

        return redirect()->back()->withErrors(['email' => 'Credenciales no válidas']);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); 
    }

}
