<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Methode pour lister tous mes categories
            public function index()
        {
            $categories = Categorie::all();
            return response()->json($categories);
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
                public function store(Request $request)
            {
                // Validation des données d'entrée
                $validated = $request->validate([
                    'nom' => 'required|string|max:255',
                ]);

                // Création de la catégorie
                $categorie = Categorie::create($validated);

                // Retourner la catégorie créée avec un statut 201
                return response()->json($categorie, 201);
            }


    /**
     * Display the specified resource.
     */
        public function show($id)
        {
            $categorie = Categorie::find($id);

            if (!$categorie) {
                return response()->json(['message' => 'Catégorie non trouvée'], 404);
            }

            return response()->json($categorie);
        }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, $id)
        {
            $categorie = Categorie::find($id);

            if (!$categorie) {
                return response()->json(['message' => 'Catégorie non trouvée'], 404);
            }

            // Validation des données d'entrée
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
            ]);

            // Mise à jour de la catégorie
            $categorie->update($validated);

            // Retourner la catégorie mise à jour
            return response()->json($categorie);
        }


    /**
     * Remove the specified resource from storage.
     */
            public function destroy(Categorie $categorie)
        {
            $categorie->delete();

            return response()->json(['message' => 'Catégorie supprimée avec succès']);
        }

}
