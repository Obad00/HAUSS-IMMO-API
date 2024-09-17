@component('mail::message')
# Mise à jour de votre réservation

Votre réservation pour le logement **{{ $reservation->logement->titre }}** a été mise à jour.

Le statut de votre réservation est maintenant : **{{ $reservation->statut }}**.

@component('mail::button', ['url' => url('/reservations/' . $reservation->id)])
Voir votre réservation
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
