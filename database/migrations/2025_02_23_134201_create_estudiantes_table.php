<?php

use App\Models\Campo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTable extends Migration
{
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100);
            $table->string('correo', 100)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['M', 'F']);
            $table->enum('tipo_documento', ['CI', 'PASAPORTE'])->default('CI');
            $table->string('nro_documento', 20)->nullable();;
            $table->string('complemento', 5)->nullable();
            $table->enum('expedido', ['LP', 'CB', 'SC', 'OR', 'PT', 'TJ', 'BN', 'PA', 'CH'])->nullable();
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->enum('estado_registro', ['SIN REGISTRAR', 'REGISTRADO'])->default('SIN REGISTRAR');              
            $table->timestamps();           
            $table->unique('correo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
}
