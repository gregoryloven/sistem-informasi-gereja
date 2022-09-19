<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Spatie\Multitenancy\Models\Tenant;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        
        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        if (Tenant::checkCurrent() == false) {
            if(Auth::user()->role == 'superadmin') {
                return redirect('/');
            } else if (Auth::user()->role == 'pihak-gereja') {
                return redirect('/');
            }
        } else if (Tenant::checkCurrent() == 'true') {
            $user = Auth::user()->role;
            if($user == 'admin')
            {
                return redirect('/sbadmin2');
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
}