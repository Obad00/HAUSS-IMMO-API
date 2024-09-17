<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Logement extends Model
{
    use HasFactory;

    // Relation avec le propriétaire
    public function proprietaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // Relation avec la catégorie
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    // Relation avec les réservations
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
