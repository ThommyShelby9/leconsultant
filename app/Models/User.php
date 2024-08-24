<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//implements MustVerifyEmail
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'typeActor',
		'isActif',
		'isParam',
		'logo',
		'nom',
		'prenoms',
		'telephone',
		'adresse',
		'typeSociete',
		'nomSociete',
		'telephoneSociete',
		'adresseSociete',
        'situation',
        'email',
        'password',
        'surmoi',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function alertes()
    {
        return $this->hasMany(Alerte::class, 'idUser');  // 'user_id' est la clé étrangère dans la table 'alertes'
    }
}
