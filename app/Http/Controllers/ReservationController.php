<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Logement;
use App\Models\Locataire;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCreatedMail;
use App\Mail\ReservationStatusUpdatedMail;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        // Récupérer l'utilisateur authentifié
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }

        \Log::info('Utilisateur authentifié:', ['user' => $user]);

        // Vérifier le rôle de l'utilisateur
        if ($user->hasRole('locataire')) {
            \Log::info('Utilisateur est un locataire');

            // Locataire : récupérer le locataire lié à l'utilisateur
            $locataire = $user->locataire;

            if (!$locataire) {
                return response()->json(['message' => 'Aucun locataire trouvé pour cet utilisateur'], 404);
            }

            // Récupérer toutes les réservations faites par ce locataire qui n'ont pas été supprimées par lui
            $reservations = $locataire->reservation()
                                    ->where('deleted_by_tenant', false)
                                    ->get();

            \Log::info('Réservations pour locataire:', ['reservations' => $reservations]);

        } elseif ($user->hasRole('proprietaire')) {
            \Log::info('Utilisateur est un propriétaire');

            // Propriétaire : récupérer les identifiants des logements liés au propriétaire
            $logementsIds = $user->logements()->pluck('id');

            \Log::info('Logements IDs pour propriétaire:', ['logements_ids' => $logementsIds]);

            if ($logementsIds->isEmpty()) {
                return response()->json(['message' => 'Aucun logement trouvé pour le propriétaire'], 404);
            }

            // Récupérer toutes les réservations pour les logements du propriétaire qui n'ont pas été supprimées par lui
            $reservations = Reservation::whereIn('logement_id', $logementsIds)
                                    ->where('deleted_by_owner', false)
                                    ->get();

            \Log::info('Réservations pour propriétaire:', ['reservations' => $reservations]);

        } else {
            // Autres rôles : retournez une erreur
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        return response()->json($reservations);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   // Création d'une réservation
    public function store(Request $request)
    {
        $request->validate([
            'logement_id' => 'required|exists:logements,id',
        ]);

        // Rechercher le locataire lié à l'utilisateur connecté
        $locataire = Locataire::where('user_id', Auth::id())->first();

        if (!$locataire) {
            return response()->json(['error' => 'Locataire non trouvé.'], 404);
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'logement_id' => $request->logement_id,
            'locataire_id' => $locataire->id,
            'statut' => 'en attente',
        ]);

        $logement = Logement::find($request->logement_id);
        $proprietaire = $logement->proprietaire;

        // Envoyer un email au locataire
        Mail::to($locataire->user->email)->queue(new ReservationCreatedMail($reservation));

        // Ajouter une notification pour le propriétaire
        Notification::create([
            'user_id' => $proprietaire->id,
            'sujet' => 'Nouvelle réservation',
            'message' => "Une nouvelle réservation a été faite pour votre logement (ID: {$reservation->id}).",
        ]);

        return response()->json([
            'message' => 'Réservation créée avec succès.',
            'reservation' => $reservation
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   // Mise à jour du statut d'une réservation
   public function update(Request $request, $id)
   {
       $reservation = Reservation::findOrFail($id);

       $request->validate([
           'statut' => 'required|in:acceptee,declinee',
       ]);

       $reservation->statut = $request->statut;
       $reservation->save();

       // Ajouter une notification pour le locataire
       Notification::create([
           'user_id' => $reservation->locataire_id,
           'sujet' => 'Mise à jour de réservation',
           'message' => "Le statut de votre réservation (ID: {$reservation->id}) a été mis à jour en : {$reservation->statut}.",
       ]);

       // Envoyer un email au locataire
       Mail::to($reservation->locataire->user->email)->queue(new ReservationStatusUpdatedMail($reservation));

       return response()->json([
           'message' => 'Réservation mise à jour avec succès.',
           'reservation' => $reservation,
       ], 200);
   }


   //Méthode permettant d'archiver une reservation
    public function archive(Request $request, $id)
    {
        // Récupérer la réservation à archiver
        $reservation = Reservation::findOrFail($id);

        // Vérifier que la réservation appartient à l'utilisateur connecté
        $user = JWTAuth::parseToken()->authenticate();
        if ($reservation->locataire_id != $user->id) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        // Archiver la réservation
        $reservation->archived_at = now();
        $reservation->save();

        return response()->json(['message' => 'Réservation archivée avec succès pour 15 jours.']);
    }


        public function tenantDelete($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Vérifier que l'utilisateur est locataire
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user->hasRole('locataire')) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        // Vérifier que la réservation appartient bien au locataire
        if ($reservation->locataire_id != $user->id) {
            return response()->json(['message' => 'Réservation non trouvée pour ce locataire'], 404);
        }

        // Marquer la réservation comme supprimée par le locataire
        $reservation->deleted_by_tenant = true;
        $reservation->save();

        return response()->json(['message' => 'Réservation supprimée du tableau de bord du locataire.']);
    }

    public function ownerRestore($id)
{
    $reservation = Reservation::findOrFail($id);

    // Vérifier que l'utilisateur est propriétaire
    $user = JWTAuth::parseToken()->authenticate();
    if (!$user->hasRole('proprietaire')) {
        return response()->json(['message' => 'Accès non autorisé'], 403);
    }

    // Réinitialiser le statut de suppression par le propriétaire
    $reservation->deleted_by_owner = false;
    $reservation->save();

    return response()->json(['message' => 'Réservation restaurée pour le propriétaire.']);
}

public function tenantRestore($id)
{
    $reservation = Reservation::findOrFail($id);

    // Vérifier que l'utilisateur est locataire
    $user = JWTAuth::parseToken()->authenticate();
    if (!$user->hasRole('locataire')) {
        return response()->json(['message' => 'Accès non autorisé'], 403);
    }

    // Réinitialiser le statut de suppression par le locataire
    $reservation->deleted_by_tenant = false;
    $reservation->save();

    return response()->json(['message' => 'Réservation restaurée pour le locataire.']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
