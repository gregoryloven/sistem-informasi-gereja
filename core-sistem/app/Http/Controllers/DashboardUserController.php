<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListEvent;

class DashboardUserController extends Controller
{
    public function index()
    {
        // $data = ListEvent::all();
        // return view('dashboarduser.index',compact("data"));
        return view('dashboarduser.index');
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
