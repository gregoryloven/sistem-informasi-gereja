<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPelayananLainnya;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Krisma;
use App\Models\Kbg;
use App\Models\Riwayat;
use App\Models\ListEvent;
use App\Models\Umat;
use App\Models\PengurapanOrangSakit;
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;
use DB;

class ValidasiKbgController extends Controller
{
    public function umatBaru()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg_id;
            $kbg2 = Auth::user()->kbg->nama_kbg;
    
            $umatbaru = Umat::where([["status", "Diproses"], ['kbg_id', $kbg]])
            ->orderBy('updated_at', 'ASC')
            ->get();
    
            $umatbaru2 = Umat::where([["status", "Disetujui KBG"], ['kbg_id', $kbg]])
            ->orwhere([['status', 'Ditolak'], ['kbg_id', $kbg]])
            ->orderBy('updated_at', 'DESC')
            ->get();
    
            return view('validasiKbg.umatBaru',compact("umatbaru", "umatbaru2", "kbg2"));
        }
    }

    public function AcceptUmatBaru(Request $request)
    {        
        $umat=Umat::find($request->id);
        $umat->status = "Disetujui KBG";
        $umat->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $umat->id;
        $riwayat->jenis_event =  "Umat Baru";
        $riwayat->status =  "Disetujui KBG";
        $riwayat->save();

        return redirect()->route('validasiKbg.umatBaru', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Validasi Umat Baru Berhasil');
    }

    public function DeclineUmatBaru(Request $request)
    {        
        $umat=Umat::find($request->id);
        $umat->status = "Ditolak";
        $umat->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $umat->id;
        $riwayat->jenis_event =  "Umat Baru";
        $riwayat->status =  "Ditolak";
        $riwayat->save();

        return redirect()->route('validasiKbg.umatBaru', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Validasi Umat Baru Ditolak');
    }
    
    public function pelayanan()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->nama_kbg;
            $user = Auth::user()->id;
    
            $reservasi = PendaftaranPelayananLainnya::where([["status", "Diproses"], ['kbg', $kbg]])
            ->orderby('pendaftaran_pelayanan_lainnyas.jadwal', 'ASC')
            ->orderby('pendaftaran_pelayanan_lainnyas.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('pelayanan_lainnyas')
            ->join('pendaftaran_pelayanan_lainnyas', 'pelayanan_lainnyas.id', '=', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id')
            ->join('riwayats', 'pendaftaran_pelayanan_lainnyas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Pelayanan']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pelayanan']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Pelayanan']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['pendaftaran_pelayanan_lainnyas.nama_lengkap', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id',
            'pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.jadwal', 
            'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.telepon', 
            'pendaftaran_pelayanan_lainnyas.keterangan', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
            
            return view('validasiKbg.pelayanan',compact("reservasi", "reservasiAll", "kbg"));
        }
    }

    public function AcceptPelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $pelayanan->status = "Disetujui KBG";
        $pelayanan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $pelayanan->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Disetujui KBG";
        $riwayat->save();

        return redirect()->route('validasiKbg.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Disetujui');
    }

    public function DeclinePelayanan(Request $request)
    {
        $pelayanan=PendaftaranPelayananLainnya::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $pelayanan->status = "Ditolak";
        $pelayanan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id = $pelayanan->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiKbg.pelayanan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Ditolak');
    }

    public function pengurapan()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->nama_kbg;
            $user = Auth::user()->id;
    
            $reservasi = PengurapanOrangSakit::where([["status", "Diproses"], ['kbg', $kbg]])
            ->orderby('jadwal', 'ASC')
            ->orderby('updated_at', 'ASC')
            ->get();
    
            $reservasiAll = PengurapanOrangSakit::join('riwayats', 'pengurapan_orang_sakits.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Pengurapan']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pengurapan']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Pengurapan']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['pengurapan_orang_sakits.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
            
            return view('validasiKbg.pengurapan',compact("reservasi", "reservasiAll", "kbg"));
        }
    }

    public function AcceptPengurapan(Request $request)
    {
        $pengurapan=PengurapanOrangSakit::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $pengurapan->status = "Disetujui KBG";
        $pengurapan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $pengurapan->id;
        $riwayat->jenis_event =  "Pengurapan";
        $riwayat->status =  "Disetujui KBG";
        $riwayat->save();

        return redirect()->route('validasiKbg.pengurapan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pengurapan Orang Sakit Berhasil Disetujui');
    }

    public function DeclinePengurapan(Request $request)
    {
        $pengurapan=PengurapanOrangSakit::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();
 
        $pengurapan->status = "Ditolak";
        $pengurapan->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id = $pengurapan->id;
        $riwayat->jenis_event =  "Pengurapan";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiKbg.pengurapan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pengurapan Orang Sakit Berhasil Ditolak');
    }

    public function baptis()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->nama_kbg;
            $user = Auth::user()->id;
            
            $reservasi = Baptis::where([["status", "Diproses"], ['kbg', $kbg], ['jenis', 'Baptis Bayi']])
            ->orderby('baptiss.jadwal', 'ASC')
            ->orderby('baptiss.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('baptiss')
            ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Baptis Bayi']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Baptis Bayi']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['baptiss.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

            $setting = Setting::first();
    
            return view('validasiKbg.baptis',compact("reservasi", "reservasiAll", "kbg", "setting"));
        }
    }

    public function baptisDewasa()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->nama_kbg;
            $user = Auth::user()->id;
            
            $reservasi = Baptis::where([["status", "Diproses"], ['kbg', $kbg], ['jenis', 'Baptis Dewasa']])
            ->orderby('baptiss.jadwal', 'ASC')
            ->orderby('baptiss.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('baptiss')
            ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Baptis Dewasa']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Dewasa']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Baptis Dewasa']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['baptiss.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

            $setting = Setting::first();
    
            return view('validasiKbg.baptisDewasa',compact("reservasi", "reservasiAll", "kbg", "setting"));
        }
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        if($baptis->jenis == "Baptis Bayi")
        {
            $baptis->status = "Disetujui KBG";
            $baptis->save();
    
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Bayi";
            $riwayat->status =  "Disetujui KBG";
            $riwayat->save();

            return redirect()->route('validasiKbg.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Bayi Telah Disetujui');
        }
        else
        {
            $baptis->status = "Disetujui KBG";
            $baptis->save();
    
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Dewasa";
            $riwayat->status =  "Disetujui KBG";
            $riwayat->save();

            return redirect()->route('validasiKbg.baptisDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Dewasa Telah Disetujui');
        }
    }

    public function DeclineBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        if($baptis->jenis == "Baptis Bayi")
        {
            $baptis->status = "Ditolak";
            $baptis->save();

            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Bayi";
            $riwayat->status =  "Ditolak";
            $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
            $riwayat->save();

            return redirect()->route('validasiKbg.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Bayi Telah Ditolak');
        }
        else 
        {
            $baptis->status = "Ditolak";
            $baptis->save();
    
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Dewasa";
            $riwayat->status =  "Ditolak";
            $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
            $riwayat->save();
    
            return redirect()->route('validasiKbg.baptisDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Dewasa Telah Ditolak');
        }
        
    }

    public function komuni()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->nama_kbg;
            $user = Auth::user()->id;
           
            $reservasi = KomuniPertama::where([["status", "Diproses"], ['kbg', $kbg]])
            ->orderby('komuni_pertamas.jadwal', 'ASC')
            ->orderby('komuni_pertamas.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('komuni_pertamas')
            ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Komuni Pertama']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Komuni Pertama']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Komuni Pertama']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['komuni_pertamas.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
    
            return view('validasiKbg.komuni',compact("reservasi", "reservasiAll", "kbg"));
        }
    }

    public function AcceptKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Disetujui KBG";
        $komuni->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
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

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $komuni->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiKbg.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Berhasil Ditolak');
    }

    public function krisma()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->nama_kbg;
            $user = Auth::user()->id;
            
            $reservasi = Krisma::where([["status", "Diproses"], ['kbg', $kbg], ['jenis', 'Paroki Setempat']])
            ->orderby('krismas.jadwal', 'ASC')
            ->orderby('krismas.updated_at', 'ASC')
            ->get();
            
            $reservasiAll = DB::table('krismas')
            ->join('riwayats', 'krismas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui KBG'], ['kbg', $kbg], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['kbg', $kbg], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['kbg', $kbg], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['krismas.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
    
            return view('validasiKbg.krisma',compact("reservasi", "reservasiAll", "kbg"));
        }
    }

    public function AcceptKrisma(Request $request)
    {
        $krisma=Krisma::find($request->id);
        $krisma->status = "Disetujui KBG";
        $krisma->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $krisma->id;
        $riwayat->jenis_event =  "Krisma Setempat";
        $riwayat->status =  "Disetujui KBG";
        $riwayat->save();

        return redirect()->route('validasiKbg.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Berhasil Disetujui');
    }

    public function DeclineKrisma(Request $request)
    {
        $krisma=Krisma::find($request->id);
        $krisma->status = "Ditolak";
        $krisma->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $krisma->id;
        $riwayat->jenis_event =  "Krisma Setempat";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiKbg.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Berhasil Ditolak');
    }
}
