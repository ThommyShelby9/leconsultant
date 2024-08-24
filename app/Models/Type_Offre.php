<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_Offre extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_id',
        'offre_id'
    ];
}
