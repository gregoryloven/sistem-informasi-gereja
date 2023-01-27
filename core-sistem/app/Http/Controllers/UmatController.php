<?php

namespace App\Http\Controllers;

use App\Models\Umat;
use App\Models\Lingkungan;
use App\Models\Kbg;
use Illuminate\Http\Request;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UmatLingkunganImport;
use App\Imports\UmatKbgImport;

class UmatController extends Controller
{
    public function umatAll()
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = Umat::where('status', 'Disetujui Lingkungan')
            ->orderby('lingkungan_id', 'ASC')
            ->orderby('no_kk', 'ASC')
            ->get();

            return view('umat.umat',compact('data'));
        }
    }
    
    
    public function umatKbg()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->id;
            $kbg2 = Auth::user()->kbg->nama_kbg;

            $ling = Lingkungan::all();
            $data = Umat::where([['kbg_id', $kbg], ['status', 'Disetujui Lingkungan']])
            ->get();
    
            return view('umat.umatkbg',compact('data','ling','kbg2'));
        }
    }

    public function fetchkbgumat(Request $request)
    {
        $kbg = Kbg::where('lingkungan_id', $request->id)->get();

        // $output = '<option value="">Choose</option>';
        $output = "";
        foreach($kbg as $o) {
            $output .= '<option value="'.$o->id.'">'.$o->nama_kbg.'</option>';
        }
        echo $output;
    }

    public function TambahUmatKBG(Request $request)
    {
        $data = new Umat();
        $data->user_id = Auth::user()->id;
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->hubungan = $request->get("hubungan_darah");
        $data->jenis_kelamin = $request->get("jenis_kelamin");
        $data->lingkungan_id = $request->get("lingkungan_id");
        $data->kbg_id = $request->get("kbg_id");
        $data->alamat = $request->get("alamat");
        $data->telepon = $request->get("telepon");
        $data->status = "Disetujui KBG";
        $data->save();

        return redirect('/umatKbg')->with('status', 'Pendaftaran Umat Berhasil');
    }


    public function EditFormUmatKBG(Request $request)
    {
        $id=$request->get("id");
        $data=Umat::find($id);
        $kbg=Kbg::all();
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('umat.EditFormUmatKBG',compact('data','kbg'))->render()),200);
    }

    public function EditFormUmatLingkungan(Request $request)
    {
        $id=$request->get("id");
        $data=Umat::find($id);
        $kbg=Kbg::all();
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('umat.EditFormUmatKBG',compact('data','kbg'))->render()),200);
    }

    public function UbahUmatKBG(Request $request)
    {
        $data=Umat::find($request->id);
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->hubungan = $request->get("hubungan_darah");
        $data->jenis_kelamin = $request->get("jenis_kelamin");
        $data->kbg_id = $request->get("kbg_id");
        $data->alamat = $request->get("alamat");
        $data->telepon = $request->get("telepon");
        $data->save();

        return redirect('/umatKbg')->with('status', 'Ubah Data Umat Berhasil');
    }

    public function umatLingkungan()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $lingkungan = Auth::user()->lingkungan->id;
            $lingkungan2 = Auth::user()->lingkungan->nama_lingkungan;

            $ling = Lingkungan::all();
            $kbg = Kbg::all();
            $data = Umat::where([['lingkungan_id', $lingkungan], ['status', 'Import']])
            ->orderby('no_kk', 'ASC')
            ->get();
    
            return view('umat.umatlingkungan',compact('data','ling','kbg','lingkungan2'));
        }
    }

        public function TambahUmatLingkungan(Request $request)
    {
        $data = new Umat();
        $data->user_id = Auth::user()->id;
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->hubungan = $request->get("hubungan_darah");
        $data->no_kk = $request->get("no_kk");
        $data->tempat_lahir = $request->get("tempat_lahir");
        $data->tanggal_lahir = $request->get("tanggal_lahir");
        $data->jenis_kelamin = $request->get("jenis_kelamin");
        $data->lingkungan_id = $request->get("lingkungan_id");
        $data->kbg_id = $request->get("kbg_id");
        $data->alamat = $request->get("alamat");
        $data->telepon = $request->get("telepon");
        $data->no_kk = $request->get("no_kk");
        $data->status = "Import";
        $data->save();

        return redirect('/umatLingkungan')->with('status', 'Pendaftaran Umat Berhasil');
    }

    public function DownloadExcelLingkungan(Request $request)
    {
        return response()->download(public_path('template/lingkungan.xlsx'));
    }

    public function DownloadExcelKbg(Request $request)
    {
        return response()->download(public_path('template/kbg.xlsx'));
    }

    public function ImportUmatLingkungan(Request $request)
    {
        // return $request->excellingkungan;
        try {
            Excel::import(new UmatLingkunganImport, $request->file('excellingkungan'), \Maatwebsite\Excel\Excel::XLSX);
            return back()->with('status', 'Data Umat Berhasil ditambah.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi Kesalahan. Mohon Ikuti Format Excel yang telah disediakan Dan Periksa Kembali Penamaan Kbg atau Lingkungan.');
        }
        
    }

    public function ImportUmatKbg(Request $request)
    {
        // return $->excelrequestkbg;
        try {
            Excel::import(new UmatKbgImport, $request->file('excelkbg'), \Maatwebsite\Excel\Excel::XLSX);
        return back()->with('status', 'Data Umat Berhasil ditambah.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi Kesalahan. Mohon Ikuti Format Excel yang telah disediakan Dan Periksa Kembali Penamaan Kbg atau Lingkungan.');
        }
        
    }

    public function delete(Request $request)
    {
        $data=Umat::find($request->id);
        $data->delete();

        return redirect('/umatLingkungan')->with('status', 'Hapus Data Umat Berhasil');
    }
}
