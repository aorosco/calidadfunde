<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes'; // Nombre de la tabla
    protected $fillable = [ // Campos que se pueden asignar masivamente
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'fecha_nacimiento',
        'genero',
        'tipo_documento',
        'nro_documento',
        'complemento',
        'expedido',
        'estado',
        'estado_registro',
    ];

    // Relaciones
    public function inscripciones() {
        return $this->hasMany(Inscripcion::class);
    }
}