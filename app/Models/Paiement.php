<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation avec la réservation
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
