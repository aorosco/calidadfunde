<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Estudiante;

class EstudianteTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_un_estudiante()
    {
        $data = [
            'nombres' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'González',
            'correo' => 'juan.perez@example.com',
            'fecha_nacimiento' => '2000-01-01', // Ejemplo de fecha
            'genero' => 'M',
            'tipo_documento' => 'CI',
            'nro_documento' => '1234567',
            'complemento' => 'LP',
            'expedido' => 'LP',
            'estado' => 'ACTIVO',
            'estado_registro' => 'SIN REGISTRAR',
        ];

        $response = $this->postJson('/api/estudiantes', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'nombres', 'apellido_paterno', 'apellido_materno', 'correo', 'fecha_nacimiento', 'genero', 'tipo_documento', 'nro_documento', 'complemento', 'expedido', 'estado', 'estado_registro', 'created_at', 'updated_at'])
            ->assertJson($data);

        $this->assertDatabaseHas('estudiantes', $data);
    }

    public function test_no_puede_crear_un_estudiante_con_datos_invalidos()
    {
        $response = $this->postJson('/api/estudiantes', []); // Datos vacíos

        $response->assertStatus(422) // Espera un error de validación
            ->assertJsonStructure(['errors']);
    }

    public function test_puede_obtener_todos_los_estudiantes()
    {
        Estudiante::factory(3)->create();

        $response = $this->getJson('/api/estudiantes');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([['id', 'nombres', 'apellido_paterno', 'apellido_materno', 'correo', 'fecha_nacimiento', 'genero', 'tipo_documento', 'nro_documento', 'complemento', 'expedido', 'estado', 'estado_registro', 'created_at', 'updated_at']]);
    }

    public function test_puede_obtener_un_estudiante_por_id()
    {
        $estudiante = Estudiante::factory()->create();

        $response = $this->getJson("/api/estudiantes/{$estudiante->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'nombres', 'apellido_paterno', 'apellido_materno', 'correo', 'fecha_nacimiento', 'genero', 'tipo_documento', 'nro_documento', 'complemento', 'expedido', 'estado', 'estado_registro', 'created_at', 'updated_at'])
            ->assertJson($estudiante->toArray());
    }

    public function test_puede_actualizar_un_estudiante()
    {
        $estudiante = Estudiante::factory()->create();
        $data = [
            'nombres' => 'Nuevo nombre',
            'correo' => 'nuevo.correo@example.com',
        ];

        $response = $this->putJson("/api/estudiantes/{$estudiante->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'nombres', 'apellido_paterno', 'apellido_materno', 'correo', 'fecha_nacimiento', 'genero', 'tipo_documento', 'nro_documento', 'complemento', 'expedido', 'estado', 'estado_registro', 'created_at', 'updated_at'])
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('estudiantes', $data);
    }

    public function test_puede_eliminar_un_estudiante()
    {
        $estudiante = Estudiante::factory()->create();

        $response = $this->deleteJson("/api/estudiantes/{$estudiante->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('estudiantes', ['id' => $estudiante->id]);
    }
}