<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Inscripcion;
use App\Models\Curso;
use App\Models\Estudiante;

class InscripcionTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_inscripcion()
    {
        // Crea un curso y un estudiante para relacionarlos con la inscripción
        $curso = Curso::factory()->create();
        $estudiante = Estudiante::factory()->create();

        $data = [
            'cursos_id' => $curso->id,
            'estudiantes_id' => $estudiante->id,
            'gestion' => 2024,
            'estado' => 'PENDIENTE',
            'documentos_completos' => false,
            'observacion' => 'Sin observaciones',
        ];

        $response = $this->postJson('/api/inscripciones', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'cursos_id', 'estudiantes_id', 'gestion', 'estado', 'documentos_completos', 'observacion', 'created_at', 'updated_at'])
            ->assertJson($data); // Verifica que la respuesta JSON contenga los datos enviados

        $this->assertDatabaseHas('inscripciones', $data); // Verifica que los datos se hayan guardado en la base de datos
    }

    public function test_no_puede_crear_una_inscripcion_con_datos_invalidos()
    {
        $response = $this->postJson('/api/inscripciones', []); // Envía datos vacíos

        $response->assertStatus(422) // Espera un error de validación (422 Unprocessable Entity)
            ->assertJsonStructure(['errors']); // Verifica que la respuesta JSON contenga errores de validación
    }

    public function test_puede_obtener_todas_las_inscripciones()
    {
        Inscripcion::factory(3)->create(); // Crea 3 inscripciones de prueba

        $response = $this->getJson('/api/inscripciones');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([['id', 'cursos_id', 'estudiantes_id', 'gestion', 'estado', 'documentos_completos', 'observacion', 'created_at', 'updated_at']]); // Verifica la estructura de cada inscripción en la respuesta
    }

    public function test_puede_obtener_una_inscripcion_por_id()
    {
        $inscripcion = Inscripcion::factory()->create();

        $response = $this->getJson("/api/inscripciones/{$inscripcion->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'cursos_id', 'estudiantes_id', 'gestion', 'estado', 'documentos_completos', 'observacion', 'created_at', 'updated_at'])
            ->assertJson($inscripcion->toArray()); // Verifica que la respuesta JSON coincida con los datos de la inscripción
    }

    public function test_puede_actualizar_una_inscripcion()
    {
        $inscripcion = Inscripcion::factory()->create();
        $data = [
            'estado' => 'CON CREDENCIALES',
        ];

        $response = $this->putJson("/api/inscripciones/{$inscripcion->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'cursos_id', 'estudiantes_id', 'gestion', 'estado', 'documentos_completos', 'observacion', 'created_at', 'updated_at'])
            ->assertJsonFragment($data); // Verifica que la respuesta JSON contenga los datos actualizados

        $this->assertDatabaseHas('inscripciones', $data); // Verifica que los datos se hayan actualizado en la base de datos
    }

    public function test_puede_eliminar_una_inscripcion()
    {
        $inscripcion = Inscripcion::factory()->create();

        $response = $this->deleteJson("/api/inscripciones/{$inscripcion->id}");

        $response->assertStatus(204); // Espera una respuesta 204 (No Content)

        $this->assertDatabaseMissing('inscripciones', ['id' => $inscripcion->id]); // Verifica que la inscripción se haya eliminado de la base de datos
    }
}