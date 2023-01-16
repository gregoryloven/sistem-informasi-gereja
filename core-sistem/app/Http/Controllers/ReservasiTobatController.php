<?php

namespace App\Http\Controllers;

use App\Models\Tobat;
use App\Models\TobatUsers;
use App\Models\ListEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Auth;

class ReservasiTobatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 'umat')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where([['jenis_event', 'like', 'To%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
            
            $tobat = DB::table('list_events')
            ->join('tobat_users', 'list_events.id', '=', 'tobat_users.list_events_id')
            ->where('users_id', Auth::user()->id)
            ->get(['list_events.*', 'tobat_users.users_id as usersID', 'tobat_users.list_events_id as listeventsID', 
            'tobat_users.kode_booking', 'tobat_users.jumlah_tiket', 'tobat_users.status', 'tobat_users.created_at', 
            'tobat_users.updated_at']);

            return view('reservasitobat.index',compact("data", "tobat"));
        }
    }

    public function PesanTiket(Request $request)
    {
        $id=$request->get("id");
        $list=ListEvent::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('reservasitobat.PesanTiket',compact('list'))->render()),200);
    }

    public function store(Request $request)
    {
        // return $request->all();
        $kode = Str::random(6);

        $listevent = ListEvent::where('id', $request->get('id'))->first();
        if($listevent->kuota > $request->get('jumlah_tiket')){
            $cek_maks_pesan = TobatUsers::where('users_id', Auth::user()->id)->where('status', 'Aktif')->get();
            $maks_pesan = $request->get('jumlah_tiket');
            foreach($cek_maks_pesan as $cek){
                $maks_pesan += $cek->jumlah_tiket;
            }
            // return $maks_pesan;

            if($maks_pesan <= 5){
                $listevent->kuota -= $request->get('jumlah_tiket');
                $listevent->save();
    
                $tobats = new TobatUsers();
                $tobats->users_id = Auth::user()->id;
                $tobats->list_events_id = $listevent->id;
                $tobats->kode_booking = strtoupper($kode);
                $tobats->jumlah_tiket = $request->get('jumlah_tiket');
                $tobats->status = "Aktif";
                $tobats->save();
            } else {
                return redirect()->back()->with('error', 'Maaf, Anda sudah melebihi batas maksimal pesan tiket. Maksimal 5 Tiket');
            }

        } else {
            return redirect()->back()->with('error', 'Kuota tidak mencukupi');
        }

        return redirect()->route('reservasitobat.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tiket Pengakuan Dosa Berhasil Dipesan');
    }

    public function Pembatalan(Request $request)
    {
        // return $request->all();
        $tobats = TobatUsers::where('kode_booking', $request->kode_booking)->update([
            'status' => 'Dibatalkan',
        ]);

        $listevent = ListEvent::where('id', $request->listeventsID)->first();
        $listevent->kuota += $request->jumlah_tiket;
        $listevent->save();

        return redirect()->route('reservasitobat.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tiket Pengakuan Dosa Telah Dibatalkan');
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
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function show(Tobat $tobat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function edit(Tobat $tobat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tobat $tobat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tobat $tobat)
    {
        //
    }
}
