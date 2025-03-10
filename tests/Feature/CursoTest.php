<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Curso;

class CursoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_curso()
    {
        $data = [
            'nombre' => 'Matemáticas',
            'nivel' => 'SECUNDARIA',
            'grado' => 3,
            'paralelo' => 'A',
            'capacidad_maxima' => 30,
        ];

        $response = $this->postJson('/api/cursos', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'nombre', 'nivel', 'grado', 'paralelo', 'capacidad_maxima', 'created_at', 'updated_at'])
            ->assertJson($data); // Verifica que la respuesta JSON contenga los datos enviados

        $this->assertDatabaseHas('cursos', $data); // Verifica que los datos se hayan guardado en la base de datos
    }

    public function test_no_puede_crear_un_curso_con_datos_invalidos()
    {
        $response = $this->postJson('/api/cursos', []); // Envía datos vacíos

        $response->assertStatus(422) // Espera un error de validación (422 Unprocessable Entity)
            ->assertJsonStructure(['errors']); // Verifica que la respuesta JSON contenga errores de validación
    }

    public function test_puede_obtener_todos_los_cursos()
    {
        Curso::factory(3)->create(); // Crea 3 cursos de prueba

        $response = $this->getJson('/api/cursos');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([['id', 'nombre', 'nivel', 'grado', 'paralelo', 'capacidad_maxima', 'created_at', 'updated_at']]); // Verifica la estructura de cada curso en la respuesta
    }

    public function test_puede_obtener_un_curso_por_id()
    {
        $curso = Curso::factory()->create();

        $response = $this->getJson("/api/cursos/{$curso->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'nombre', 'nivel', 'grado', 'paralelo', 'capacidad_maxima', 'created_at', 'updated_at'])
            ->assertJson($curso->toArray()); // Verifica que la respuesta JSON coincida con los datos del curso
    }

    public function test_puede_actualizar_un_curso()
    {
        $curso = Curso::factory()->create();
        $data = [
            'nombre' => 'Nuevo nombre',
        ];

        $response = $this->putJson("/api/cursos/{$curso->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'nombre', 'nivel', 'grado', 'paralelo', 'capacidad_maxima', 'created_at', 'updated_at'])
            ->assertJsonFragment($data); // Verifica que la respuesta JSON contenga los datos actualizados

        $this->assertDatabaseHas('cursos', $data); // Verifica que los datos se hayan actualizado en la base de datos
    }

    public function test_puede_eliminar_un_curso()
    {
        $curso = Curso::factory()->create();

        $response = $this->deleteJson("/api/cursos/{$curso->id}");

        $response->assertStatus(204); // Espera una respuesta 204 (No Content)

        $this->assertDatabaseMissing('cursos', ['id' => $curso->id]); // Verifica que el curso se haya eliminado de la base de datos
    }
}