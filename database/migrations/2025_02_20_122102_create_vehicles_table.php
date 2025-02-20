<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.vehiculos
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('int','auto_increment','primary_key');
            $table->client_id('int','foreign_key');
            $table->string('brand');
            $table->string('model');
            $table->string('license_plate');
            $table->boolean('validated');
            $table->int('year');
            $table->string('state');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
