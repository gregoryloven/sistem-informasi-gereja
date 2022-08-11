<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use App\Models\PetugasLiturgi;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class PendaftaranPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        $pendaftaran_petugas = PendaftaranPetugas::join('petugas_liturgis', 'pendaftaran_petugas_liturgis.petugas_liturgi_id', '=', 'petugas_liturgis.id')
        ->join('users', 'pendaftaran_petugas_liturgis.user_id', '=', 'users.id')
        ->get(['users.nama_user', 'petugas_liturgis.jenis_petugas', 'status']); 
        $petugas = PetugasLiturgi::all();

        if(optional(Auth::user())->id){
            return view('pendaftaranpetugas.index',compact("pendaftaran_petugas", "users", "petugas"));
        }else{
            return redirect('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function show(PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function edit(PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }

    public function InputForm(Request $request)
    {
        $pendaftaran_petugas = new PendaftaranPetugas;
        $pendaftaran_petugas->user_id = $request->get("nama_user");
        $pendaftaran_petugas->petugas_liturgi_id = $request->get("petugas");
        $pendaftaran_petugas->status = "Pending";
        $pendaftaran_petugas->save();

        return redirect('/pendaftaranpetugas');
    }
}
