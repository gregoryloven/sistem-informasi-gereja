<?php

namespace App\Http\Controllers;

use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\Baptis;
use Illuminate\Http\Request;

class ValidasiKbgController extends Controller
{
    public function pelayanan()
    {
        $reservasi = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where("status", "Pending")
        ->get(['pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 
        
        $reservasiAll = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where("status", "!=", "Pending")
        ->get(['pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 
        return view('validasiKbg.pelayanan',compact("reservasi", "reservasiAll"));
    }

    public function AcceptPelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Disetujui KBG";
        $pelayanan->save();

        return redirect()->route('validasiKbg.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function DeclinePelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Ditolak";
        $pelayanan->alasan_penolakan = $request->get("alasan_penolakan");

        $pelayanan->save();

        return redirect()->route('validasiKbg.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Ditolak');
    }

    public function baptis()
    {
        $reservasi = Baptis::where("status", "Diproses")->get();
        
        $reservasiAll = Baptis::where("status", "!=", "Diproses")->get();
        
        return view('validasiKbg.baptis',compact("reservasi", "reservasiAll"));
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Disetujui KBG";
        $baptis->save();

        return redirect()->route('validasiKbg.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Disetujui');
    }

    public function DeclineBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Ditolak";
        $baptis->alasan_penolakan = $request->get("alasan_penolakan");
        $baptis->save();

        return redirect()->route('validasiKbg.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Ditolak');
    }
}
