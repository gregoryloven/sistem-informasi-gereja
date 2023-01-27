<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umat;
use App\Models\KomuniPertama;
use App\Models\ListEvent;
use App\Models\Riwayat;
use App\Models\Setting;
use DB;
use Auth;
use PDF;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PendaftaranKomuniController extends Controller
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
            $data = ListEvent::where([['jenis_event', 'like', 'Ko%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
            $komuni = KomuniPertama::where('user_id', Auth::user()->id)->get();
            $user = User::all();
            return view('pendaftarankomuni.index',compact("data", "komuni", "user"));
        }
    }

    public function OpenForm(Request $request)
    {
        // $this->authorize('lingkungan-permission');
        if(Auth::user()->status !== "Tervalidasi"){
            return redirect()->back()->with('error', 'Anda Belum Terdaftar Sebagai Umat Pada Lingkungan & Kbg Yang ada. Silahkan Daftar Halaman Pendaftaran Umat');
        } else {
            $id = $request->id;
        
            $list = DB::table('list_events')->where('id', $id)->get();

            $user = Umat::join('users', 'umats.user_id', '=', 'users.id')
            ->where('user_id', Auth::user()->id)->get(['umats.*', 'users.id as userid']);

            $setting = Setting::first();
    
            return view('pendaftarankomuni.InputForm',compact("list", "user", "setting"));
        }
    }

    public function FetchIdentitas(Request $request)
    {
        $data=$request->get("id");
        $user = Umat::where('id', $data)->get();
        return response()->json($user);
    }

    public function InputForm(Request $request)
    {
        $cek = Umat::where('id', $request->user_id_penerima)->first();
        $setting = Setting::first();

        $date = new DateTime($request->get("tanggal_lahir"));
        $now = new DateTime();
        $a = $now->diff($date);
        $umur = (int)$a->y;

        if($cek->status_baptis != 'Sudah Baptis')
        {
            return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error2', 'Pendaftaran Komuni Pertama Gagal. Identitas Yang Diinputkan Belum Menerima Baptis');
        }
        else
        {
            if($cek->status_komuni == 'Sudah Komuni')
            {
                return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error2', 'Pendaftaran Komuni Pertama Gagal. Identitas Yang Diinputkan Sudah Menerima Komuni Pertama');
            }
            else
            {
                if($umur >= $setting->umur_komuni)
                {
                    $data = new KomuniPertama();
                    $data->user_id = Auth::user()->id;
                    $data->user_id_penerima = $request->get("user_id_penerima");
                    $data->nama_lengkap = $request->get("nama_lengkap");
                    $data->tempat_lahir = $request->get("tempat_lahir");
                    $data->tanggal_lahir = $request->get("tanggal_lahir");
                    $data->orangtua_ayah = $request->get("orangtua_ayah");
                    $data->orangtua_ibu = $request->get("orangtua_ibu");
                    $data->lingkungan = $request->get("lingkungan");
                    $data->kbg = $request->get("kbg");
                    $data->telepon = $request->get("telepon");
                    $data->jadwal = $request->get("jadwal");
                    $data->lokasi = $request->get("lokasi");
                    $data->romo = $request->get("romo");
                    $data->status = "Diproses";
            
                    $file=$request->file('surat_baptis');
                    $imgFolder = 'file_sertifikat/surat_baptis';
                    $extension = $request->file('surat_baptis')->extension();
                    $imgFile=time()."_".$request->get('nama').".".$extension;
                    $file->move($imgFolder,$imgFile);
                    $data->surat_baptis=$imgFile;
                    
                    $data->save();
            
                    $riwayat = new Riwayat();
                    $riwayat->user_id = Auth::user()->id;
                    $riwayat->list_event_id = $request->event_id;
                    $riwayat->jenis_event =  $request->get("jenis_event");
                    $riwayat->event_id =  $data->id;
                    $riwayat->status =  "Diproses";
                    $riwayat->save();
            
                    return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Pertama Berhasil');
                }
                else
                {
                    return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error2', 'Pendaftaran Komuni Pertama Gagal. Pastikan Umur Sesuai Dengan Batas Ketentuan Komuni Pertama');
                }
            }
        }
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->where([['event_id', '=', $id], ['riwayats.jenis_event', 'like', 'Komuni Pertama']])
        ->get(['riwayats.*', 'list_events.keterangan_kursus as Ket']);
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftarankomuni.detail', compact("log"))->render()),200);
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=KomuniPertama::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftarankomuni.EditForm',compact("data"))->render()),200);
    }

    public function update(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->nama_lengkap = $request->get("nama_lengkap");
        $komuni->tempat_lahir = $request->get("tempat_lahir");
        $komuni->tanggal_lahir = $request->get("tanggal_lahir");
        $komuni->orangtua_ayah = $request->get("orangtua_ayah");
        $komuni->orangtua_ibu = $request->get("orangtua_ibu");
        $komuni->telepon = $request->get("telepon");

        $file=$request->file('surat_baptis');
        if(isset($file))
        {
            $imgFolder = 'file_sertifikat/surat_baptis';
            $extension = $request->file('surat_baptis')->extension();
            $imgFile=time()."_".$request->get('nama').".".$extension;
            $file->move($imgFolder,$imgFile);
            $komuni->surat_baptis=$imgFile;
        }

        $komuni->save();
        
        return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Komuni Pertama Berhasil Diubah');
    }

    public function Pembatalan(Request $request)
    {
        $data=KomuniPertama::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  $request->get("jenis_event");
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();

        return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Pertama Berhasil Dibatalkan');
    }

    public function sertifikat_komunipertama(Request $request)
    {
        // return $request->all();
        $komunipertama = KomuniPertama::where('user_id', $request->id)->first();
        // return $komunipertama;

        $pdf = PDF::loadView('pendaftarankomuni.sertifikat', compact('komunipertama'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('Sertifikat_KomuniPertama.pdf');
        
        
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
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function show(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function edit(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }
}
