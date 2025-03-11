<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla explícitamente
    protected $table = 'vehicle';

    // Especificar los campos que pueden ser asignados masivamente
    protected $fillable = [
        'client_id',
        'brand',
        'model',
        'license_plate',
        'validated',
        'year',
        'status',
    ];

    // Definir la relación belongsTo con el modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Asegurarse de que se manejen las columnas created_at y updated_at
    public $timestamps = true;
}

