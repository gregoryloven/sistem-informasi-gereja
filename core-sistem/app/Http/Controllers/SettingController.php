<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $setting = Setting::all();

            return view('setting.index',compact('setting'));
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

    public function store(Request $request)
    {
        $data = new Setting();
        if($request->jenis_sakramen == 'Baptis')
        {
            $data->umur_baptis = $request->get('umur_baptis_bayi');
            if($request->get('akta_kelahiran') == true)
            {
                $data->akta_kelahiran = 1;
            }
            if($request->get('kartu_keluarga') == true)
            {
                $data->kartu_keluarga = 1;
            }
        }
        else
        {
            $data->umur_komuni = $request->get('umur_komuni');
        }
        
        return redirect()->route('setting.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Buat Ketentuan Administrasi Penerimaan Sakramen Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Setting::find($id);
        return response()->json(array(
            'status'=>'oke',
            'data' => $data,
            'msg'=>view('setting.EditForm',compact("data"))->render()),200);
    }

    public function update(Request $request)
    {
        $data=Setting::find($request->id);
        $data->umur_baptis = $request->get('umur_baptis_bayi');

        if($request->get('akta_kelahiran') == true)
        {
            $data->akta_kelahiran = 1;
        }
        else
        {
            $data->akta_kelahiran = null;
        }
        if($request->get('kartu_keluarga') == true)
        {
            $data->kartu_keluarga = 1;
        }
        else
        {
            $data->kartu_keluarga = null;
        }
        $data->save();

        return redirect()->route('setting.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Ubah Ketentuan Administrasi Baptis Berhasil');
    }

    public function EditFormKomuni(Request $request)
    {
        $id=$request->get("id");
        $data=Setting::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('setting.EditFormKomuni',compact("data"))->render()),200);
    }

    public function updatekomuni(Request $request)
    {
        $data=Setting::find($request->id);
        $data->umur_komuni = $request->get('umur_komuni');
        $data->save();

        return redirect()->route('setting.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Ubah Ketentuan Administrasi Komuni Pertama Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
