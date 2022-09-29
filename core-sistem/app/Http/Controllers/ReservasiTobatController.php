<?php

namespace App\Http\Controllers;

use App\Models\Tobat;
use App\Models\TobatUsers;
use App\Models\ListEvent;
use Illuminate\Http\Request;
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
        $data = DB::table('list_events')
                ->where('jenis_event', 'like', 'To%')
                ->get();
                
        $tobat = DB::table('tobats')
        ->join('tobat_users', 'tobats.id', '=', 'tobat_users.tobats_id')
        ->where('users_id', Auth::user()->id)
        ->get(['tobats.*', 'tobat_users.users_id', 'tobat_users.tobats_id as tobatsID', 
        'tobat_users.kode_booking', 'tobat_users.jumlah_tiket', 'tobat_users.status', 'tobat_users.created_at', 
        'tobat_users.updated_at']);

        return view('reservasitobat.index',compact("data", "tobat"));
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
        $data = new Tobat();
        $data->jadwal = $request->get('jadwal');
        $data->lokasi = $request->get('lokasi');
        $data->kuota = $request->get('kuota');
        $data->romo = $request->get('romo');
        $data->save();

        $tobats = new TobatUsers();
        $tobats->users_id = Auth::user()->id;
        $tobats->tobats_id = $data->id;
        $tobats->kode_booking = "abc";
        $tobats->jumlah_tiket = $request->get('jumlah_tiket');
        $tobats->status = "Aktif";
        $tobats->save();

        return redirect()->route('reservasitobat.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tiket Tobat Berhasil Dipesan');
    }

    public function Pembatalan(Request $request)
    {
        $data=Tobat::find($request->id);

        $tobats = TobatUsers::find($request->tobatsID);
        $tobats->status = "Dibatalkan";
        $tobats->save();

        return redirect()->route('reservasitobat.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tiket Tobat Telah Dibatalkan');
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
