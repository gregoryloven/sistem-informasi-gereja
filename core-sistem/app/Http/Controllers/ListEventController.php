<?php

namespace App\Http\Controllers;

use App\Models\ListEvent;
use App\Models\PetugasLiturgi;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Krisma;
use App\Models\MisaUsers;
use App\Models\TobatUsers;
use App\Models\PendaftaranPetugas;
use App\Models\Riwayat;
use App\Models\Kpp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Auth;
use PDF;


class ListEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petugas=PetugasLiturgi::all();
        $data = DB::table('list_events')
        ->where([['list_events.jenis_event', 'like', 'Baptis%'],['list_events.jenis_event', '=', 'Komuni'],['list_events.jenis_event', '=', 'Krisma']])
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.tgl_buka_pendaftaran',
        'list_events.tgl_tutup_pendaftaran','list_events.jadwal_pelaksanaan','list_events.lokasi', 'list_events.keterangan_kursus', 
        'list_events.romo', 'list_events.status'
        ]);

        $data2 = DB::table('list_events')
        ->where('list_events.jenis_event', '=', 'Misa')
        ->orwhere('list_events.jenis_event', '=', 'Tobat')
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.jadwal_pelaksanaan',
        'list_events.lokasi','list_events.kuota','list_events.romo', 'list_events.status'
        ]);

        $data3 = DB::table('list_events')
        ->join('petugas_liturgis', 'list_events.petugas_liturgi_id', '=', 'petugas_liturgis.id')
        ->where('list_events.jenis_event', 'Petugas Liturgi')
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.tgl_buka_pendaftaran',
        'list_events.tgl_tutup_pendaftaran','list_events.jadwal_pelaksanaan','list_events.lokasi','petugas_liturgis.jenis_petugas as jenisPetugas',
        'list_events.status'
        ]);

        $data4 = DB::table('list_events')
        ->where('list_events.jenis_event', 'Kursus Persiapan Perkawinan')
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.tgl_buka_pendaftaran',
        'list_events.tgl_tutup_pendaftaran','list_events.lokasi','list_events.keterangan_kursus','list_events.status'
        ]);

        return view('listevent.index',compact("data", "petugas", "data2", "data3", "data4"));
    }

    public function store(Request $request)
    {
        $data = new ListEvent();
        $data->nama_event = $request->get('nama_event');
        $data->jenis_event = $request->get('jenis_event');
        $data->petugas_liturgi_id = $request->get('petugas_liturgi_id');
        $data->tgl_buka_pendaftaran = $request->get('tgl_buka_pendaftaran');
        $data->tgl_tutup_pendaftaran = $request->get('tgl_tutup_pendaftaran');
        $data->jadwal_pelaksanaan = $request->get('jadwal_pelaksanaan');
        $data->lokasi = $request->get('lokasi');
        $data->keterangan_kursus = $request->get('keterangan_kursus');
        $data->romo = $request->get('romo');
        $data->kuota = $request->get('kuota');
        $data->status = "Aktif";
        $data->save();

        return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Ditambahkan');

    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=ListEvent::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('listevent.EditForm',compact("data"))->render()),200);
    }

    public function update(Request $request)
    {
        $data=ListEvent::find($request->id);

        $baptis=Baptis::where([['jenis', '=', $data->jenis_event], ['jadwal', '=', $data->jadwal_pelaksanaan]])
        ->update(['jadwal' => $request->get('jadwal_pelaksanaan'), 
        'lokasi' => $request->get('lokasi'), 'romo' => $request->get('romo')]);
        
        $komuni=KomuniPertama::where('jadwal', '=', $data->jadwal_pelaksanaan)
        ->update(['jadwal' => $request->get('jadwal_pelaksanaan'), 
        'lokasi' => $request->get('lokasi'), 'romo' => $request->get('romo')]);

        $krisma=Krisma::where('jadwal', '=', $data->jadwal_pelaksanaan)
        ->update(['jadwal' => $request->get('jadwal_pelaksanaan'), 
        'lokasi' => $request->get('lokasi'), 'romo' => $request->get('romo')]);

        $kpp=Kpp::where('keterangan_kursus', '=', $data->keterangan_kursus)
        ->update(['keterangan_kursus' => $request->get('keterangan_kursus'), 
        'lokasi' => $request->get('lokasi')]);

        // $misa=MisaUsers::where('jadwal', '=', $data->jadwal_pelaksanaan)
        // ->update(['jadwal' => $request->get('jadwal_pelaksanaan'), 
        // 'lokasi' => $request->get('lokasi'), 'romo' => $request->get('romo'), 'kuota' => $request->get('kuota')]);

        // $tobat=TobatUsers::where('list_event_id', '=', $data->id)
        // ->update(['jadwal' => $request->get('jadwal_pelaksanaan'), 
        // 'lokasi' => $request->get('lokasi'), 'romo' => $request->get('romo'), 'kuota' => $request->get('kuota')]);

        $petugas=PendaftaranPetugas::where('jadwal', '=', $data->jadwal_pelaksanaan)
        ->update(['jadwal' => $request->get('jadwal_pelaksanaan'), 
        'lokasi' => $request->get('lokasi')]);

        $data->nama_event = $request->get('nama_event');
        // $data->jenis_event = $request->get('jenis_event');
        // $data->petugas_liturgi_id = $request->get('petugas_liturgi_id');
        $data->tgl_buka_pendaftaran = $request->get('tgl_buka_pendaftaran');
        $data->tgl_tutup_pendaftaran = $request->get('tgl_tutup_pendaftaran');
        $data->jadwal_pelaksanaan = $request->get('jadwal_pelaksanaan');
        $data->lokasi = $request->get('lokasi');
        $data->keterangan_kursus = $request->get('keterangan_kursus');
        $data->romo = $request->get('romo');
        $data->kuota = $request->get('kuota');
        $data->save();
        

        return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diubah');

    }

    public function destroy(Request $request)
    {
        // return $request->all();
        $data=ListEvent::find($request->id);
        // return $data;

        if($data->jenis_event == "Baptis Bayi"){
            $baptis=Baptis::where([['jenis', '=', $data->jenis_event], ['jadwal', '=', $data->jadwal_pelaksanaan]])->get();
            if($baptis->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($baptis as $b){
                    $b->status = "Dibatalkan";
                    $b->save();
                }

                $riwayat =  Riwayat::where('list_event_id', $request->id)->get();
                foreach($riwayat as $r){
                    $riwayats= new Riwayat();
                    $riwayats->user_id = Auth::user()->id;
                    $riwayats->list_event_id = $r->list_event_id;
                    $riwayats->event_id = $r->event_id;
                    $riwayats->jenis_event = $r->jenis_event;
                    $riwayats->status = "Dibatalkan";
                    $riwayats->save();
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        }else if($data->jenis_event == "Baptis Dewasa"){
            $baptis=Baptis::where([['jenis', '=', $data->jenis_event], ['jadwal', '=', $data->jadwal_pelaksanaan]])->get();
            if($baptis->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($baptis as $b){
                    $b->status = "Dibatalkan";
                    $b->save();
                }
                $riwayat =  Riwayat::where('list_event_id', $request->id)->get();
                foreach($riwayat as $r){
                    $riwayats= new Riwayat();
                    $riwayats->user_id = Auth::user()->id;
                    $riwayats->list_event_id = $r->list_event_id;
                    $riwayats->event_id = $r->event_id;
                    $riwayats->jenis_event = $r->jenis_event;
                    $riwayats->status = "Dibatalkan";
                    $riwayats->save();
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        }else if($data->jenis_event == "Komuni Pertama"){
            $komunipertama=KomuniPertama::where('jadwal', '=', $data->jadwal_pelaksanaan)->get();
            if($komunipertama->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($komunipertama as $k){
                    $k->status = "Dibatalkan";
                    $k->save();
                }
                $riwayat =  Riwayat::where('list_event_id', $request->id)->get();
                foreach($riwayat as $r){
                    $riwayats= new Riwayat();
                    $riwayats->user_id = Auth::user()->id;
                    $riwayats->list_event_id = $r->list_event_id;
                    $riwayats->event_id = $r->event_id;
                    $riwayats->jenis_event = $r->jenis_event;
                    $riwayats->status = "Dibatalkan";
                    $riwayats->save();
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        }else if($data->jenis_event == "Krisma"){
            $krisma=Krisma::where('jadwal', '=', $data->jadwal_pelaksanaan)->get();
            if($krisma->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($krisma as $k){
                    $k->status = "Dibatalkan";
                    $k->save();
                }
                $riwayat =  Riwayat::where('list_event_id', $request->id)->get();
                foreach($riwayat as $r){
                    $riwayats= new Riwayat();
                    $riwayats->user_id = Auth::user()->id;
                    $riwayats->list_event_id = $r->list_event_id;
                    $riwayats->event_id = $r->event_id;
                    $riwayats->jenis_event = $r->jenis_event;
                    $riwayats->status = "Dibatalkan";
                    $riwayats->save();
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        } else if($data->jenis_event == "Petugas Liturgi") {
            $petugas=PendaftaranPetugas::where('jadwal', '=', $data->jadwal_pelaksanaan)->get();
            if($petugas->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($petugas as $k){
                    $k->status = "Dibatalkan";
                    $k->save();
                }
                $riwayat =  Riwayat::where('list_event_id', $request->id)->get();
                foreach($riwayat as $r){
                    $riwayats= new Riwayat();
                    $riwayats->user_id = Auth::user()->id;
                    $riwayats->list_event_id = $r->list_event_id;
                    $riwayats->event_id = $r->event_id;
                    $riwayats->jenis_event = $r->jenis_event;
                    $riwayats->status = "Dibatalkan";
                    $riwayats->save();
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        }
        else if($data->jenis_event == "Misa"){
            $misa=MisaUsers::where('list_events_id', $data->id)->get();
            if($misa->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($misa as $b){
                    $misas = DB::table('misa_users')->where('list_events_id', $b->list_events_id)->update(['status' => 'Dibatalkan']);
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        }else if($data->jenis_event == "Tobat"){
            $tobat=TobatUsers::where('list_events_id', $data->id)->get();
            if($tobat->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($tobat as $b){
                    $tobats = DB::table('tobat_users')->where('list_events_id', $b->list_events_id)->update(['status' => 'Dibatalkan']);
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        }else if($data->jenis_event == "Kursus Persiapan Perkawinan"){
            $kpp=Kpp::where('keterangan_kursus', '=', $data->keterangan_kursus)->get();
            if($kpp->count() > 0){
                $data->status = "Dibatalkan";
                $data->save();
                foreach($kpp as $k){
                    $k->status = "Dibatalkan";
                    $k->save();
                }
                $riwayat =  Riwayat::where('list_event_id', $request->id)->get();
                foreach($riwayat as $r){
                    $riwayats= new Riwayat();
                    $riwayats->user_id = Auth::user()->id;
                    $riwayats->list_event_id = $r->list_event_id;
                    $riwayats->event_id = $r->event_id;
                    $riwayats->jenis_event = $r->jenis_event;
                    $riwayats->status = "Dibatalkan";
                    $riwayats->save();
                }
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Event Berhasil Dibatalkan');
            } else {
                $data->delete();
                return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Dihapus');
            }
        }
    }
    
    public function selesai(Request $request)
    {
        // return $request->all();

        $listevent = ListEvent::find($request->id);
        $listevent->status = "Selesai";
        $listevent->save();
        if($listevent->jenis_event == "Baptis Bayi"){
            $baptis = Baptis::where([['jadwal', '=', $request->jadwal_pelaksanaan],['jenis', 'Baptis Bayi'],['status', 'Disetujui Paroki']])->get();
            foreach($baptis as $b){
                $b->status = "Selesai";
                $b->save();
            }

            $riwayat =  Riwayat::where([['list_event_id', $request->id],['status', 'Disetujui Paroki']])->get();
            foreach($riwayat as $r){
                $riwayats= new Riwayat();
                $riwayats->user_id = Auth::user()->id;
                $riwayats->list_event_id = $r->list_event_id;
                $riwayats->event_id = $r->event_id;
                $riwayats->jenis_event = $r->jenis_event;
                $riwayats->status = "Selesai";
                $riwayats->save();
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        } else if($listevent->jenis_event == "Baptis Dewasa") {
            $baptis = Baptis::where([['jadwal', '=', $request->jadwal_pelaksanaan],['jenis', 'Baptis Dewasa'],['status', 'Disetujui Paroki']])->get();
            foreach($baptis as $b){
                $b->status = "Selesai";
                $b->save();
            }

            $riwayat =  Riwayat::where([['list_event_id', $request->id],['status', 'Disetujui Paroki']])->get();
            foreach($riwayat as $r){
                $riwayats= new Riwayat();
                $riwayats->user_id = Auth::user()->id;
                $riwayats->list_event_id = $r->list_event_id;
                $riwayats->event_id = $r->event_id;
                $riwayats->jenis_event = $r->jenis_event;
                $riwayats->status = "Selesai";
                $riwayats->save();
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        } else if($listevent->jenis_event == "Komuni Pertama") {
            $komunipertama = KomuniPertama::where([['jadwal', '=', $request->jadwal_pelaksanaan],['kursus', 'Lulus']])->get();
            foreach($komunipertama as $k){
                $k->status = "Selesai";
                $k->save();
            }

            $riwayat =  Riwayat::where([['list_event_id', $request->id],['kursus', 'Lulus']])->get();
            foreach($riwayat as $r){
                $riwayats= new Riwayat();
                $riwayats->user_id = Auth::user()->id;
                $riwayats->list_event_id = $r->list_event_id;
                $riwayats->event_id = $r->event_id;
                $riwayats->jenis_event = $r->jenis_event;
                $riwayats->status = "Selesai";
                $riwayats->kursus = "Lulus";
                $riwayats->save();
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        } else if($listevent->jenis_event == "Krisma") {
            $krisma = Krisma::where([['jadwal', '=', $request->jadwal_pelaksanaan],['kursus', 'Lulus']])->get();
            foreach($krisma as $k){
                $k->status = "Selesai";
                $k->save();
            }

            $riwayat =  Riwayat::where([['list_event_id', $request->id],['kursus', 'Lulus']])->get();
            foreach($riwayat as $r){
                $riwayats= new Riwayat();
                $riwayats->user_id = Auth::user()->id;
                $riwayats->list_event_id = $r->list_event_id;
                $riwayats->event_id = $r->event_id;
                $riwayats->jenis_event = $r->jenis_event;
                $riwayats->status = "Selesai";
                $riwayats->kursus = "Lulus";
                $riwayats->save();
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        } else if($listevent->jenis_event == "Petugas Liturgi") {
            $petugas = PendaftaranPetugas::where([['jadwal', '=', $request->jadwal_pelaksanaan],['status', 'Disetujui Paroki']])->get();
            foreach($petugas as $p){
                $p->status = "Selesai";
                $p->save();
            }

            $riwayat =  Riwayat::where([['list_event_id', $request->id],['status', 'Disetujui Paroki']])->get();
            foreach($riwayat as $r){
                $riwayats= new Riwayat();
                $riwayats->user_id = Auth::user()->id;
                $riwayats->list_event_id = $r->list_event_id;
                $riwayats->event_id = $r->event_id;
                $riwayats->jenis_event = $r->jenis_event;
                $riwayats->status = "Selesai";
                $riwayats->save();
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        } else if($listevent->jenis_event == "Misa") {
            $misa = MisaUsers::where('list_events_id', '=', $request->id)->get();
            foreach($misa as $m){
                $misas = DB::table('misa_users')->where('list_events_id', $m->list_events_id)->update(['status' => 'Selesai']);
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        } else if($listevent->jenis_event == "Tobat") {
            $tobat = TobatUsers::where('list_events_id', '=', $request->id)->get();
            foreach($tobat as $t){
                $tobats = DB::table('tobat_users')->where('list_events_id', $t->list_events_id)->update(['status' => 'Selesai']);
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        } else if($listevent->jenis_event == "Kursus Persiapan Perkawinan") {
            $kpp = Kpp::where([['keterangan_kursus', '=', $request->keterangan_kursus],['status', 'Lulus']])->get();
            foreach($kpp as $k){
                $k->status = "Selesai";
                $k->save();
            }

            $riwayat =  Riwayat::where([['list_event_id', $request->id],['kursus', 'Lulus']])->get();
            foreach($riwayat as $r){
                $riwayats= new Riwayat();
                $riwayats->user_id = Auth::user()->id;
                $riwayats->list_event_id = $r->list_event_id;
                $riwayats->event_id = $r->event_id;
                $riwayats->jenis_event = $r->jenis_event;
                $riwayats->status = "Selesai";
                $riwayats->save();
            }
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil Diselesaikan');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListEvent  $listEvent
     * @return \Illuminate\Http\Response
     */
    public function show(ListEvent $listEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListEvent  $listEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(ListEvent $listEvent)
    {
        //
    }
}
