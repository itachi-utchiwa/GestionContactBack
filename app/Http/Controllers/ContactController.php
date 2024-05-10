<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class ContactController extends Controller
{
    //Fonction de recuperation de la liste des contact en BD
    public function contactIndex()
    {
        $contacts = Contact::all();
        return response()->json($contacts);
    }

        //Creation d'un nouveau contact

    public function contactStore(Request $request)
    {
        try {
            //code...
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'adresse' => 'nullable|string',
                'contact' => 'required|string|max:255',
                'photo' => 'nullable|image|max:1999',
            ]);
    
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public/photos');
                $validatedData['photo'] = basename($path);
            }
    
            $contact = Contact::create($validatedData);
    
            return response()->json($contact, 201);
        } catch (\Exception $e) {
            //throw $th;
            return response(['message' => 'Erreur interne avec le serveur', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
        
    }

    //lister avec le ID

    public function contactShow($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    // fonction mise à jour

    public function contactUpdate(Request $request, $id)
    {
        try {
            //code...
            $contact = Contact::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'string|max:255',
            'prenom' => 'string|max:255',
            'adresse' => 'nullable|string',
            'contact' => 'string|max:255',
            'photo' => 'nullable|image|max:1999',
        ]);

        if ($request->hasFile('photo')) {
            // Supprimez l'ancienne photo si elle existe
            if ($contact->photo) {
                Storage::delete('public/photos/' . $contact->photo);
            }
            $path = $request->file('photo')->store('public/photos');
            $validatedData['photo'] = basename($path);
        }

        $contact->update($validatedData);

        return response()->json($contact);
        } catch (\Exception $e) {
            //throw $th;
            return response(['message' => 'Erreur interne avec le serveur', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
        
    }

    //Fonction delete
    public function contactDestroy($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact->photo) {
            Storage::delete('public/photos/' . $contact->photo);
        }
        $contact->delete();

        return response()->json(null, 204);
    }

}
