<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;


    protected $fillable = [
        'idUser',
        'marches',
        'ac',
        'dateDebut',
        'abonnement_id',
        'stop',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');  // 'user_id' est la clé étrangère dans la table 'alertes'
    }
}
