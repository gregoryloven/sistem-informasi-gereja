<?php

namespace App\Http\Controllers;

use App\Models\Umat;
use App\Models\Lingkungan;
use App\Models\Kbg;
use App\Models\User;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Auth;

class PendaftaranUmatController extends Controller
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
            $ling = Lingkungan::all();
            $kbg = Kbg::all();
            $umatlama = User::where([['status', 'Belum Tervalidasi'], ['id', Auth::user()->id]])
            ->orwhere([['status', 'Tervalidasi'], ['id', Auth::user()->id]])
            ->orwhere([['status', 'Ditolak'], ['id', Auth::user()->id]])
            ->get();
    
            $umatbaru = Umat::where('id', Auth::user()->id);
    
            return view('pendaftaranumat.index',compact("ling","kbg","umatlama","umatbaru"));
        }
    }

    public function showKbg($id)
    {
        $kbg = Kbg::where('lingkungan_id', $id)->get();
    }

    public function InputFormLama(Request $request)
    {
        // return $request->all();
        $user = User::find(Auth()->user()->id);
        $user->lingkungan_id = $request->lingkungan_id_lama;
        $user->kbg_id = $request->kbg_id_lama;
        $user->status = "Belum Tervalidasi";
        $user->save();

        return redirect('/pendaftaranumat')->with('status', 'Pendaftaran Umat Lama Berhasil');
    }

    public function InputFormBaru(Request $request)
    {
        $user = new Umat();
        $user->user_id = Auth::user()->id;
        $user->nama_lengkap = $request->get("nama_lengkap");
        $user->hubungan = $request->get("hubungan_darah");
        $user->jenis_kelamin = $request->get("jenis_kelamin");
        $user->lingkungan_id = $request->get("lingkungan_id_baru");
        $user->kbg_id = $request->get("kbg_id_baru");
        $user->alamat = $request->get("alamat");
        $user->telepon = $request->get("telepon");
        $user->status = "Diproses";

        $file=$request->file('foto_ktp');
        $imgFolder = 'tanda_pengenal/';
        $extension = $request->file('foto_ktp')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $user->foto_ktp=$imgFile;

        $user->save();

        // $riwayat = new Riwayat();
        // $riwayat->user_id = Auth::user()->id;
        // $riwayat->list_event_id = $request->event_id;
        // $riwayat->jenis_event =  "Umat Baru";
        // $riwayat->event_id =  $user->id;
        // $riwayat->status =  "Diproses";
        // $riwayat->save();

        return redirect('/pendaftaranumat')->with('status', 'Pendaftaran Umat Baru Berhasil');
    }

    public function fetchkbg(Request $request)
    {
        $kbg = Kbg::where('lingkungan_id', $request->id)->get();

        // $output = '<option value="">Choose</option>';
        $output = "";
        foreach($kbg as $o) {
            $output .= '<option value="'.$o->id.'">'.$o->nama_kbg.'</option>';
        }
        echo $output;

    }

    public function fetchkbgbaru(Request $request)
    {
        $kbg = Kbg::where('lingkungan_id', $request->id)->get();

        // $output = '<option value="">Choose</option>';
        $output = "";
        foreach($kbg as $o) {
            $output .= '<option value="'.$o->id.'">'.$o->nama_kbg.'</option>';
        }
        echo $output;
    }

    public function Pembatalan(Request $request)
    {
        $data=User::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        return redirect()->route('pendaftaranumat.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Umat Lama Telah Dibatalkan');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function show(Umat $umat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function edit(Umat $umat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Umat $umat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Umat $umat)
    {
        //
    }
}
