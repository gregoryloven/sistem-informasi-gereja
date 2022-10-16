<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    public function data()
    {
        $data = User::where('id', Auth::user()->id)->first();

        if($data->role == "umat")
        {
            return view('profile.profileumat',compact('data'));
        }
        else if($data->role == "ketua kbg")
        {
            return view('profile.profilekbg',compact('data'));
        }
        else if($data->role == "ketua lingkungan")
        {
            return view('profile.profilelingkungan',compact('data'));
        }
        else
        {
            return view('profile.index',compact('data'));
        }
        
    }

    public function update(Request $request)
    {
        $data = User::where('id', Auth::user()->id)->first();
        dd($data);

        if($data->role == "umat")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->tempat_lahir = $request->get("tempat_lahir");
            $data->tanggal_lahir = $request->get("tanggal_lahir");
            $data->agama = $request->get("agama");
            $data->jenis_kelamin = $request->get("jenis_kelamin");
            $data->telepon = $request->get("telepon");
            $data->save();

            return redirect()->route('profile.profileumat', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Akun Berhasil Diubah');
        }
        else if($data->role == "ketua kbg")
        {
            return view('profile.profilekbg',compact('data'));
        }
        else if($data->role == "ketua lingkungan")
        {
            return view('profile.profilelingkungan',compact('data'));
        }
        else
        {
            return view('profile.index',compact('data'));
        }

    }

}


