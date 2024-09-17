<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Liste toutes les permissions
         return response()->json(Permission::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Créer une nouvelle permission
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Montrer une permission spécifique
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['message' => 'Permission non trouvée'], 404);
        }

        return response()->json($permission, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // // Mettre à jour une permission existante
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['message' => 'Permission non trouvée'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $permission->update(['name' => $request->name]);
        return response()->json($permission, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Supprimer une permission
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['message' => 'Permission non trouvée'], 404);
        }

        $permission->delete();
        return response()->json(['message' => 'Permission supprimée'], 200);
    }
}
