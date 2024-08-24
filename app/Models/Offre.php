<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    public function types()
    {
        return $this->belongsToMany(Type::class, 'offre_type', 'offre_id', 'type_id');
    }
    
}
