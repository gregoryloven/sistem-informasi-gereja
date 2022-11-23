<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListEvent;
use Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role != 'umat')
        {
            return back();
        }
        else
        {
            return view('dashboarduser.index');
        }
    }

    public function FormPendaftaran(Request $request)
    {
        $id=$request->get("id");
        $data=ListEvent::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranbaptis.index',compact('data'))->render()),200);
    }
}
