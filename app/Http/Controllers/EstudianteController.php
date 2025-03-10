<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::all();
        return response()->json($estudiantes);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([ // Reglas de validación
                'nombres' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'required|string|max:100',
                'correo' => 'nullable|email|max:100|unique:estudiantes,correo',
                'fecha_nacimiento' => 'nullable|date',
                'genero' => 'required|in:M,F',
                'tipo_documento' => 'in:CI,PASAPORTE',
                'nro_documento' => 'nullable|string|max:20',
                'complemento' => 'nullable|string|max:5',
                'expedido' => 'nullable|in:LP,CB,SC,OR,PT,TJ,BN,PA,CH',
                'estado' => 'in:ACTIVO,INACTIVO',
                'estado_registro' => 'in:SIN REGISTRAR,REGISTRADO',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $estudiante = new Estudiante();
        $estudiante->fill($request->all());
        $estudiante->save();
        return response()->json($estudiante, 201);
    }

    public function show(Estudiante $estudiante)
    {
        return response()->json($estudiante);
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        try {
            $request->validate([ // Reglas de validación
                'nombres' => 'string|max:100',
                'apellido_paterno' => 'string|max:100',
                'apellido_materno' => 'string|max:100',
                'correo' => 'email|max:100|unique:estudiantes,correo,' . $estudiante->id, // Ignora el correo del estudiante actual
                'fecha_nacimiento' => 'date',
                'genero' => 'in:M,F',
                'tipo_documento' => 'in:CI,PASAPORTE',
                'nro_documento' => 'string|max:20',
                'complemento' => 'string|max:5',
                'expedido' => 'in:LP,CB,SC,OR,PT,TJ,BN,PA,CH',
                'estado' => 'in:ACTIVO,INACTIVO',
                'estado_registro' => 'in:SIN REGISTRAR,REGISTRADO',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $estudiante->fill($request->all());
        $estudiante->save();
        return response()->json($estudiante);
    }

    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();
        return response()->json(null, 204);
    }
}