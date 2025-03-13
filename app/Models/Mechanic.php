<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mechanic extends Authenticatable
{
    use HasFactory;

    protected $table = 'mechanic'; // 🔹 Especificamos la tabla

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];

    // 🔹 Relación con vehículos
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'mechanic_id');
    }
}
