<?php

namespace Database\Factories;

use App\Models\Inscripcion;
use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscripcionFactory extends Factory
{
    protected $model = Inscripcion::class;

    public function definition()
    {
        return [
            'cursos_id' => Curso::factory(), // Crea un curso relacionado
            'estudiantes_id' => Estudiante::factory(), // Crea un estudiante relacionado
            'gestion' => $this->faker->year(), // Año aleatorio
            'estado' => $this->faker->randomElement(['PENDIENTE', 'CON CREDENCIALES', 'REGISTRO DE DATOS', 'CONCLUIDO', 'CANCELADO']),
            'documentos_completos' => $this->faker->boolean, // Booleano aleatorio
            'observacion' => $this->faker->text(100), // Texto aleatorio (100 caracteres)
        ];
    }
}