<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class LoginController extends ApiController {
    
    
    public function __construct() {}

    public function login(Request $request) {
        $input = $request->all();
        $credentials = array(
            'email' => $input['email'],
            'password' => $input['password']
        );
        
        if(auth()->guard()->attempt($credentials)){
            $credentials = array(
                'email' => $input['email'],
                'password' => $input['password'],
                'status' => '1'
            );
            if(auth()->guard()->attempt($credentials)){
                $user = auth()->guard()->user();
                $user->token =  $user->createToken('MyApp')->accessToken;
                
                return $this->respondWithSuccess("Login successfull!",$user);
                
            }else{
                auth()->guard()->logout();
                session()->flush();
                session()->regenerate();
                // authentication failure! lets go back to the login page
                return $this->respondWithError("Your account is blocked!");
            }
        }else{
            // authentication failure! lets go back to the login page
            return $this->respondWithError(trans("Invalid credentails"));
        }
    }

    public function logout() {
        //auth()->guard('api')->user()->token()->revoke();
        auth()->guard('api')->user()->token()->delete();
        auth()->guard('user')->logout();
        session()->flush();
        session()->regenerate();
        return $this->respondWithSuccess("Logout Successfull!");
    }

}
