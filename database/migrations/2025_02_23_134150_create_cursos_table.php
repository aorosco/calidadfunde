<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->enum('nivel', ['INICIAL', 'PRIMARIA', 'SECUNDARIA']);
            $table->integer('grado');
            $table->char('paralelo', 1);
            $table->integer('capacidad_maxima');
            $table->timestamps();

            $table->unique(['nivel', 'grado', 'paralelo']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cursos');
    }
    
}