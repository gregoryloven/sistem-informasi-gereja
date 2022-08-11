<?php

namespace App\Http\Controllers;

use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\Keluarga;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class PelayananLainnyaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=User::all();
        $reservasi = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->get(['pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.id' ,'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'status', 'alasan_penolakan']); 
        $kel=Keluarga::all();
        $pelayanan=PelayananLainnya::all();
        $kepalaKeluarga = Keluarga::join('users', 'keluargas.id_kepala_keluarga', '=', 'users.id')
        ->get(['keluargas.id_kepala_keluarga', 'users.nama_user']); 

        if(optional(Auth::user())->id){
            return view('pelayananlainnya.index',compact("reservasi", "data", "kepalaKeluarga", "kel", "pelayanan"));
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
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function show(PelayananLainnya $pelayananLainnya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function edit(PelayananLainnya $pelayananLainnya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PelayananLainnya $pelayananLainnya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function destroy(PelayananLainnya $pelayananLainnya)
    {
        //
    }

    public function InputForm(Request $request)
    {
        $pendaftaran_pelayanan = new PendaftaranPelayananLainnya;
        $pendaftaran_pelayanan->pelayanan_lainnya_id = $request->get("pelayanan");
        $pendaftaran_pelayanan->nama_pemohon = $request->get("nama_pemohon");
        $pendaftaran_pelayanan->jadwal = $request->get("jadwal");
        $pendaftaran_pelayanan->alamat = $request->get("alamat");
        $pendaftaran_pelayanan->keterangan = $request->get("keterangan");
        $pendaftaran_pelayanan->status = "Pending";
        $pendaftaran_pelayanan->save();

        return redirect('/pelayananlainnya');
    }

    public function Pembatalan(Request $request)
    {
        $data=PendaftaranPelayananLainnya::find($request->id);
        $data->status = "Dibatalkan";
        $data->alasan_pembatalan = $request->get("alasan_pembatalan");

        $data->save();

        return redirect()->route('pelayananlainnya.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Dibatalkan');
    }


    // public function InputFormAll(Request $request)
    // {
    //     $idKepalaKeluarga = $request->get("idKepalaKeluarga");

    //     $keluarga = User::where('keluarga_id', $idKepalaKeluarga)
    //     ->get(); 

    //     //for ($x = 0; $x <= count($keluarga)-1; $x++) {
    //         // echo $keluarga[$x]->nama;
    //         $pendaftaran_pelayanan = new PendaftaranPelayananLainnya;
    //         $pendaftaran_pelayanan->pelayanan_lainnya_id = $request->get("pelayanan");
    //         $pendaftaran_pelayanan->nama_pemohon = $keluarga[$x]->nama_user;
    //         $pendaftaran_pelayanan->jadwal = $request->get("jadwal");
    //         $pendaftaran_pelayanan->alamat = $request->get("alamat");
    //         $pendaftaran_pelayanan->keterangan = $request->get("keterangan");
    //         $pendaftaran_pelayanan->status = "Pending";
    //         $pendaftaran_pelayanan->save();
    //       //}
    //       return $keluarga;
    //     return redirect('/pelayananlainnya');
    // }

    public function listFamily(){
        $data=User::all();
        echo json_encode( $data );
        return $data;
    }
}
