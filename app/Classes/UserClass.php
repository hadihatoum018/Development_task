<?php

namespace App\Classes;

use App\Helper\Common;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserClass
{
    private $userManager;
    public function __construct(User $user)
    {
        $this->userManager = $user;
    }


}
