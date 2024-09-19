<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyecto';
    protected $primaryKey = 'proyecto_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'proyecto_id', 'proyecto_id');
    }
}
