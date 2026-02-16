<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentTransaction extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'type',
        'amount',
        'currency',
        'status',
        'reference',
        'payplus_token',
        'related_id',
        'customer_phone',
        'gateway_response',
        'payload',
        'completed_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Boot function pour générer un UUID automatiquement
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Vérifier si la transaction est complétée
     */
    public function isCompleted()
    {
        return $this->status === 'COMPLETED';
    }

    /**
     * Vérifier si la transaction est en attente
     */
    public function isPending()
    {
        return $this->status === 'PENDING';
    }

    /**
     * Vérifier si la transaction a échoué
     */
    public function isFailed()
    {
        return $this->status === 'FAILED';
    }

    /**
     * Marquer la transaction comme complétée
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'COMPLETED',
            'completed_at' => now(),
        ]);
    }

    /**
     * Marquer la transaction comme échouée
     */
    public function markAsFailed()
    {
        $this->update(['status' => 'FAILED']);
    }
}
