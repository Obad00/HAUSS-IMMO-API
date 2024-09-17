<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLogementRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la demande.
     */
    public function rules()
    {
        return [
            'titre' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'type' => 'required|string|in:appartement,maison',
            'image' => 'required|string',
            'ville' => 'required|string',
            'region' => 'required|string',
            'quartier' => 'required|string',
            'nombreChambre' => 'required|integer',
            'nombreToilette' => 'required|integer',
            'nombreEtage' => 'required|integer',
            'surface' => 'required|numeric',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'categorie_id' => 'required|exists:categories,id'
        ];
    }

    /**
     * Obtenir les messages de validation personnalisés.
     */
    public function messages()
    {
        return [
            'titre.required' => 'Le titre est requis.',
            'adresse.required' => 'L\'adresse est requise.',
            // Ajoutez ici d'autres messages personnalisés pour les validations
        ];
    }
}
