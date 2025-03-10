<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api')->group(function () {
    Route::apiResource('cursos', CursoController::class);
    Route::apiResource('estudiantes', EstudianteController::class);
    Route::apiResource('inscripciones', InscripcionController::class);
});