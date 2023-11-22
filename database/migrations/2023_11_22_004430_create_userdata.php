<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('userdata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iduser');
            $table->string('nombre', 128);
            $table->string('foto', 256)->nullable();
            $table->integer('edad');
            $table->text('acercade');
            $table->string('genero', 64);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userdata');
    }
};
