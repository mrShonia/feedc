<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $request;

    function __construct( Request $request )
    {
        $this->request = $request;
    }

    /**
     * Register User
     * @return void
     */

    public function register()
    {

        if (User::where('username', $this->request->input('username'))->count() == 0) {

            User::insert([
                'username' => $this->request->input('username'),
                'password' => Hash::make($this->request->input('password'))
            ]);
            return responder()->success(['message' => 'User created'])->respond();
        }

        return responder()->error(400, 'User already exists')->respond(400);
    }

    
}