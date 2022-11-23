<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPelayananLainnya;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Krisma;
use App\Models\Riwayat;
use App\Models\User;
use App\Models\Umat;
use App\Models\ListEvent;
use Illuminate\Http\Request;
use Auth;
use DB;

class ValidasiKLController extends Controller
{
    public function umatLama()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan_id;
            $lingkungan2 = Auth::user()->lingkungan->nama_lingkungan;
    
            $umatlama = User::where([["status", "Belum Tervalidasi"], ['lingkungan_id', $lingkungan]])
            ->orderby('updated_at', 'ASC')
            ->get();
    
            $umatlama2 = User::where([["status", "Tervalidasi"], ['lingkungan_id', $lingkungan]])
            ->orwhere([['status', 'Ditolak'], ['lingkungan_id', $lingkungan]])
            ->orderBy('updated_at', 'DESC')
            ->get();
    
            return view('validasiKL.umatLama',compact("umatlama", "umatlama2", "lingkungan2"));
        }
    }

    public function AcceptUmatLama(Request $request)
    {
        $umat=User::find($request->id);

        $umat->status = "Tervalidasi";
        $umat->save();

        return redirect()->route('validasiKL.umatLama', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Validasi Umat Lama Berhasil');
    }

    public function DeclineUmatLama(Request $request)
    {
        $umat=User::find($request->id);

        $umat->status = "Ditolak";
        $umat->save();

        return redirect()->route('validasiKL.umatLama', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Validasi Umat Lama Berhasil');
    }

    public function umatBaru()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan_id;
            $lingkungan2 = Auth::user()->lingkungan->nama_lingkungan;
    
            $umatbaru = Umat::where([["status", "Disetujui KBG"], ['lingkungan_id', $lingkungan]])
            ->orderBy('updated_at', 'ASC')
            ->get();
    
            $umatbaru2 = Umat::where([["status", "Disetujui Lingkungan"], ['lingkungan_id', $lingkungan]])
            ->orwhere([['status', 'Ditolak'], ['lingkungan_id', $lingkungan]])
            ->orderBy('updated_at', 'DESC')
            ->get();
    
            return view('validasiKL.umatBaru',compact("umatbaru", "umatbaru2", "lingkungan2"));
        }
    }

    public function AcceptUmatBaru(Request $request)
    {
        // $user=User::find($request->id);
        // $user->status = "Tervalidasi";
        // $user->save();
        
        $umat=Umat::find($request->id);
        $umat->status = "Disetujui Lingkungan";
        $umat->save();

        return redirect()->route('validasiKL.umatBaru', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Validasi Umat Baru Berhasil');
    }
    
    public function pelayanan()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
            $user = Auth::user()->id;
    
            $reservasi = PendaftaranPelayananLainnya::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan]])
            ->orderby('pendaftaran_pelayanan_lainnyas.jadwal', 'ASC')
            ->orderby('pendaftaran_pelayanan_lainnyas.updated_at', 'ASC')
            ->get();
            
            $reservasiAll = DB::table('pelayanan_lainnyas')
            ->join('pendaftaran_pelayanan_lainnyas', 'pelayanan_lainnyas.id', '=', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id')
            ->join('riwayats', 'pendaftaran_pelayanan_lainnyas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Pelayanan']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pelayanan']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Pelayanan']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['pendaftaran_pelayanan_lainnyas.nama_lengkap', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id',
            'pelayanan_lainnyas.jenis_pelayanan as jenisPelayanan', 'pendaftaran_pelayanan_lainnyas.jadwal', 
            'pendaftaran_pelayanan_lainnyas.alamat', 'pendaftaran_pelayanan_lainnyas.telepon', 
            'pendaftaran_pelayanan_lainnyas.keterangan', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
    
            return view('validasiKL.pelayanan',compact("reservasi", "reservasiAll", "lingkungan"));
        }
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
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
            $user = Auth::user()->id;
    
            $reservasi = Baptis::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan], ['jenis', 'Baptis Bayi']])
            ->orderby('baptiss.jadwal', 'ASC')
            ->orderby('baptiss.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('baptiss')
            ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Baptis Bayi']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Baptis Bayi']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['baptiss.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
    
            return view('validasiKL.baptis',compact("reservasi", "reservasiAll", "lingkungan"));
        }
    }

    public function baptisDewasa()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
            $user = Auth::user()->id;
    
            $reservasi = Baptis::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan], ['jenis', 'Baptis Dewasa']])
            ->orderby('baptiss.jadwal', 'ASC')
            ->orderby('baptiss.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('baptiss')
            ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Baptis Dewasa']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Dewasa']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Baptis Dewasa']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['baptiss.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
    
            return view('validasiKL.baptisDewasa',compact("reservasi", "reservasiAll", "lingkungan"));
        }
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        if($baptis->jenis == "Baptis Bayi")
        {
            $baptis->status = "Disetujui Lingkungan";
            $baptis->save();
    
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Bayi";
            $riwayat->status =  "Disetujui Lingkungan";
            $riwayat->save();
    
            return redirect()->route('validasiKL.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Bayi Telah Disetujui');
        }
        else
        {
            $baptis->status = "Disetujui Lingkungan";
            $baptis->save();
    
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Dewasa";
            $riwayat->status =  "Disetujui Lingkungan";
            $riwayat->save();
    
            return redirect()->route('validasiKL.baptisDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Dewasa Telah Disetujui');
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
    
            return redirect()->route('validasiKL.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Bayi Telah Ditolak');
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
    
            return redirect()->route('validasiKL.baptisDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Dewasa Telah Ditolak');
        }
        
    }

    public function komuni()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
            $user = Auth::user()->id;
            
            $reservasi = KomuniPertama::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan]])
            ->orderby('komuni_pertamas.jadwal', 'ASC')
            ->orderby('komuni_pertamas.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('komuni_pertamas')
            ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Komuni Pertama']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Komuni Pertama']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Komuni Pertama']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['komuni_pertamas.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
            
            return view('validasiKL.komuni',compact("reservasi", "reservasiAll", "lingkungan"));
        }
    }

    public function AcceptKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Disetujui Lingkungan";
        $komuni->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
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

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $komuni->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiKL.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Komuni Berhasil Ditolak');
    }

    public function krisma()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan->nama_lingkungan;
            $user = Auth::user()->id;
    
            $reservasi = krisma::where([["status", "Disetujui KBG"], ['lingkungan', $lingkungan], ['jenis', 'Paroki Setempat']])
            ->orderby('krismas.jadwal', 'ASC')
            ->orderby('krismas.updated_at', 'ASC')
            ->get();
    
            $reservasiAll = DB::table('krismas')
            ->join('riwayats', 'krismas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui Lingkungan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orwhere([['riwayats.status', 'Ditolak'], ['lingkungan', $lingkungan], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['lingkungan', $lingkungan], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orderBy('riwayats.updated_at', 'DESC')
            ->get(['krismas.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
            'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);
    
            return view('validasiKL.krisma',compact("reservasi", "reservasiAll", "lingkungan"));
        }
    }

    public function AcceptKrisma(Request $request)
    {
        $krisma=Krisma::find($request->id);
        $krisma->status = "Disetujui Lingkungan";
        $krisma->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $krisma->id;
        $riwayat->jenis_event =  "Krisma Setempat";
        $riwayat->status =  "Disetujui Lingkungan";
        $riwayat->save();

        return redirect()->route('validasiKL.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Berhasil Disetujui');
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

        return redirect()->route('validasiKL.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Berhasil Ditolak');
    }
}
