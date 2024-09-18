<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Proprietaire;
use App\Models\Locataire;

class AuthController extends Controller
{
    // Méthode d'enregistrement
    public function register(Request $request)
{
    // Validation des données d'inscription
    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'telephone' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|string|in:proprietaire,locataire', // Rôle obligatoire (propriétaire ou locataire)
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Création de l'utilisateur
    $user = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'adresse' => $request->adresse,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telephone' => $request->telephone,
    ]);

    // Attribution du rôle
    if ($request->role == 'proprietaire') {
        // Ajouter dans la table des propriétaires
        Proprietaire::create(['user_id' => $user->id]);
        $user->assignRole('proprietaire');
    } elseif ($request->role == 'locataire') {
        // Ajouter dans la table des locataires
        Locataire::create(['user_id' => $user->id]);
        $user->assignRole('locataire');
    }

    // Générer le token JWT
    $token = JWTAuth::fromUser($user);

    return response()->json(compact('user', 'token'), 201);
}
    // Méthode de connexion
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    // Méthode de déconnexion
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Deconnexion avec succée']);
    }

    // Génération d'un nouveau token
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user(),
        ]);
    }
}
