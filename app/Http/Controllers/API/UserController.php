<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Validator;


class UserController extends ApiController {

    protected $auth;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['store']]);
        $this->auth = auth()->guard('api');
    }

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index() {        
        $profile = User::find($this->auth->user()->id);
        if ($profile) {
            return $this->respondWithData($profile);
        } else {
            return $this->respondNotFound();
        }
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
            return $this->respondValidationError(array('errors' => $validator->errors()->all()));
        }

        $user = User::create($data);
        $user->password = \Hash::make($data['password']);
        $user->save();

        return $this->respondWithSuccess("Your account created successfully!",$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request) {
        $data = $request->all();
        $id = $data['id'];
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$data['id'],
        );

        $user = User::findOrFail($data['id']);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $this->respondValidationError(array('errors' => $validator->errors()->all()));
        }
        
        $user->update($data);
        
        return $this->respondWithSuccess("Profile updated successfully!",$user);
    }

}
