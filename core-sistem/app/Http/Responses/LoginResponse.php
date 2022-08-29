<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        
        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        $user = Auth::user()->role;
        if($user == 'admin')
        {
            return redirect('/sbadmin');
        }
        elseif($user == 'ketua kbg')
        {
            return redirect('/sbkbg');
        }
        elseif($user == 'ketua lingkungan')
        {
            return redirect('/sbkl');
        }
        elseif($user == 'umat')
        {
            return redirect('/dashboarduser');
        }
    }
}