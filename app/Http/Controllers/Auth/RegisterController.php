<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client; // Modelo cambiado de User a Client
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirección después del registro.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard-client';

    /**
     * Crear una nueva instancia del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validación de datos de registro.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'String', 'regex:/^\+?\d{1,4}[-\s]?\(?\d{1,3}\)?[-\s]?\d{3}[-\s]?\d{3,4}$/', 'max:20'],
            'dni' => ['required', 'string', 'unique:client,dni'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:client,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crea un nuevo cliente después de un registro válido.
     *
     * @param  array  $data
     * @return \App\Models\Client
     */
    protected function create(array $data)
    {
        $client = Client::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'phone' => $data['phone'],
            'dni' => $data['dni'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($client); // Inicia sesión automáticamente después del registro

        return $client;
    }
}
