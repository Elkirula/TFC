<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoracionesEvento extends Model
{
    use HasFactory;

    protected $table = 'valoraciones_evento';
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
