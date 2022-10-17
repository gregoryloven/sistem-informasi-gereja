<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

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
        // return $request->all();
        $data = User::find(Auth::user()->id);
        // return $data;
        if($data->role == "umat")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->tempat_lahir = $request->get("tempat_lahir");
            $data->tanggal_lahir = $request->get("tanggal_lahir");
            $data->agama = $request->get("agama");
            $data->jenis_kelamin = $request->get("jenis_kelamin");
            $data->telepon = $request->get("telepon");
            $data->save();

            if($request->get("oldPassword") != null && $request->get("newPassword") != null && $request->get("newPassword2") != null)
            {
                if($request->get("newPassword") == $request->get("newPassword2")) {
                    if (Hash::check($request->get("oldPassword"), $data->password)) {
                        $data->password = bcrypt($request->get("newPassword"));
                        $data->save();
                        return redirect()->back()->with('status', 'Password Berhasil Diubah');
                    } else {
                        return redirect()->back()->with('error', 'Password Lama Salah');
                    }
                } else {
                    return redirect()->back()->with('error', 'Password Tidak Sama');
                }
            }
            return redirect()->back()->with('status', 'Data Akun Berhasil Diubah');
        }
        else if($data->role == "ketua kbg")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->telepon = $request->get("telepon");
            $data->save();

            if($request->get("oldPassword") != null && $request->get("newPassword") != null && $request->get("newPassword2") != null)
            {
                if($request->get("newPassword") == $request->get("newPassword2")) {
                    if (Hash::check($request->get("oldPassword"), $data->password)) {
                        $data->password = bcrypt($request->get("newPassword"));
                        $data->save();
                        return redirect()->back()->with('status', 'Password Berhasil Diubah');
                    } else {
                        return redirect()->back()->with('error', 'Password Lama Salah');
                    }
                } else {
                    return redirect()->back()->with('error', 'Password Tidak Sama');
                }
            }
            return redirect()->back()->with('status', 'Data Akun Berhasil Diubah');
        }
        else if($data->role == "ketua lingkungan")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->telepon = $request->get("telepon");
            $data->save();

            if($request->get("oldPassword") != null && $request->get("newPassword") != null && $request->get("newPassword2") != null)
            {
                if($request->get("newPassword") == $request->get("newPassword2")) {
                    if (Hash::check($request->get("oldPassword"), $data->password)) {
                        $data->password = bcrypt($request->get("newPassword"));
                        $data->save();
                        return redirect()->back()->with('status', 'Password Berhasil Diubah');
                    } else {
                        return redirect()->back()->with('error', 'Password Lama Salah');
                    }
                } else {
                    return redirect()->back()->with('error', 'Password Tidak Sama');
                }
            }
            return redirect()->back()->with('status', 'Data Akun Berhasil Diubah');
        }
        else
        {
            return view('profile.index',compact('data'));
        }

    }

}


