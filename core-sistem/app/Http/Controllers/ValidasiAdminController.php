<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Auth;
use DB;

class ValidasiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function pelayanan()
    {
        $user = Auth::user()->id;

        $reservasi = PendaftaranPelayananLainnya::where('status', 'Disetujui Lingkungan')->get();
        $reservasiAll = DB::table('pelayanan_lainnyas')
        ->join('pendaftaran_pelayanan_lainnyas', 'pelayanan_lainnyas.id', '=', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id')
        ->join('riwayats', 'pendaftaran_pelayanan_lainnyas.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Pelayanan']])
        ->orderBy('pendaftaran_pelayanan_lainnyas.jadwal', 'DESC')
        ->get(['pendaftaran_pelayanan_lainnyas.nama_lengkap', 'pendaftaran_pelayanan_lainnyas.lingkungan', 'pendaftaran_pelayanan_lainnyas.kbg',
        'pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.jadwal', 
        'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.telepon', 
        'pendaftaran_pelayanan_lainnyas.keterangan', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.id as riwayatID', 'pendaftaran_pelayanan_lainnyas.id',
        'riwayats.created_at','riwayats.updated_at', 'users.role']);

        return view('validasiAdmin.pelayanan',compact("reservasi", "reservasiAll"));
    }

    public function AcceptPelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Disetujui Paroki";
        $pelayanan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $pelayanan->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function DeclinePelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Ditolak";
        $pelayanan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id = $pelayanan->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiAdmin.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Ditolak');
    }

    public function PembatalanPelayanan(Request $request)
    {
        $data=PendaftaranPelayananLainnya::find($request->id);
        $data->status = "Dibatalkan";

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('validasiAdmin.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Pelayanan Berhasil Dibatalkan');
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

    public function baptis()
    {
        $user = Auth::user()->id;
        
        $reservasi = Baptis::where('status', 'Disetujui Lingkungan')->get();
        $reservasiAll = DB::table('baptiss')
        ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orderBy('baptiss.jadwal', 'DESC')
        ->get(['baptiss.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
<<<<<<< HEAD

=======
        
>>>>>>> f4852c6556bf41c58f90308b8155d4dc39c1ebcc
        return view('validasiAdmin.baptis',compact("reservasi", "reservasiAll"));
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Disetujui Paroki";
        $baptis->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $baptis->id;
        $riwayat->jenis_event =  "Baptis Bayi";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Disetujui');
    }

    public function DeclineBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Ditolak";
        $baptis->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $baptis->id;
        $riwayat->jenis_event =  "Baptis Bayi";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Ditolak');
    }

    public function PembatalanBaptis(Request $request)
    {
<<<<<<< HEAD
=======
        
>>>>>>> f4852c6556bf41c58f90308b8155d4dc39c1ebcc
        $data=Baptis::find($request->id);
        $data->status = "Dibatalkan";

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Baptis Bayi";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Baptis Berhasil Dibatalkan');
    }

    public function komuni(Request $request)
    {
        $user = Auth::user()->id;
        
        $reservasi = KomuniPertama::where('status', 'Disetujui Lingkungan')->get();
        $reservasiAll = DB::table('komuni_pertamas')
        ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orderBy('komuni_pertamas.jadwal', 'DESC')
        ->get(['komuni_pertamas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiAdmin.komuni',compact("reservasi", "reservasiAll"));
    }

    public function AcceptKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Disetujui Paroki";
        $komuni->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $komuni->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Pertama Berhasil Disetujui');
    }

    public function DeclineKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Ditolak";
        $komuni->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $komuni->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiAdmin.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Pertama Berhasil Ditolak');
    }

    public function PembatalanKomuni(Request $request)
    {
        $data=KomuniPertama::find($request->id);
        $data->status = "Dibatalkan";

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('validasiAdmin.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Komuni Pertama Berhasil Dibatalkan');
    }
}
