@component('mail::message')
# Votre réservation est en attente

Merci pour votre réservation du logement **{{ $reservation->logement->titre }}**.

Votre demande est en attente de traitement par le propriétaire. Vous serez informé dès que le propriétaire aura pris une décision.

@component('mail::button', ['url' => url('/reservations/' . $reservation->id)])
Voir votre réservation
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
