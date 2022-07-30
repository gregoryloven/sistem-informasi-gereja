<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Baptis;
use App\Models\User;
use App\Models\Paroki;

class BaptisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Baptis::all();
        $users = User::all();
        $wali_baptis_ayah = User::where([['role','umat'], ['role', 'ketua_lingkungan'], ['jenis_kelamin', 'Pria']])->get();
        $wali_baptis_ibu = User::where([['role','umat'], ['role', 'ketua_lingkungan'], ['jenis_kelamin', 'Wanita']])->get();
        $romo = User::where('role','romo')->get();
        $paroki = Paroki::all();
        return view('baptis.index',compact("data","users","wali_baptis_ayah","wali_baptis_ibu","romo","paroki"));
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
        $data = new Baptis();
        $data->user_id = $request->get('user_id');
        $data->wali_baptis_ayah = $request->get('wali_baptis_ayah');
        $data->wali_baptis_ibu = $request->get('wali_baptis_ibu');
        $data->id_romo = $request->get('id_romo');
        $data->paroki_id = $request->get('paroki_id');
        $data->jenis = $request->get('jenis');
        $data->jadwal = date('Y-m-d', strtotime(str_replace('/', '-',$request->input('jadwal'))));
        $data->status = $request->get('status');

        //File Sertifikat
        $file=$request->file('file_sertifikat');
        $imgFolder = 'file_sertifikat/baptis';
        $extension = $request->file('file_sertifikat')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $data->file_sertifikat=$imgFile;
        
        $data->save();

        return redirect()->route('baptiss.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Baptis Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function show(Baptis $baptis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function edit(Baptis $baptis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->user_id = $request->get('user_id');
        $baptis->wali_baptis_ayah = $request->get('wali_baptis_ayah');
        $baptis->wali_baptis_ibu = $request->get('wali_baptis_ibu');
        $baptis->id_romo = $request->get('id_romo');
        $baptis->paroki_id = $request->get('paroki_id');
        $baptis->jenis = $request->get('jenis');
        $baptis->jadwal = $request->get('jadwal');
        $baptis->status = $request->get('status');

        //File Sertifikat
        $file=$request->file('file_sertifikat');
        $imgFolder = 'file_sertifikat/baptis';
        $extension = $request->file('file_sertifikat')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $baptis->file_sertifikat=$imgFile;
        
        $baptis->save();

        return redirect()->route('baptiss.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Baptis Berhasil ditambahkan');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $baptis=Baptis::find($request->id);
        try
        {
            $baptis->delete();
            return redirect()->route('baptiss.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Baptis Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $baptis = "Gagal Menghapus Data Baptis";
            return redirect()->route('baptiss.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Baptis::find($id);
        $users=User::all();
        $wali_baptis_ayah = User::where([['role','umat'], ['role', 'ketua_lingkungan'], ['jenis_kelamin', 'Pria']])->get;
        $wali_baptis_ibu = User::where([['role','umat'], ['role', 'ketua_lingkungan'], ['jenis_kelamin', 'Wanita']])->get;
        $romo = User::where('role','romo')->get();
        $paroki=Paroki::all();
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('baptis.EditForm',compact("data","users","wali_baptis_ayah","wali_baptis_ibu","romo","paroki"))->render()),200);
    }

}
