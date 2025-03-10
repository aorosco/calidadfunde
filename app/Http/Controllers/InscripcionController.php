<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Importa la excepción

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::all();
        return response()->json($inscripciones);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([ // Reglas de validación
                'cursos_id' => 'required|exists:cursos,id',
                'estudiantes_id' => 'required|exists:estudiantes,id',
                'gestion' => 'required|integer',
                'estado' => 'in:PENDIENTE,CON CREDENCIALES,REGISTRO DE DATOS,CONCLUIDO,CANCELADO',
                'documentos_completos' => 'boolean',
                'observacion' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // 422: Unprocessable Entity
        }

        $inscripcion = new Inscripcion();
        $inscripcion->fill($request->all());
        $inscripcion->save();
        return response()->json($inscripcion, 201);
    }

    public function show(Inscripcion $inscripcion)
    {
        return response()->json($inscripcion);
    }

    public function update(Request $request, Inscripcion $inscripcion)
    {
        try {
            $request->validate([ // Reglas de validación
                'cursos_id' => 'exists:cursos,id',
                'estudiantes_id' => 'exists:estudiantes,id',
                'gestion' => 'integer',
                'estado' => 'in:PENDIENTE,CON CREDENCIALES,REGISTRO DE DATOS,CONCLUIDO,CANCELADO',
                'documentos_completos' => 'boolean',
                'observacion' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $inscripcion->fill($request->all());
        $inscripcion->save();
        return response()->json($inscripcion);
    }

    public function destroy(Inscripcion $inscripcion)
    {
        $inscripcion->delete();
        return response()->json(null, 204);
    }
}