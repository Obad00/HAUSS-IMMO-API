<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    use HasFactory;

    protected $guarded = [];


    // Relation avec un utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

