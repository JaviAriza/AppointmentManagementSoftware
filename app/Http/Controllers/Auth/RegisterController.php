<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
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
            'phone' => ['required', 'regex:/^\d{9}$/'],
            'dni' => ['required', 'regex:/^\d{8}[A-Za-z]$/', 'unique:client,dni'],
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

        Auth::login($client);

        return $client;
    }
}
