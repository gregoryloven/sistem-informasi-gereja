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
            // $ling = Lingkungan::all();
            // $kbg = Kbg::all();
            // $umatlama = User::join('riwayats', 'users.id', '=', 'riwayats.user_id')
            // ->where([['users.status', 'Belum Tervalidasi'], ['users.id', Auth::user()->id], ['jenis_event', 'Umat Lama']])
            // ->orwhere([['users.status', 'Tervalidasi'], ['users.id', Auth::user()->id], ['jenis_event', 'Umat Lama']])
            // ->orwhere([['users.status', 'Ditolak'], ['users.id', Auth::user()->id], ['jenis_event', 'Umat Lama']])
            // ->get(['users.*','riwayats.id as riwayatID', 'riwayats.status as statusRiwayat',
            // 'riwayats.created_at as riwayatcreated', 'riwayats.updated_at as riwayatupdated', 
            // 'riwayats.alasan_penolakan']);

            // $umatbaru = Umat::where('user_id', Auth::user()->id)->get();
    
            // return view('pendaftaranumat.index',compact("ling","kbg","umatlama","umatbaru"));

            $cek = User::where('users.id', Auth::user()->id)->first();

            $data = Umat::join('users', 'umats.user_id', '=', 'users.id')
            ->where('user_id', Auth::user()->id)->get();

            return view('pendaftaranumat.index',compact("data","cek"));

        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $ling = Lingkungan::all();
        $kbg = Kbg::all();
        $data=User::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranumat.EditForm',compact("data","ling","kbg"))->render()),200);
    }

    public function fetchkbg(Request $request)
    {
        $kbg = Kbg::where('lingkungan_id', $request->id)->get();

        // $output = '<option value="">Choose</option>';
        $output = "";
        foreach($kbg as $o) {
            $output .= '<option value="'.$o->id.'">'.$o->nama_kbg.' ('.$o->batasan_wilayah.')</option>';
        }
        echo $output;
    }

    public function validasilingkungan(Request $request)
    {
        $user = User::find($request->user_id);
        $user->lingkungan_id = $request->get("lingkungan_id");
        $user->kbg_id = $request->get("kbg_id");
        $user->status = "Belum Tervalidasi";

        $umat = Umat::find($request->id);
        $umat->lingkungan_id = $request->get("lingkungan_id");
        $umat->kbg_id = $request->get("kbg_id");

        $file=$request->file('surat_baptis');
        if(isset($file))
        {
            $imgFolder = 'file_sertifikat/surat_baptis/';
            $extension = $request->file('surat_baptis')->extension();
            $imgFile=time()."_".$request->get('nama').".".$extension;
            $file->move($imgFolder,$imgFile);
            $umat->surat_baptis=$imgFile;
        }

        $file2=$request->file('sertifikat_komuni');
        if(isset($file2))
        {
            $imgFolder2 = 'file_sertifikat/sertifikat_komuni/';
            $extension2 = $request->file('sertifikat_komuni')->extension();
            $imgFile2=time()."_".$request->get('nama').".".$extension2;
            $file2->move($imgFolder2,$imgFile2);
            $umat->sertifikat_komuni=$imgFile2;
        }

        $user->save();
        $umat->save();

        return redirect('/pendaftaranumat')->with('status', 'Pendaftaran Umat Berhasil Diproses');
    }

    public function create()
    {
        $user = User::join('umats', 'users.id', '=', 'umats.user_id')
        ->where('users.id', Auth::user()->id)->first();
        return view('pendaftaranumat.InputForm', compact('user'));
    }

    public function store(Request $request)
    {
        $umat = new Umat();
        $umat->user_id = Auth::user()->id;
        $umat->nama_lengkap = $request->get("nama_lengkap");
        $umat->hubungan = $request->get("hubungan");
        $umat->no_kk = $request->get("no_kk");
        $umat->tempat_lahir = $request->get("tempat_lahir");
        $umat->tanggal_lahir = $request->get("tanggal_lahir");
        $umat->jenis_kelamin = $request->get("jenis_kelamin");
        $umat->alamat = $request->get("alamat");
        $umat->telepon = $request->get("telepon");
        $umat->lingkungan_id = $request->get("lingkungan_id");
        $umat->kbg_id = $request->get("kbg_id");

        $file=$request->file('surat_baptis');
        if(isset($file))
        {
            $imgFolder = 'file_sertifikat/surat_baptis/';
            $extension = $request->file('surat_baptis')->extension();
            $imgFile=time()."_".$request->get('nama').".".$extension;
            $file->move($imgFolder,$imgFile);
            $umat->surat_baptis=$imgFile;
        }

        $file2=$request->file('sertifikat_komuni');
        if(isset($file2))
        {
            $imgFolder2 = 'file_sertifikat/sertifikat_komuni/';
            $extension2 = $request->file('sertifikat_komuni')->extension();
            $imgFile2=time()."_".$request->get('nama').".".$extension2;
            $file2->move($imgFolder2,$imgFile2);
            $umat->sertifikat_komuni=$imgFile2;
        }

        $umat->save();

        return redirect('/pendaftaranumat')->with('status', 'Pendaftaran Anggota Keluarga Berhasil');
    }

    public function showKbg($id)
    {
        $kbg = Kbg::where('lingkungan_id', $id)->get();
    }

    public function InputFormLama(Request $request)
    {
        // return $request->all();
        $user = User::find(Auth()->user()->id);

        if($user->status != null)
        {
            $riwayat = Riwayat::find($request->riwayatID);
            $riwayat->status =  "Belum Tervalidasi";
            $riwayat->save();

            $user->lingkungan_id = $request->lingkungan_id_lama;
            $user->kbg_id = $request->kbg_id_lama;
            $user->status = "Belum Tervalidasi";
            $user->save();

            return redirect('/pendaftaranumat')->with('status', 'Pendaftaran Umat Lama atau Validasi Akun Umat Berhasil');
        }
        else
        {
            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->jenis_event =  "Umat Lama";
            $riwayat->event_id =  $user->id;
            $riwayat->status =  "Belum Tervalidasi";
            $riwayat->save();

            $user->lingkungan_id = $request->lingkungan_id_lama;
            $user->kbg_id = $request->kbg_id_lama;
            $user->status = "Belum Tervalidasi";
            $user->save();

            return redirect('/pendaftaranumat')->with('status', 'Pendaftaran Umat Lama atau Validasi Akun Umat Berhasil');
        }
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
        $user->no_kk = $request->get("no_kk");
        $user->status = "Diproses";

        $file=$request->file('foto_ktp');
        $imgFolder = 'tanda_pengenal/';
        $extension = $request->file('foto_ktp')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $user->foto_ktp=$imgFile;

        $user->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->jenis_event =  "Umat Baru";
        $riwayat->event_id =  $user->id;
        $riwayat->status =  "Diproses";
        $riwayat->save();

        return redirect('/pendaftaranumat')->with('status', 'Pendaftaran Umat Baru Berhasil');
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Umat Baru']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranumat.detail', compact("log"))->render()),200);
    }

    public function update(Request $request)
    {
        $user=Umat::find($request->id);
        $user->nama_lengkap = $request->get("nama_lengkap");
        $user->hubungan = $request->get("hubungan_darah");
        $user->jenis_kelamin = $request->get("jenis_kelamin");
        $user->alamat = $request->get("alamat");
        $user->telepon = $request->get("telepon");
        $user->no_kk = $request->get("no_kk");
        $user->status = "Diproses";

        $file=$request->file('foto_ktp');
        if(isset($file))
        {
            $imgFolder = 'tanda_pengenal/';
            $extension = $request->file('foto_ktp')->extension();
            $imgFile=time()."_".$request->get('nama').".".$extension;
            $file->move($imgFolder,$imgFile);
            $user->foto_ktp=$imgFile;
        }

        $user->save();

        return redirect('/pendaftaranumat')->with('status', 'Ubah Pendaftaran Umat Baru Berhasil');
    }

    public function Pembatalan(Request $request)
    {
        $data=User::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat=Riwayat::find($request->riwayatID);
        $riwayat->delete();

        return redirect()->route('pendaftaranumat.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Umat Lama Telah Dibatalkan');
    }

    public function destroy(Request $request)
    {
        $riwayat = Riwayat::where([['event_id', $request->id],['jenis_event', 'Umat Baru']])->get();
        $riwayat->delete();
        
        $umat=Umat::find($request->id);
        $umat->delete();

        return redirect()->route('pendaftaranumat.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Umat Berhasil Dibatalkan');
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

}
