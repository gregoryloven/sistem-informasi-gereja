<?php

namespace App\Http\Controllers;

use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use Illuminate\Http\Request;

class ValidasiKbgController extends Controller
{
    public function index()
    {
        $reservasi = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where("status", "Pending")
        ->get(['pelayanan_lainnyas.nama_pelayanan as namaPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 
        
        $reservasiAll = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where("status", "!=", "Pending")
        ->get(['pelayanan_lainnyas.nama_pelayanan as namaPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 
        return view('validasiKbg.index',compact("reservasi", "reservasiAll"));
    }

    public function Accept(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Diterima1";
        $pelayanan->save();

        return redirect()->route('validasiKbg.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function Decline(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Ditolak";
        $pelayanan->save();

        return redirect()->route('validasiKbg.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }
}
