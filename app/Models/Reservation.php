<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation avec le logement
    public function logement(): BelongsTo
    {
        return $this->belongsTo(Logement::class);
    }

    // Relation avec le locataire
    public function locataire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locataire_id');
    }

    // Relation avec les paiements
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}

