<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Krisma;
use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use App\Models\Riwayat;
use App\Models\ListEvent;
use App\Models\Kpp;
use App\Models\Perkawinan;
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

        $reservasi = PendaftaranPelayananLainnya::where('status', 'Disetujui Lingkungan')
        ->orderby('pendaftaran_pelayanan_lainnyas.jadwal', 'ASC')
        ->orderby('pendaftaran_pelayanan_lainnyas.updated_at', 'ASC')
        ->get();

        $reservasiAll = DB::table('pelayanan_lainnyas')
        ->join('pendaftaran_pelayanan_lainnyas', 'pelayanan_lainnyas.id', '=', 'pendaftaran_pelayanan_lainnyas.pelayanan_lainnya_id')
        ->join('riwayats', 'pendaftaran_pelayanan_lainnyas.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Pelayanan']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Pelayanan']])
        ->orderBy('riwayats.updated_at', 'DESC')
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
        $user = Auth::user()->id;
        
        $reservasi = PendaftaranPetugas::where('status', 'Diproses')
        ->orderby('pendaftaran_petugas_liturgis.jadwal', 'ASC')
        ->orderby('pendaftaran_petugas_liturgis.updated_at', 'ASC')
        ->get();

        $reservasiAll = DB::table('pendaftaran_petugas_liturgis')
        ->join('riwayats', 'pendaftaran_petugas_liturgis.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Petugas Liturgi']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Petugas Liturgi']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Petugas Liturgi']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Petugas Liturgi']])
        ->orderBy('riwayats.updated_at', 'DESC')
        ->get(['pendaftaran_petugas_liturgis.*', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiAdmin.petugas',compact("reservasi", "reservasiAll"));
    }

    public function AcceptPetugas(Request $request)
    {
        $petugas=PendaftaranPetugas::find($request->id);
        $petugas->status = "Disetujui Paroki";
        $petugas->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $petugas->id;
        $riwayat->jenis_event =  "Petugas Liturgi";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.petugas', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil Disetujui');
    }

    public function DeclinePetugas(Request $request)
    {
        $petugas=PendaftaranPetugas::find($request->id);
        $petugas->status = "Ditolak";
        $petugas->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $petugas->id;
        $riwayat->jenis_event =  "Petugas Liturgi";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiAdmin.petugas', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil Ditolak');
    }

    public function baptis()
    {
        $user = Auth::user()->id;
        
        $reservasi = Baptis::where([['status', 'Disetujui Lingkungan'], ['jenis', 'Baptis Bayi']])
        ->orderby('baptiss.jadwal', 'ASC')
        ->orderby('baptiss.updated_at', 'ASC')
        ->get();
        
        $reservasiAll = DB::table('baptiss')
        ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Baptis Bayi']])
        ->orderBy('riwayats.updated_at', 'DESC')
        ->get(['baptiss.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiAdmin.baptis',compact("reservasi", "reservasiAll"));
    }

    public function baptisDewasa()
    {
        $user = Auth::user()->id;
        
        $reservasi = Baptis::where([['status', 'Disetujui Lingkungan'], ['jenis', 'Baptis Dewasa']])
        ->orderby('baptiss.jadwal', 'ASC')
        ->orderby('baptiss.updated_at', 'ASC')
        ->get();

        $reservasiAll = DB::table('baptiss')
        ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Baptis Dewasa']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Dewasa']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Baptis Dewasa']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Baptis Dewasa']])
        ->orderBy('riwayats.updated_at', 'DESC')
        ->get(['baptiss.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiAdmin.baptisDewasa',compact("reservasi", "reservasiAll"));
    }

    public function AcceptBaptis(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        if($baptis->jenis == "Baptis Bayi")
        {
            $baptis->status = "Disetujui Paroki";
            $baptis->save();
    
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Bayi";
            $riwayat->status =  "Disetujui Paroki";
            $riwayat->save();
    
            return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Bayi Telah Disetujui');
        }
        else
        {
            $baptis->status = "Disetujui Paroki";
            $baptis->save();
    
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $baptis->id;
            $riwayat->jenis_event =  "Baptis Dewasa";
            $riwayat->status =  "Disetujui Paroki";
            $riwayat->save();
    
            return redirect()->route('validasiAdmin.baptisDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Dewasa Telah Disetujui');
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
    
            return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Bayi Telah Ditolak');
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
    
            return redirect()->route('validasiAdmin.baptisDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Baptis Dewasa Telah Ditolak');
        }
    }

    public function PembatalanBaptis(Request $request)
    {
        $data=Baptis::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();
        
        if($data->jenis == "Baptis Bayi")
        {
            $data->status = "Dibatalkan";

            $riwayat = Riwayat::find($request->riwayatID);
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $data->id;
            $riwayat->jenis_event =  "Baptis Bayi";
            $riwayat->status =  "Dibatalkan";
            $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
            $riwayat->save();
            $data->save();
    
            return redirect()->route('validasiAdmin.baptis', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Baptis Bayi Telah Dibatalkan');
        }
        else
        {
            $data->status = "Dibatalkan";

            $riwayat = Riwayat::find($request->riwayatID);
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $data->id;
            $riwayat->jenis_event =  "Baptis Dewasa";
            $riwayat->status =  "Dibatalkan";
            $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
            $riwayat->save();
            $data->save();
    
            return redirect()->route('validasiAdmin.baptisDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Baptis Dewasa Telah Dibatalkan');
        }
        
    }

    public function komuni(Request $request)
    {
        $user = Auth::user()->id;
        
        $reservasi = KomuniPertama::where('status', 'Disetujui Lingkungan')
        ->orderby('komuni_pertamas.jadwal', 'ASC')
        ->orderby('komuni_pertamas.updated_at', 'ASC')
        ->get();

        $reservasiAll = DB::table('komuni_pertamas')
        ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
        ->join('users', 'riwayats.user_id', '=', 'users.id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Komuni Pertama']])
        ->orderBy('riwayats.updated_at', 'DESC')
        ->get(['komuni_pertamas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiAdmin.komuni',compact("reservasi", "reservasiAll"));
    }

    public function AcceptKomuni(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->status = "Disetujui Paroki";
        $komuni->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
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

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
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

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('validasiAdmin.komuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Komuni Pertama Berhasil Dibatalkan');
    }

    public function KursusKomuni()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Ko%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();

        return view('validasiAdmin.kursusKomuni',compact("data"));
    }

    public function PendaftarKomuni(Request $request)
    {
        $id = $request->id;
        $komuni = DB::table('komuni_pertamas')
        ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
        ->where([['riwayats.list_event_id', $id], ['riwayats.status', 'Disetujui Paroki']])
        ->orderby('komuni_pertamas.nama_lengkap', 'ASC')
        ->get(['komuni_pertamas.*', 'riwayats.id as riwayatID']);
        
        return view('validasiAdmin.DetailKursusKomuni',compact("komuni", "id"));
    }

    public function LulusKursusKomuni(Request $request)
    {
        $array=$request->get("data");
        $status=$request->get("status");
        $list_event_id=$request->get("id");

        foreach($array as $d)
        {
            $komuni=KomuniPertama::find($d['id']);
            
            if($status == 'lulus')
            {
                $komuni->kursus = "Lulus";
                $komuni->save();

                $riwayat = Riwayat::find($d['riwayatID']);
                $riwayat->kursus = "Lulus";
                $riwayat->save();
            }
            else
            {
                $komuni->kursus = "Tidak Lulus";
                $komuni->save();

                $riwayat = Riwayat::find($d['riwayatID']);
                $riwayat->kursus = "Tidak Lulus";
                $riwayat->save();
            }
        }
        return response()->json(array(
            'status'=>'oke'));
    }

    public function krisma()
    {
        $user = Auth::user()->id;
        
        $reservasi = Krisma::where([['status', 'Disetujui Lingkungan'], ['jenis', 'Paroki Setempat']])
        ->orderby('krismas.jadwal', 'ASC')
        ->orderby('krismas.updated_at', 'ASC')
        ->get();

        $reservasi2 = Krisma::where([['status', 'Diproses'], ['jenis', 'Lintas Paroki']])
        ->orderby('krismas.jadwal', 'ASC')
        ->orderby('krismas.updated_at', 'ASC')
        ->get();

        // $reservasiAll = DB::table('krismas')
        // ->join('riwayats', 'krismas.id', '=', 'riwayats.event_id')
        // ->join('users', 'riwayats.user_id', '=', 'users.id')
        // ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Krisma Setempat']])
        // ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Setempat']])
        // ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Setempat']])
        // ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Krisma Setempat']])
        // ->orderBy('krismas.jadwal', 'DESC')
        // ->get(['krismas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        // 'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        // $reservasiAll2 = DB::table('krismas')
        // ->join('riwayats', 'krismas.id', '=', 'riwayats.event_id')
        // ->join('users', 'riwayats.user_id', '=', 'users.id')
        // ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Krisma Lintas']])
        // ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Lintas']])
        // ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Lintas']])
        // ->orwhere([['riwayats.status', 'Selesai'], ['riwayats.jenis_event', 'Krisma Lintas']])
        // ->orderBy('krismas.jadwal', 'DESC')
        // ->get(['krismas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.alasan_penolakan', 
        // 'riwayats.alasan_pembatalan', 'riwayats.created_at', 'riwayats.updated_at', 'users.role']);

        return view('validasiAdmin.krisma',compact("reservasi", "reservasi2"));
    }

    public function AcceptKrismaSetempat(Request $request)
    {
        $krisma=Krisma::find($request->id);
        $krisma->status = "Disetujui Paroki";
        $krisma->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $krisma->id;
        $riwayat->jenis_event =  "Krisma Setempat";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Berhasil Disetujui');
    }

    public function AcceptKrismaLintas(Request $request)
    {
        $krisma=Krisma::find($request->id);
        $krisma->status = "Disetujui Paroki";
        $krisma->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $krisma->id;
        $riwayat->jenis_event =  "Krisma Lintas";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Lintas Paroki Berhasil Disetujui');
    }

    public function DeclineKrismaSetempat(Request $request)
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

        return redirect()->route('validasiAdmin.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Berhasil Ditolak');
    }

    public function DeclineKrismaLintas(Request $request)
    {
        $krisma=Krisma::find($request->id);
        $krisma->status = "Ditolak";
        $krisma->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $krisma->id;
        $riwayat->jenis_event =  "Krisma Lintas";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiAdmin.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Krisma Lintas Paroki Berhasil Ditolak');
    }

    public function PembatalanKrismaSetempat(Request $request)
    {
        $data=Krisma::find($request->id);
        $data->status = "Dibatalkan";

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Krisma Setempat";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('validasiAdmin.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Krisma Berhasil Dibatalkan');
    }

    public function PembatalanKrismaLintas(Request $request)
    {
        $data=Krisma::find($request->id);
        $data->status = "Dibatalkan";

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Krisma Lintas";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('validasiAdmin.krisma', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Krisma Lintas Paroki Berhasil Dibatalkan');
    }

    public function KursusKrisma()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Kr%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();

        return view('validasiAdmin.kursusKrisma',compact("data"));
    }

    public function PendaftarKrisma(Request $request)
    {
        $id = $request->id;
        $krisma = DB::table('krismas')
        ->join('riwayats', 'krismas.id', '=', 'riwayats.event_id')
        ->where([['riwayats.list_event_id', $id], ['riwayats.status', 'Disetujui Paroki']])
        ->orderby('krismas.nama_lengkap', 'ASC')
        ->get(['krismas.*', 'riwayats.id as riwayatID']);
        
        return view('validasiAdmin.DetailKursusKrisma',compact("krisma", "id"));
    }

    public function LulusKursusKrisma(Request $request)
    {
        $array=$request->get("data");
        $status=$request->get("status");
        $list_event_id=$request->get("id");

        foreach($array as $d)
        {
            $krisma=Krisma::find($d['id']);
            
            if($status == 'lulus')
            {
                $krisma->kursus = "Lulus";
                $krisma->save();

                $riwayat = Riwayat::find($d['riwayatID']);
                $riwayat->kursus = "Lulus";
                $riwayat->save();
            }
            else
            {
                $krisma->kursus = "Tidak Lulus";
                $krisma->save();

                $riwayat = Riwayat::find($d['riwayatID']);
                $riwayat->kursus = "Tidak Lulus";
                $riwayat->save();
            }
        }
        return response()->json(array(
            'status'=>'oke'));
    }

    public function kpp()
    {
        $reservasi = Kpp::where('status', 'Diproses')->get();
        $reservasiAll = Kpp::join('riwayats', 'kpps.id', '=', 'riwayats.event_id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'like', 'Kursus%']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.jenis_event', 'like', 'Kursus%']])
        ->orderBy('riwayats.updated_at', 'DESC')
        ->get(['kpps.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 'riwayats.kursus',
         'riwayats.alasan_penolakan', 'riwayats.created_at', 'riwayats.updated_at']);

        return view('validasiAdmin.kpp',compact("reservasi", "reservasiAll"));
    }

    public function DetailKpp(Request $request)
    {
        $id = $request->id;
        $data = Kpp::where('id', $id)->get();

        return view('validasiAdmin.DetailKpp',compact("data"));
    }

    public function AcceptKpp(Request $request)
    {
        $kpp=Kpp::find($request->id);
        $kpp->status = "Disetujui Paroki";
        $kpp->save();

        $list_event = ListEvent::where('keterangan_kursus', $request->keterangan_kursus)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $kpp->id;
        $riwayat->jenis_event = "Kursus Persiapan Perkawinan";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.kpp', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Perkawinan Berhasil Disetujui');
    }

    public function DeclineKpp(Request $request)
    {
        $kpp=Kpp::find($request->id);
        $kpp->status = "Ditolak";
        $kpp->save();

        $list_event = ListEvent::where('keterangan_kursus', $request->keterangan_kursus)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $kpp->id;
        $riwayat->jenis_event = "Kursus Persiapan Perkawinan";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiAdmin.kpp', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Perkawinan Berhasil Ditolak');
    }

    public function PembatalanKpp(Request $request)
    {
        $kpp=Kpp::find($request->id);
        $kpp->delete();

        $riwayat = Riwayat::where([['event_id', $request->id],['jenis_event', 'like', 'Kursus%']])->get();
        foreach($riwayat as $r)
        {
            $r->delete();
        }

        return redirect()->route('validasiAdmin.kpp', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Kursus Persiapan Perkawinan Berhasil Dibatalkan');
    }

    public function KursusKpp()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Kursus%')->get();

        return view('validasiAdmin.kursusKpp',compact("data"));
    }

    public function PendaftarKpp(Request $request)
    {
        $id = $request->id;
        $kpp = Kpp::join('riwayats', 'kpps.id', '=', 'riwayats.event_id')
        ->where([['riwayats.list_event_id', $id], ['riwayats.status', 'Disetujui Paroki']])
        ->orderby('kpps.nama_lengkap_calon_suami', 'ASC')
        ->get(['kpps.*', 'riwayats.id as riwayatID']);
        
        return view('validasiAdmin.DetailKursusKpp',compact("kpp", "id"));
    }

    public function LulusKursusKpp(Request $request)
    {
        $array=$request->get("data");
        $status=$request->get("status");
        $list_event_id=$request->get("id");

        foreach($array as $d)
        {
            $kpp=Kpp::find($d['id']);
            
            if($status == 'lulus')
            {
                $kpp->status = "Lulus";
                $kpp->save();

                $riwayat = Riwayat::find($d['riwayatID']);
                $riwayat->kursus = "Lulus";
                $riwayat->save();
            }
            else
            {
                $kpp->status = "Tidak Lulus";
                $kpp->save();

                $riwayat = Riwayat::find($d['riwayatID']);
                $riwayat->kursus = "Tidak Lulus";
                $riwayat->save();
            }
        }
        return response()->json(array(
            'status'=>'oke'));
    }

    public function perkawinan()
    {
        $reservasi = Perkawinan::where('status', 'Diproses')->get();
        $reservasiAll = Perkawinan::join('riwayats', 'perkawinans.id', '=', 'riwayats.event_id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Perkawinan']])
        ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.jenis_event', 'Perkawinan']])
        ->orderBy('riwayats.updated_at', 'DESC')
        ->get(['perkawinans.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat',
         'riwayats.alasan_penolakan', 'riwayats.created_at', 'riwayats.updated_at']);

        return view('validasiAdmin.perkawinan',compact("reservasi", "reservasiAll"));
    }

    public function DetailPerkawinan(Request $request)
    {
        $id = $request->id;
        $data = Perkawinan::where('id', $id)->get();

        return view('validasiAdmin.DetailPerkawinan',compact("data"));
    }

    public function RiwayatPerkawinan(Request $request)
    {
        $id = $request->id;
        $data = Perkawinan::where('id', $id)->get();

        return view('validasiAdmin.RiwayatPerkawinan',compact("data"));
    }

    public function AcceptPerkawinan(Request $request)
    {
        $perkawinan=Perkawinan::find($request->id);
        $perkawinan->status = "Disetujui Paroki";
        $perkawinan->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();
        $list_event->status = "Aktif";
        $list_event->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $perkawinan->id;
        $riwayat->jenis_event = "Perkawinan";
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('validasiAdmin.perkawinan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Perkawinan Berhasil Disetujui');
    }

    public function DeclinePerkawinan(Request $request)
    {
        $perkawinan=Perkawinan::find($request->id);
        $perkawinan->status = "Ditolak";
        $perkawinan->save();

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id =  $list_event->id;
        $riwayat->event_id =  $perkawinan->id;
        $riwayat->jenis_event = "Perkawinan";
        $riwayat->status =  "Ditolak";
        $riwayat->alasan_penolakan = $request->get("alasan_penolakan");
        $riwayat->save();

        return redirect()->route('validasiAdmin.perkawinan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Perkawinan Berhasil Ditolak');
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Perkawinan::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('validasiAdmin.EditForm',compact("data"))->render()),200);
    }

    public function Update(Request $request)
    {
        $data=Perkawinan::find($request->id);

        $list=ListEvent::where([['jenis_event', 'Perkawinan'], ['jadwal_pelaksanaan', $data->tanggal_perkawinan]])
        ->update(['jadwal_pelaksanaan' => $request->get('tanggal_perkawinan')]);

        $data->tanggal_perkawinan = $request->get('tanggal_perkawinan');
        $data->save();

        return redirect()->route('validasiAdmin.perkawinan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tanggal & Waktu Perkawinan Berhasil Diubah');
    }

    public function PembatalanPerkawinan(Request $request)
    {
        $perkawinan=Perkawinan::find($request->id);
        $perkawinan->delete();

        $riwayat = Riwayat::where([['event_id', $request->id],['jenis_event', 'Perkawinan']])->get();
        foreach($riwayat as $r)
        {
            $r->delete();
        }

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();
        $list_event->delete();

        return redirect()->route('validasiAdmin.perkawinan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Perkawinan Berhasil Dibatalkan');
    }
}
