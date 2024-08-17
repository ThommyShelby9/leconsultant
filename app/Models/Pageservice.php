<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pageservice extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'description',
        'statut',
    ];
}
