<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $dokters = Dokter::latest()->get();

            return response()->json($dokters);

        }catch(Exception $e){
            return response()->json('Error');
        }
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
        try{

            $validatedData = $request->validate([
                'poli' => 'required|max:255',
                'no_hp' => 'required|max:255',
                'nama' => 'required|max:255',
                'foto' => 'mimes:jpeg,jpg,png',
                'username' => ['required', 'max:255', 'unique:users']
            ]);

            if($request->file('foto')){
                $validatedData['foto'] = $request->file('foto')->store('data-dokter');
            }

            $userData = [
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['username']),
                'role' => 1,
            ];

            User::create($userData);
        
            $validatedData['id_user'] = User::where('username', $validatedData['username'])->first(['id'])->id;
            Dokter::create($validatedData);
            
            return response()->json('Sukses Create Dokter');

        }catch(Exception $e){
            return response()->json('Error');
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
    public function update(Request $request, Dokter $dokter)
    {
        try{

            $validatedData = $request->validate([
                'poli' => 'required|max:255',
                'no_hp' => 'required|max:255',
                'nama' => 'required|max:255',
                'foto' => 'mimes:jpeg,jpg,png',
                'id_user' => 'required'
            ]);

            if($request->file('foto')){
                if($request->oldImage){
                    Storage::delete($request->oldImage);
                }
                $validatedData['foto'] = $request->file('foto')->store('data-dokter');
            }

            Dokter::where('id', $dokter->id)->update($validatedData);

            return response()->json('Sukses Edit Dokter');

        }catch(Exception $e){
            return response()->json('Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $dokter = Dokter::whereId($id)->first();
            if ($dokter->foto) {
                Storage::delete($dokter->foto);
            }
            Dokter::destroy($id);

            return response()->json('Sukses Delete Dokter');

        }catch(Exception $e){
            return response()->json('Error');
        }
    }
}
