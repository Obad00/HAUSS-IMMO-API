<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use Illuminate\Http\Request;

class LogementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Méthode pour afficher tous les logements
        $logements = Logement::all();
        return response()->json($logements);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Logement $logement)
    {
        //
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
    public function update(Request $request, Logement $logement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logement $logement)
    {
        //
    }
}
