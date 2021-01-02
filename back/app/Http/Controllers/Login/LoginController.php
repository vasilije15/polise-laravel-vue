<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:20',
            'username' => 'required| min:4',
            'password' => 'required|min:10| confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);


    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user == null) {

//            return response("Username or password is invalid", 422);

            abort(422, 'Username or password is invalid');
        }

        if (!Hash::check($request->password, $user->password)){
            abort(422, 'Username or password is invalid');
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ["token"=>$token, "expires_in" => 86400000, "name" => $user->name];

        return response($response,200);



    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been successfully logged out!';
        return response($response, 200);
    }

}
