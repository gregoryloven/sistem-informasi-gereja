<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranKomuni;
use App\Models\User;
use App\Models\KomuniPertama;
use DB;
use Auth;
use Illuminate\Http\Request;

class PendaftaranKomuniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('list_events')
                ->where('jenis_event', 'like', 'Ko%')
                ->get();
        $komuni = KomuniPertama::where('user_id', Auth::user()->id)->get();
        $user = User::all();
        return view('pendaftarankomuni.index',compact("data", "komuni", "user"));
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;
        $list = DB::table('list_events')->where('id', $id)->get();
        $user = DB::table('users')
            ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
            ->join('kbgs', 'users.kbg_id', '=', 'kbgs.id')
            ->where('users.id', Auth::user()->id)
            ->get();

        return view('pendaftarankomuni.InputForm',compact("list", "user"));
    }

    public function InputForm(Request $request)
    {
        $data = new KomuniPertama();
        $data->user_id = Auth::user()->id;
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->tempat_lahir = $request->get("tempat_lahir");
        $data->tanggal_lahir = $request->get("tanggal_lahir");
        $data->orangtua_ayah = $request->get("orangtua_ayah");
        $data->orangtua_ibu = $request->get("orangtua_ibu");
        $data->lingkungan = $request->get("lingkungan");
        $data->kbg = $request->get("kbg");
        $data->telepon = $request->get("telepon");
        $data->jadwal = $request->get("jadwal");
        $data->lokasi = $request->get("lokasi");
        $data->romo = $request->get("romo");
        $data->status = "Diproses";
        $data->save();

        return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Berhasil');
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
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function show(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function edit(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }
}
