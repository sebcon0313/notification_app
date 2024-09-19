<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;
    protected $table = 'tipo_documento';
    protected $primaryKey = 'tipo_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function documentos(){
        return $this->hasMany(Documento::class, 'tipo_id', 'tipo_id');
    }
}
