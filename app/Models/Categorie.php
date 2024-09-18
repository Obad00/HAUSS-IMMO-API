<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation avec les logements
    public function logements(): HasMany
    {
        return $this->hasMany(Logement::class);
    }
}
