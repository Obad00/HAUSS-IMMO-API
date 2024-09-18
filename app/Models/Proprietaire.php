<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proprietaire extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    // Relation avec les logements
    public function logements(): HasMany
    {
        return $this->hasMany(Logement::class, 'proprietaire_id');
    }
}
