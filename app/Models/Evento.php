<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RyanChandler\Comments\Concerns\HasComments;


class Evento extends Model
{
    use HasFactory;
    use HasComments;

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
    public function valoraciones()
    {
        return $this->hasMany(ValoracionesEvento::class);
    }

    public function organizador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
