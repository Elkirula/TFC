<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    // Define the relationship with the Multimedia model
    public function multimedia()
    {
        return $this->hasOne(Multimedia::class);
    }

    public function artistas()
    {
        return $this->belongsToMany(Artista::class, 'evento_artista');
    }

    public function ubicaciones()
    {
        return $this->belongsTo(Ubicaciones::class, 'ubicacion_id');
    }

    public function comentarios()
    {
        return $this->hasMany(ChatEvento::class);
    }

}
