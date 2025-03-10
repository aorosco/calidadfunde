<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscriptions'; // Nombre de la tabla
    protected $fillable = [ // Campos que se pueden asignar masivamente
        'cursos_id',
        'estudiantes_id',
        'gestion',
        'estado',
        'documentos_completos',
        'observacion',
    ];

    // Relaciones
    public function curso() {
        return $this->belongsTo(Curso::class, 'cursos_id');
    }

    public function estudiante() {
        return $this->belongsTo(Estudiante::class, 'estudiantes_id');
    }
}