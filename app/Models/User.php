<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Multicaret\Acquaintances\Traits\Friendable;
use Multicaret\Acquaintances\Traits\CanFollow;
use Multicaret\Acquaintances\Traits\CanBeFollowed;
use Multicaret\Acquaintances\Traits\CanLike;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\CanRate;
use Multicaret\Acquaintances\Traits\CanBeRated;
use RyanChandler\Comments\Concerns\HasComments;
class User extends Authenticatable 
{
    use HasFactory, Notifiable;
    use Friendable;
    use CanFollow, CanBeFollowed;
    use CanLike, CanBeLiked;
    use CanRate, CanBeRated;
    use HasComments;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function eventosAsistidos()
    {
        return $this->belongsToMany(Evento::class, 'evento_usuario');
    }

    public function comentarios()
    {
        return $this->hasMany(ChatEvento::class);
    }


}
