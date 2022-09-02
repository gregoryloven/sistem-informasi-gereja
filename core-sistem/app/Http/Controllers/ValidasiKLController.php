<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPelayananLainnya;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Auth;
use DB;

class ValidasiKLController extends Controller
{
    public function pelayanan()
    {
        $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
        $user = Auth::user()->id;

        $reservasi = PendaftaranPelayananLainnya::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan]])->get();
        
        $reservasiAll = DB::table('pelayanan_lainnyas')
        ->join('pendaftaran_pelayanan_lainnyas', 'pelayanan_lainnyas.id', '=', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id')
        ->join('riwayats', 'pendaftaran_pelayanan_lainnyas.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Pelayanan']])
        ->orderBy('pendaftaran_pelayanan_lainnyas.jadwal', 'DESC')
        ->get(['pendaftaran_pelayanan_lainnyas.nama_lengkap', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id',
        'pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.jadwal', 
        'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.telepon', 
        'pendaftaran_pelayanan_lainnyas.keterangan', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiKL.pelayanan',compact("reservasi", "reservasiAll"));
    }

    public function AcceptPelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Disetujui Lingkungan";
        $pelayanan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $pelayanan->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Disetujui Lingkungan";
        $riwayat->save();

        return redirect()->route('validasiKL.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
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

        return redirect()->route('validasiKL.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function baptis()
    {
        $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
        $user = Auth::user()->id;
        $reservasi = Baptis::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan]])->get();
        
        $reservasiAll = DB::table('baptiss')
        ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orderBy('baptiss.jadwal', 'DESC')
        ->get(['baptiss.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiKL.baptis',compact("reservasi", "reservasiAll"));
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Disetujui Lingkungan";
        $baptis->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $baptis->id;
        $riwayat->jenis_event =  "Baptis Bayi";
        $riwayat->status =  "Disetujui Lingkungan";
        $riwayat->save();

        return redirect()->route('validasiKL.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Disetujui');
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

        return redirect()->route('validasiKL.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Ditolak');
    }

    public function komuni()
    {
        $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
        $user = Auth::user()->id;
        
        $reservasi = KomuniPertama::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan]])->get();
        $reservasiAll = DB::table('komuni_pertamas')
        ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orderBy('komuni_pertamas.jadwal', 'DESC')
        >get(['komuni_pertamas.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
        
        return view('validasiKL.komuni',compact("reservasi", "reservasiAll"));
    }

    public function AcceptKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Disetujui Lingkungan";
        $komuni->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $komuni->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Disetujui Lingkungan";
        $riwayat->save();

        return redirect()->route('validasiKL.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Berhasil Disetujui');
    }

    public function DeclineKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Ditolak";
        $komuni->alasan_penolakan = $request->get("alasan_penolakan");
        $komuni->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $komuni->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiKL.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Berhasil Ditolak');
    }
}
