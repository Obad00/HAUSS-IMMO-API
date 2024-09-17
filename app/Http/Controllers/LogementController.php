<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogementRequest;
use App\Http\Requests\UpdateLogementRequest;
use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
class LogementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function publicIndex()
    {
        // Afficher tous les logements disponibles pour les utilisateurs non connectés
        $logements = Logement::all();

        return response()->json($logements);
    }
    public function index()
    {
        // Récupérer l'utilisateur authentifié
        $user = JWTAuth::parseToken()->authenticate();

        // Filtrer les logements pour récupérer seulement ceux appartenant au propriétaire
        $logements = Logement::where('proprietaire_id', $user->id)->get();

        return response()->json($logements);
    }

    /**
 * Display a listing of all available logements without authentication.
 */



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
    // Méthode pour créer un nouveau logement
    public function store(StoreLogementRequest $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = JWTAuth::parseToken()->authenticate();

        // Créer un nouveau logement
        $logement = Logement::create(array_merge($request->all(), ['proprietaire_id' => $user->id]));

        return response()->json([
            'message' => 'Logement créé avec succès.',
            'logement' => $logement
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    /**
 * Display the details of a specific logement without authentication.
 */
        public function publicShow($id)
        {
            // Trouver le logement par ID
            $logement = Logement::find($id);

            // Vérifier si le logement existe
            if (!$logement) {
                return response()->json(['message' => 'Logement non trouvé'], 404);
            }

            return response()->json($logement);
        }

   // Méthode pour afficher un logement spécifique
   public function show($id)
   {
       // Récupérer l'utilisateur authentifié
       $user = JWTAuth::parseToken()->authenticate();

       // Trouver le logement par ID et vérifier s'il appartient au propriétaire
       $logement = Logement::where('id', $id)
                           ->where('proprietaire_id', $user->id)
                           ->first();

       if (!$logement) {
           return response()->json(['message' => 'Logement non trouvé ou accès non autorisé'], 404);
       }

       return response()->json($logement);
   }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logement $logement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Méthode pour mettre à jour un logement
    public function update(UpdateLogementRequest $request, $id)
    {
         // Récupérer l'utilisateur authentifié
         $user = JWTAuth::parseToken()->authenticate();

         // Trouver le logement et vérifier s'il appartient au propriétaire
         $logement = Logement::where('id', $id)
                             ->where('proprietaire_id', $user->id)
                             ->first();

         if (!$logement) {
             return response()->json(['message' => 'Logement non trouvé ou accès non autorisé'], 404);
         }

         // Mettre à jour le logement
         $logement->update($request->all());

         return response()->json([
             'message' => 'Logement mis à jour avec succès.',
             'logement' => $logement
         ]);
    }

    /**
     * Remove the specified resource from storage.
     */
   // Méthode pour supprimer un logement
   public function destroy($id)
   {
       $logement = Logement::find($id);

       if (!$logement || $logement->proprietaire_id !== Auth::id()) {
           return response()->json(['message' => 'Logement non trouvé ou non autorisé'], 403);
       }

       $logement->delete();

       return response()->json(['message' => 'Logement supprimé avec succès']);
   }
}
