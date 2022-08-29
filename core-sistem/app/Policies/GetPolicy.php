<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Auth;

class GetPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function agama()
    {
        $user = Auth::user()->agama;
        return($user == 'Katolik'
            ? Response::allow()
            : Response::deny('You cant come here')
        );
    }

    public function lingkungan()
    {
        $user = Auth::user()->lingkungan_id;
        $user2 = Auth::user()->kbg_id;
        return($user != null && $user2 != null 
            ? Response::allow()
            : Response::deny('Silahkan Daftar Lingkungan dan KBG Terlebih Dahulu')
        );
    }

}
