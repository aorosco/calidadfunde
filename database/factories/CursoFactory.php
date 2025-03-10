<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence(3), // Nombre del curso (3 palabras)
            'nivel' => $this->faker->randomElement(['INICIAL', 'PRIMARIA', 'SECUNDARIA']), // Nivel aleatorio
            'grado' => $this->faker->numberBetween(1, 6), // Grado entre 1 y 6
            'paralelo' => $this->faker->randomLetter, // Paralelo aleatorio
            'capacidad_maxima' => $this->faker->numberBetween(20, 40), // Capacidad entre 20 y 40
        ];
    }
}