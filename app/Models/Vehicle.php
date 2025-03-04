<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla si no es el plural por defecto de "vehicle"
    protected $table = 'vehicle';

    // Especificar los campos que pueden ser asignados masivamente (atributos "fillable")
    protected $fillable = [
        'client_id',
        'brand',
        'model',
        'license_plate',
        'validated',
        'year',
        'status',
    ];

    // Si la tabla usa otro tipo de clave primaria, puedes configurarla aquí:
    protected $primaryKey = 'id';

    // Definir la relación belongsTo con el modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Si no deseas que se manejen las columnas created_at y updated_at automáticamente, puedes deshabilitarlas
    public $timestamps = true;
}
