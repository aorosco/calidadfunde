<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionTable extends Migration
{
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cursos_id')->constrained('cursos');
            $table->foreignId('estudiantes_id')->constrained('estudiantes');
            $table->integer('gestion');
            $table->enum('estado', ['PENDIENTE','CON CREDENCIALES', 'REGISTRO DE DATOS', 'CONCLUIDO', 'CANCELADO'])->default('PENDIENTE');
            $table->boolean('documentos_completos')->default(false);
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscriptions');
    }
}
