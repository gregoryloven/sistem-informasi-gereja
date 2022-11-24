<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('id', Auth::user()->id)->first();

        if($data->role == "umat")
        {
            return view('password.umat',compact('data'));
        }
        else if($data->role == "ketua kbg")
        {
            return view('password.kbg',compact('data'));
        }
        else if($data->role == "ketua lingkungan")
        {
            return view('password.lingkungan',compact('data'));
        }
        else
        {
            return view('password.admin',compact('data'));
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = User::find(Auth::user()->id);

        if($data->role == "umat")
        {
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
                    return redirect()->back()->with('error', 'Password Baru Tidak Sama');
                }
            }
        }
        else if($data->role == "ketua kbg")
        {
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
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
