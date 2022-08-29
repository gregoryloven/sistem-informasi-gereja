<?php

namespace App\Http\Controllers;

use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Kbg;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Auth;
use DB;

class ValidasiKbgController extends Controller
{
    public function pelayanan()
    {
        $kbg = Auth::user()->kbg->nama_kbg;
        $reservasi = PendaftaranPelayananLainnya::where([["status", "Diproses"], ['kbg', $kbg]])->get();
        
        $reservasiAll = DB::table('pendaftaran_pelayanan_lainnyas')
        ->where([['status', 'Disetujui KBG'], ['kbg', $kbg]])
        ->orwhere([['status', 'Ditolak'], ['kbg', $kbg]])
        ->orderBy('jadwal', 'DESC');
        
        return view('validasiKbg.pelayanan',compact("reservasi", "reservasiAll"));
    }

    public function AcceptPelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Disetujui KBG";
        $pelayanan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $pelayanan->pelayanan_lainnya_id;
        $riwayat->jenis_event =  $pelayanan->id;
        $riwayat->status =  "Disetujui KBG";
        $riwayat->save();

        return redirect()->route('validasiKbg.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function DeclinePelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $pelayanan->status = "Ditolak";
        $pelayanan->alasan_penolakan = $request->get("alasan_penolakan");
        $pelayanan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id = $pelayanan->pelayanan_lainnya_id;
        $riwayat->jenis_event =  $pelayanan->id;
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiKbg.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Ditolak');
    }

    public function baptis()
    {
        $kbg = Auth::user()->kbg->nama_kbg;
        $user = Auth::user()->id;
        
        $reservasi = Baptis::where([["status", "Diproses"], ['kbg', $kbg]])->get();
        $reservasiAll = Baptis::join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
        ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orderBy('baptiss.jadwal', 'DESC')
        ->get(['baptiss.nama_lengkap', 'baptiss.tempat_lahir', 'baptiss.tanggal_lahir', 'baptiss.orangtua_ayah', 
        'baptiss.orangtua_ibu', 'baptiss.wali_baptis_ayah', 'baptiss.wali_baptis_ibu', 'baptiss.telepon', 
        'baptiss.jenis', 'baptiss.jadwal', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan']);

        return view('validasiKbg.baptis',compact("reservasi", "reservasiAll"));
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->status = "Disetujui KBG";
        $baptis->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $baptis->id;
        $riwayat->jenis_event =  "Baptis Bayi";
        $riwayat->status =  "Disetujui KBG";
        $riwayat->save();

        return redirect()->route('validasiKbg.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Disetujui');
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

        return redirect()->route('validasiKbg.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Berhasil Ditolak');
    }

    public function komuni()
    {
        $kbg = Auth::user()->kbg->nama_kbg;
        $user = Auth::user()->id;
       
        $reservasi = KomuniPertama::where([["status", "Diproses"], ['kbg', $kbg]])->get();
        $reservasiAll = KomuniPertama::join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
        ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orderBy('komuni_pertamas.jadwal', 'DESC')
        ->get(['komuni_pertamas.nama_lengkap', 'komuni_pertamas.tempat_lahir', 'komuni_pertamas.tanggal_lahir', 
        'komuni_pertamas.orangtua_ayah', 'komuni_pertamas.orangtua_ibu', 'komuni_pertamas.telepon', 
        'komuni_pertamas.jadwal', 'komuni_pertamas.surat_baptis', 'riwayats.status as statusRiwayat', 
        'riwayats.alasan_penolakan', 'riwayats.alasan_pembatalan']);

        return view('validasiKbg.komuni',compact("reservasi", "reservasiAll"));
    }

    public function AcceptKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Disetujui KBG";
        $komuni->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $komuni->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Disetujui KBG";
        $riwayat->save();

        return redirect()->route('validasiKbg.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Berhasil Disetujui');
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

        return redirect()->route('validasiKbg.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Berhasil Ditolak');
    }
}
