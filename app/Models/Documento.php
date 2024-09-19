<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documento';
    protected $primaryKey = 'documento_id';

    protected $fillable = [
        'descripcion',
        'meses_notificar',
        'fecha_inicio',
        'fecha_fin',
        'documento',
        'proyecto_id',
        'tipo_id',
        'fecha_creacion',
        'user_id'
    ];

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_id', 'tipo_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'proyecto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
