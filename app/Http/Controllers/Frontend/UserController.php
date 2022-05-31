<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User as User;
use Auth;
use Hash;
use Validator;

class UserController extends Controller {

    protected $auth;

    public function __construct() {
        $this->middleware('auth.user', ['except' => ['create', 'store']]);
        $this->auth = auth()->guard('user');
    }

    /**
     *
     * @return Response
     */
    public function index() {}

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create() {
        return view('frontend.register');
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        );
        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create($data);
        $user->password = \Hash::make($data['password']);
        $user->save();

        return redirect()->route('frontend.login')->with('success_message', "Your account created successfully!");
    }

    
}
