<?php

namespace App\Http\Controllers;

use App\Models\ListEvent;
use App\Models\Baptis;
use App\Models\User;
use App\Models\Umat;
use App\Models\Riwayat;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;

class PendaftaranBaptisController extends Controller
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
            $data = ListEvent::where([['jenis_event', 'like', 'Baptis B%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
            $baptis = Baptis::where([['user_id', Auth::user()->id], ['jenis', 'like', 'Baptis B%']])->get();
            $user = User::all();
            return view('pendaftaranbaptis.index',compact("data", "baptis", "user"));
        }
    }

    public function IndexDewasa()
    {
        if(Auth::user()->role != 'umat')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where([['jenis_event', 'like', 'Baptis D%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
            $baptis = Baptis::where([['user_id', Auth::user()->id], ['jenis', 'like', 'Baptis D%']])->get();
            $user = User::all();
            return view('pendaftaranbaptis.indexDewasa',compact("data", "baptis", "user"));
        }
    }

    public function OpenForm(Request $request)
    {
        if(Auth::user()->status !== "Tervalidasi"){
            return redirect()->back()->with('error', 'Anda Belum Terdaftar Sebagai Umat Pada Lingkungan & Kbg Yang ada. Silahkan Daftar Halaman Pendaftaran Umat');
        } else {
            $id = $request->id;
            $list = DB::table('list_events')->where('id', $id)->get();

            $user = Umat::join('users', 'umats.user_id', '=', 'users.id')
            ->where('user_id', Auth::user()->id)->get(['umats.*', 'users.id as userid']);

            return view('pendaftaranbaptis.InputForm',compact("list", "user"));
        }
    }

    public function FetchIdentitas(Request $request)
    {
        $data=$request->get("id");
        $user = Umat::where('id', $data)->get();
        return response()->json($user);
    }

    public function OpenFormDewasa(Request $request)
    {
        if(Auth::user()->status !== "Tervalidasi"){
            return redirect()->back()->with('error', 'Anda Belum Terdaftar Sebagai Umat Pada Lingkungan & Kbg Yang ada. Silahkan Daftar Halaman Pendaftaran Umat');
        } else {
            $id = $request->id;
            $list = DB::table('list_events')->where('id', $id)->get();
            
            $user = Umat::join('users', 'umats.user_id', '=', 'users.id')
            ->where('user_id', Auth::user()->id)->get(['umats.*', 'users.id as userid']);

            return view('pendaftaranbaptis.InputForm',compact("list", "user"));
        }
    }

    public function InputForm(Request $request)
    {
        $cek = Umat::where('id', $request->user_id_penerima)->first();
        $setting = Setting::first();

        $date = new DateTime($request->get("tanggal_lahir"));
        $now = new DateTime();
        $a = $now->diff($date);
        $umur = (int)$a->y;

        if($request->jenis == "Baptis Bayi")
        {
            if($cek->status_baptis == 'Sudah Baptis')
            {
                return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error2', 'Pendaftaran Baptis Bayi Gagal. Identitas Yang Diinputkan Telah Menerima Baptis');
            }
            else
            {
                if($umur < $setting->umur_baptis)
                {
                    $data = new Baptis();
                    $data->user_id = Auth::user()->id;
                    $data->user_id_penerima = $request->get("user_id_penerima");
                    $data->nama_lengkap = $request->get("nama_lengkap");
                    $data->tempat_lahir = $request->get("tempat_lahir");
                    $data->tanggal_lahir = $request->get("tanggal_lahir");            
                    $data->orangtua_ayah = $request->get("orangtua_ayah");
                    $data->orangtua_ibu = $request->get("orangtua_ibu");
                    $data->wali_baptis_ayah = $request->get("wali_baptis_ayah");
                    $data->wali_baptis_ibu = $request->get("wali_baptis_ibu");
                    $data->lingkungan = $request->get("lingkungan");
                    $data->kbg = $request->get("kbg");
                    $data->telepon = $request->get("telepon");
                    $data->jenis = $request->get("jenis");
                    $data->jadwal = $request->get("jadwal");
                    $data->lokasi = $request->get("lokasi");
                    $data->romo = $request->get("romo");
                    $data->status = "Diproses";
                    $data->save();

                    $riwayat = new Riwayat();
                    $riwayat->user_id = Auth::user()->id;
                    $riwayat->list_event_id = $request->list_event_id;
                    $riwayat->jenis_event =  $data->jenis;
                    $riwayat->event_id =  $data->id;
                    $riwayat->status =  "Diproses";
                    $riwayat->save();

                    return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Bayi Berhasil');
                }
                else
                {
                    return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error2', 'Pendaftaran Baptis Bayi Gagal. Pastikan Umur Sesuai Dengan Batas Ketentuan Baptis Bayi & Anak');
                }
            }
        }
        else
        {
            if($cek->status_baptis == 'Sudah Baptis')
            {
                return redirect()->route('pendaftaranbaptis.indexDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error2', 'Pendaftaran Baptis Dewasa Gagal. Identitas Yang Diinputkan Telah Menerima Baptis');
            }
            else
            {
                if($umur > $setting->umur_baptis)
                {
                    $data = new Baptis();
                    $data->user_id = Auth::user()->id;
                    $data->user_id_penerima = $request->get("user_id_penerima");
                    $data->nama_lengkap = $request->get("nama_lengkap");
                    $data->tempat_lahir = $request->get("tempat_lahir");
                    $data->tanggal_lahir = $request->get("tanggal_lahir");
                    $data->orangtua_ayah = $request->get("orangtua_ayah");
                    $data->orangtua_ibu = $request->get("orangtua_ibu");
                    $data->wali_baptis_ayah = $request->get("wali_baptis_ayah");
                    $data->wali_baptis_ibu = $request->get("wali_baptis_ibu");
                    $data->lingkungan = $request->get("lingkungan");
                    $data->kbg = $request->get("kbg");
                    $data->telepon = $request->get("telepon");
                    $data->jenis = $request->get("jenis");
                    $data->jadwal = $request->get("jadwal");
                    $data->lokasi = $request->get("lokasi");
                    $data->romo = $request->get("romo");
                    $data->status = "Diproses";

                    $file=$request->file('surat_pernyataan');
                    $imgFolder = 'file_sertifikat/surat_pernyataan';
                    $extension = $request->file('surat_pernyataan')->extension();
                    $imgFile=time()."_".$request->get('nama').".".$extension;
                    $file->move($imgFolder,$imgFile);
                    $data->surat_pernyataan=$imgFile;

                    $data->save();

                    $riwayat = new Riwayat();
                    $riwayat->user_id = Auth::user()->id;
                    $riwayat->list_event_id = $request->list_event_id;
                    $riwayat->jenis_event =  $data->jenis;
                    $riwayat->event_id =  $data->id;
                    $riwayat->status =  "Diproses";
                    $riwayat->save();

                    return redirect()->route('pendaftaranbaptis.indexDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Dewasa Berhasil');
                }
                else
                {
                    return redirect()->route('pendaftaranbaptis.indexDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error2', 'Pendaftaran Baptis Dewasa Gagal. Pastikan Umur Sesuai Dengan Batas Ketentuan Baptis Dewasa');
                }     
            }
        }
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Baptis Bayi']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranbaptis.detail', compact("log"))->render()),200);
    }

    public function detailDewasa(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Baptis Dewasa']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranbaptis.detail', compact("log"))->render()),200);
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Baptis::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranbaptis.EditForm',compact("data"))->render()),200);
    }

    public function update(Request $request)
    {
        $baptis=Baptis::find($request->id);

        if($baptis->jenis == 'Baptis Bayi')
        {
            $baptis->nama_lengkap = $request->get("nama_lengkap");
            $baptis->tempat_lahir = $request->get("tempat_lahir");
            $baptis->tanggal_lahir = $request->get("tanggal_lahir");
            $baptis->orangtua_ayah = $request->get("orangtua_ayah");
            $baptis->orangtua_ibu = $request->get("orangtua_ibu");
            $baptis->wali_baptis_ayah = $request->get("wali_baptis_ayah");
            $baptis->wali_baptis_ibu = $request->get("wali_baptis_ibu");
            $baptis->telepon = $request->get("telepon");
            $baptis->save();

            return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Bayi Berhasil Diubah');
        }
        else
        {
            $baptis->nama_lengkap = $request->get("nama_lengkap");
            $baptis->tempat_lahir = $request->get("tempat_lahir");
            $baptis->tanggal_lahir = $request->get("tanggal_lahir");
            $baptis->orangtua_ayah = $request->get("orangtua_ayah");
            $baptis->orangtua_ibu = $request->get("orangtua_ibu");
            $baptis->wali_baptis_ayah = $request->get("wali_baptis_ayah");
            $baptis->wali_baptis_ibu = $request->get("wali_baptis_ibu");
            $baptis->telepon = $request->get("telepon");

            $file=$request->file('surat_pernyataan');
            if(isset($file))
            {
                $imgFolder = 'file_sertifikat/surat_pernyataan';
                $extension = $request->file('surat_pernyataan')->extension();
                $imgFile=time()."_".$request->get('nama').".".$extension;
                $file->move($imgFolder,$imgFile);
                $baptis->surat_pernyataan=$imgFile;
            }

            $baptis->save();
            
            return redirect()->route('pendaftaranbaptis.indexDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Dewasa Berhasil Ubah');
        }

    }

    public function Pembatalan(Request $request)
    {
        $data=Baptis::find($request->id);
        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();
        
        if($data->jenis == "Baptis Bayi")
        {
            $data->status = "Dibatalkan";
            $data->save();

            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $data->id;
            $riwayat->jenis_event =  $data->jenis;
            $riwayat->status =  "Dibatalkan";
            $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
            $riwayat->save();

            return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Bayi Telah Dibatalkan');
        }
        else
        {
            $data->status = "Dibatalkan";
            $data->save();

            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id =  $list_event->id;
            $riwayat->event_id =  $data->id;
            $riwayat->jenis_event =  $data->jenis;
            $riwayat->status =  "Dibatalkan";
            $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
            $riwayat->save();

            return redirect()->route('pendaftaranbaptis.indexDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Dewasa Telah Dibatalkan');
        }
    }

    public function sertifikat_baptisbayi(Request $request)
    {
        // return $request->all();
        $baptis = Baptis::where('user_id', $request->id)->where('jenis', $request->jenis)->first();
        // return $baptis;

        $pdf = PDF::loadView('pendaftaranbaptis.sertifikatbayi', compact('baptis'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('Sertifikat_baptis.pdf');
    }

    public function sertifikat_baptisdewasa(Request $request)
    {
        // return $request->all();
        $baptis = Baptis::where('user_id', $request->id)->where('jenis', $request->jenis)->first();
        // return $baptis;

        $pdf = PDF::loadView('pendaftaranbaptis.sertifikatdewasa', compact('baptis'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('Sertifikat_baptis.pdf');
    }
}
