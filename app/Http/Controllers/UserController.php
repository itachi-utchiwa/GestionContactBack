<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userIndex()
    {
        //
        $users = User::all();
        return response()->json($users);
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
    public function userStore(Request $request)
    {
        //
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            return response()->json(['user' => $user], 201);
        } catch (\Exception $e) {
            // return response(['message' => 'Erreur interne avec le serveur'], Response::HTTP_INTERNAL_SERVER_ERROR);
            return response(['message' => 'Erreur interne avec le serveur', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function userShow(string $id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function UserEdit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function userUpdate(Request $request, string $id)
    {
        //
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'sometimes|required|max:255',
                'email' => 'sometimes|required|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|min:8',
            ]);

            if ($request->has('password')) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $user->update($validatedData);

            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            // return response(['message' => 'Erreur interne avec le serveur'], Response::HTTP_INTERNAL_SERVER_ERROR);
            return response(['message' => 'Erreur interne avec le serveur', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function userDestroy(string $id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
