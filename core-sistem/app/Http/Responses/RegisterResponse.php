<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Spatie\Multitenancy\Models\Tenant;

class RegisterResponse implements RegisterResponseContract
{

    public function toResponse($request)
    {
        
        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade
        if (Tenant::checkCurrent() == false) {
            // return redirect()->route('auth.redirect.landlord');
            return redirect('/');
        } else if (Tenant::checkCurrent() == 'true') {
            return redirect()->route('auth.redirect', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) );
        }
        
    }
}