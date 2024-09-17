<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Logement;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCreatedMail;
use App\Mail\ReservationStatusUpdatedMail;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

       $reservation = Reservation::create([
           'logement_id' => $request->logement_id,
           'locataire_id' => Auth::id(),
           'status' => 'en attente',
       ]);

       $locataire = Auth::user();
       $logement = Logement::find($request->logement_id);
       $proprietaire = $logement->proprietaire;

       // Envoyer un email au locataire
       Mail::to($locataire->email)->queue(new ReservationCreatedMail($reservation));

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
       Mail::to($reservation->locataire->email)->queue(new ReservationStatusUpdatedMail($reservation));

       return response()->json([
           'message' => 'Réservation mise à jour avec succès.',
           'reservation' => $reservation,
       ], 200);
   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
