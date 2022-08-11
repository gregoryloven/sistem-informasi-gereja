<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Baptis;
use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use Illuminate\Http\Request;

class ValidasiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function baptis()
    {
        $reservasi = Baptis::where("status", "Disetujui Lingkungan")->get();
        
        $reservasiAll = Baptis::where("status", "!=", "Disetujui Lingkungan")->get();
        
        return view('validasiAdmin.baptis',compact("reservasi", "reservasiAll"));
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Disetujui Paroki";
        $baptis->save();

        return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Disetujui');
    }

    public function DeclineBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Ditolak";
        $baptis->alasan_penolakan = $request->get("alasan_penolakan");
        $baptis->save();

        return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Ditolak');
    }
    
     public function pelayanan()
    {
        $reservasi = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where('status', 'Disetujui Lingkungan')
        ->get(['pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 
        
        $reservasiAll = PendaftaranPelayananLainnya::join('pelayanan_lainnyas', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id', '=', 'pelayanan_lainnyas.id')
        ->where("status", "!=", 'Disetujui KBG') 
        ->where("status", "!=", 'Disetujui Lingkungan')
        ->get(['pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.nama_pemohon', 'pendaftaran_pelayanan_lainnyas.id', 'pendaftaran_pelayanan_lainnyas.jadwal', 'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.keterangan', 'pendaftaran_pelayanan_lainnyas.alasan_pembatalan', 'status']); 
 
        return view('validasiAdmin.pelayanan',compact("reservasi", "reservasiAll"));
    }

    public function AcceptPelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Disetujui Paroki";
        $pelayanan->save();

        return redirect()->route('validasiAdmin.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function DeclinePelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Ditolak";
        $pelayanan->save();

        return redirect()->route('validasi.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Ditolak');
    }

    public function petugas(Request $request)
    {
        $petugas = PendaftaranPetugas::join('petugas_liturgis', 'pendaftaran_petugas_liturgis.petugas_liturgi_id', '=', 'petugas_liturgis.id')
        ->join('users', 'pendaftaran_petugas_liturgis.user_id', '=', 'users.id')
        ->get(['users.nama_user', 'petugas_liturgis.jenis_petugas', 'status', 'pendaftaran_petugas_liturgis.id']);

        return view('validasiAdmin.petugas',compact("petugas"));
    }

    public function AcceptPetugas(Request $request)
    {
        $petugas=PendaftaranPetugas::find($request->id);
        $petugas->status = "Diterima";
        $petugas->save();

        return redirect()->route('validasiAdmin.petugas', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil Disetujui');
    }

    public function DeclinePetugas(Request $request)
    {
        $petugas=PendaftaranPetugas::find($request->id);
        $petugas->status = "Ditolak";
        $petugas->save();

        return redirect()->route('validasiAdmin.petugas', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil Ditolak');
    }
}
