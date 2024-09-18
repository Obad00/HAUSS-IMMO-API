<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tymon\JWTAuth\Contracts\JWTSubject; // Importation de l'interface JWTSubject

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Récupérer la clé primaire qui sera stockée dans le jeton JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Retourner un tableau avec les informations personnalisées qui seront ajoutées au jeton JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function proprietaire()
    {
        return $this->hasOne(Proprietaire::class);
    }

    public function locataire()
    {
        return $this->hasOne(Locataire::class, 'user_id');
    }


    // Relation avec les commentaires
    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }

    // Relation avec les supports
    public function supports(): HasMany
    {
        return $this->hasMany(Support::class);
    }

        public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function logements(): HasMany
    {
        return $this->hasMany(Logement::class, 'proprietaire_id');
    }

        public function reservations()
    {
        return $this->hasMany(Reservation::class, 'locataire_id');
    }


}
