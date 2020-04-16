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

    /**
     * Register User
     * @return user token
     */


    public function login()
    {

        $this->validate($this->request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $this->request->input('username'))->first();

        if ($user != NULL && Hash::check($this->request->input('password'), $user->password)) {

            $token = Hash::make(md5($user . microtime().env('TOKEN_SALT')));

            User::where('username', $this->request->input('username'))->update([
                'token' => $token
            ]);

            return responder()->success(['token' => $token])->respond();
        }

        return responder()->error(401, 'Invalid credentials')->respond(401);
    }

    public function logOut()
    {

        User::where('token', $this->request->header('token'))->update([
            'token' => null
        ]);

        return responder()->success(['message' => 'successfully logged out'])->respond();

    }
}