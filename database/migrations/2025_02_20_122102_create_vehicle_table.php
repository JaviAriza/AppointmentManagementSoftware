<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('brand');
            $table->string('model');
            $table->string('license_plate')->unique();
            $table->boolean('validated')->default(false);
            $table->year('year');
            $table->enum('status', ['In queue', 'In reparation', 'Reparated'])->default('In queue');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle');
    }
}
