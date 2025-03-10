<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos'; // Nombre de la tabla
    protected $fillable = [ // Campos que se pueden asignar masivamente
        'nombre',
        'nivel',
        'grado',
        'paralelo',
        'capacidad_maxima',
    ];

    // Relaciones
    public function inscripciones() {
        return $this->hasMany(Inscripcion::class);
    }
}