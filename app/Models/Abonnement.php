<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'idUser',
        'typePack',
        'modeEssai',
        'dateDebut',
        'dateFin',
        'transaction_id',
        'stop'
    ];
}
