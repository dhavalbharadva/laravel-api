<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller {
    
    public function __construct() {
        $this->middleware('guest.user', ['except' => 'doLogout']);
    }

    /**
     * Display a login page
     * @return Response
     */
    public function getLogin() {
        return view('frontend.login');
    }

    /**
     * Check login with email and password.
     * @return redirect to member area or error_message if login fails
     */
    public function doLogin(Request $request) {
        $input = $request->all();
        $credentials = array(
            'email' => $input['email'],
            'password' => $input['password']
        );
        if(auth()->guard('user')->attempt($credentials)){
            return redirect('/dashboard');
        }else{
            // authentication failure! lets go back to the login page
            return redirect()->back()->with('error_message', 'Invalid email or password!');
        }
    }

    public function doLogout() {
        auth()->guard('user')->logout();
        session()->flush();
        session()->regenerate();
        return redirect('/login');
    }

}
