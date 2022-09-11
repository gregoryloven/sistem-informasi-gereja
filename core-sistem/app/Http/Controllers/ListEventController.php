<?php

namespace App\Http\Controllers;

use App\Models\ListEvent;
use App\Models\PetugasLiturgi;
use Illuminate\Http\Request;
use DB;

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
        ->where('list_events.jenis_event', '!=', 'Petugas Liturgi')
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.tgl_buka_pendaftaran',
        'list_events.tgl_tutup_pendaftaran','list_events.jadwal_pelaksanaan','list_events.lokasi','list_events.kuota',
        'list_events.romo',
        ]);

        $data2 = DB::table('list_events')
        ->join('petugas_liturgis', 'list_events.petugas_liturgi_id', '=', 'petugas_liturgis.id')
        ->where('list_events.jenis_event', 'Petugas Liturgi')
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.tgl_buka_pendaftaran',
        'list_events.tgl_tutup_pendaftaran','list_events.jadwal_pelaksanaan','list_events.lokasi','petugas_liturgis.jenis_petugas as jenisPetugas'
        ]);

        return view('listevent.index',compact("data", "petugas", "data2"));
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
        $data->romo = $request->get('romo');
        $data->kuota = $request->get('kuota');
        $data->save();

        return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil ditambahkan');

    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=ListEvent::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('listevent.EditForm',compact("data"))->render()),200);
    }

    public function update(Request $request, ListEvent $listEvent)
    {
        $data=ListEvent::find($request->id);
        $data->nama_event = $request->get('nama_event');
        $data->jenis_event = $request->get('jenis_event');
        $data->petugas_liturgi_id = $request->get('petugas_liturgi_id');
        $data->tgl_buka_pendaftaran = $request->get('tgl_buka_pendaftaran');
        $data->tgl_tutup_pendaftaran = $request->get('tgl_tutup_pendaftaran');
        $data->jadwal_pelaksanaan = $request->get('jadwal_pelaksanaan');
        $data->lokasi = $request->get('lokasi');
        $data->romo = $request->get('romo');
        $data->kuota = $request->get('kuota');
        $data->save();
    }

    public function destroy(Request $request)
    {
        $data=ListEvent::find($request->id);
        try
        {
            $data->delete();
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data List Event Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $data = "Gagal Menghapus Data List Event";
            return redirect()->route('listevent.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
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
