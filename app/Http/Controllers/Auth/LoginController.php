<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function verify()
    {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $user = User::loginVerify($username, $password);
        if ($user != false){
            $apiToken = Str::random('105');
            $user->token = $apiToken;
            $user->save();
            return $this->successResponse(['user'=> $user]);
        }
        return $this->failResponse([], 401);
    }

}
