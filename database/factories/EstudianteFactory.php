<?php

namespace Database\Factories;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstudianteFactory extends Factory
{
    protected $model = Estudiante::class;

    public function definition()
    {
        return [
            'nombres' => $this->faker->firstName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'correo' => $this->faker->unique()->safeEmail(), // Correo único
            'fecha_nacimiento' => $this->faker->date(), // Fecha aleatoria
            'genero' => $this->faker->randomElement(['M', 'F']),
            'tipo_documento' => $this->faker->randomElement(['CI', 'PASAPORTE']),
            'nro_documento' => $this->faker->numerify('########'), // 8 números aleatorios
            'complemento' => $this->faker->randomLetter . $this->faker->randomLetter, // Dos letras aleatorias
            'expedido' => $this->faker->city, // Ciudad aleatoria
            'estado' => $this->faker->randomElement(['ACTIVO', 'INACTIVO']),
            'estado_registro' => $this->faker->randomElement(['SIN REGISTRAR', 'REGISTRADO']),
        ];
    }
}