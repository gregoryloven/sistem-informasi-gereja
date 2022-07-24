<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use Illuminate\Http\Request;

class ValidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservasi = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where('status', 'Diterima2')
        ->get(['pelayanan_lainnyas.nama_pelayanan as namaPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 
        
        $reservasiAll = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where("status", "!=", "Diterima2")
        ->get(['pelayanan_lainnyas.nama_pelayanan as namaPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 

        $petugas = PendaftaranPetugas::join('petugas_liturgis', 'pendaftaran_petugas_liturgis.petugas_liturgi_id', '=', 'petugas_liturgis.id')
        ->join('users', 'pendaftaran_petugas_liturgis.user_id', '=', 'users.id')
        ->get(['users.nama_user', 'petugas_liturgis.petugas_liturgi', 'status', 'pendaftaran_petugas_liturgis.id']); 
        return view('validate.index',compact("reservasi", "reservasiAll", "petugas"));
    }

    public function Accept(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Diterima";
        $pelayanan->save();

        return redirect()->route('validate.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function Decline(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Ditolak";
        $pelayanan->save();

        return redirect()->route('validate.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Ditolak');
    }

    public function AcceptPetugas(Request $request)
    {
        $petugas=PendaftaranPetugas::find($request->id);
        $petugas->status = "Diterima";
        $petugas->save();

        return redirect()->route('validate.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil Disetujui');
    }

    public function DeclinePetugas(Request $request)
    {
        $petugas=PendaftaranPetugas::find($request->id);
        $petugas->status = "Ditolak";
        $petugas->save();

        return redirect()->route('validate.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil Ditolak');
    }
}
