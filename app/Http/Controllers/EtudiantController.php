<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function etudiantIndex()
    {
        //FIndAll Etudiant table

        $etudiants = Etudiant::all();
        return response()->json($etudiants);

    }

    /**
     *creation d'un nouveau étudiant

    */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function etudiantStore(Request $request)
    {
        //
        try {
            //code...
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'filiere' => 'required|string|max:255',
                'niveau' => 'required|string|max:255',
                'email' => 'required|email|max:255',

            ]);
    
            $etudiant = Etudiant::create($validatedData);
    
            return response()->json($etudiant, 201);
        } catch (\Exception $e) {
            //throw $th;
            return response(['message' => 'Erreur interne avec le serveur', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
