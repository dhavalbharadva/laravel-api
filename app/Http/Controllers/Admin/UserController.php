<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User as User;
use App\Helpers\Datatable\SSP;
use App\Helpers\Common;
use Validator;
use Illuminate\Support\Str;

class UserController extends Controller {

    /**
     * User Model
     * @var User
     */
    protected $user;
    protected $pageLimit;

    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
        $this->pageLimit = config('settings.pageLimit');
    }

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index() {

        // Grab all the users
        $users = User::paginate($this->pageLimit);

        // Show the user
        return view('admin/usersList', compact('users'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create() {
        return view('admin.users');
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
        $messages = array(
            'email.unique' => 'User already exist please enter different email.'
        );
        $data = $request->all();

        //dd($data);

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create($data);
        $user->password = \Hash::make($data['password']);
        $user->save();

        return redirect()->route('admin.users.index')->with('success_message', 'User created successfully!');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $user = User::find($id);
        if ($user) {
            return view('admin/users', compact('user'));
        } else {
            return redirect(ADMIN_SLUG.'/users')->with('error_message', 'Invalid user id');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {

        $rules = array(
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id
        );

        $messages = array(
            'email.unique' => 'User already exist please enter different email.'
        );

        $user = User::findOrFail($id);

        $data = $request->all();

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($data['password'] && $data['password_confirmation']) {
            
            $rules = array(
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6'
            );
            
            $validator = Validator::make($data, $rules);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $data['password'] = \Hash::make($data['password']);
            
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success_message', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        User::destroy($id);

        $array = array();
        $array['success'] = true;
        $array['message'] = 'User deleted successfully!';
        echo json_encode($array);
    }

    public function changeUserStatus(Request $request) {
        $data = $request->all();

        $user = User::find($data['id']);
        if ($user->status) {
            $user->status = '0';
        } else {
            $user->status = '1';
        }
        $user->save();

        $array = array();
        $array['success'] = true;
        $array['message'] = 'Status changed successfully!';
        echo json_encode($array);
    }

    public function getUsersData() {

        /*
         * DataTables example server-side processing script.
         *
         * Please note that this script is intentionally extremely simply to show how
         * server-side processing can be implemented, and probably shouldn't be used as
         * the basis for a large complex system. It is suitable for simple use cases as
         * for learning.
         *
         * See http://datatables.net/usage/server-side for full details on the server-
         * side processing requirements of DataTables.
         *
         * @license MIT - http://datatables.net/license_mit
         */

        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */

        // DB table to use
        $table = 'users';

        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array('db' => 'name', 'dt' => 0, 'field' => 'name'),
            array('db' => 'email', 'dt' => 1, 'field' => 'email'),
            array('db' => 'status', 'dt' => 2, 'formatter' => function( $d, $row ) {
                    if ($row['status']) {
                        return '<a href="javascript:;" class="btn btn-success status-btn" id="' . $row['id'] . '"><i class="fa fa-lightbulb-o"></i></a>';
                    } else {
                        return '<a href="javascript:;" class="btn btn-danger status-btn" id="' . $row['id'] . '"><i class="fa fa-lightbulb-o"></i></a>';
                    }
                }, 'field' => 'status'),
            array('db' => 'id', 'dt' => 3, 'formatter' => function( $d, $row ) {
                    $operation = '<a href="users/' . $d . '/edit" class="btn btn-primary" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>&nbsp;';
                    $operation .= '<a href="javascript:;" id="' . $d . '" class="btn btn-danger delete-btn" title="Delete" data-toggle="tooltip"><i class="fa fa-times"></i></a>';
                    return $operation;
                }, 'field' => 'id')
        );

        // SQL server connection information
        $sql_details = array(
            'user' => config('database.connections.mysql.username'),
            'pass' => config('database.connections.mysql.password'),
            'db' => config('database.connections.mysql.database'),
            'host' => config('database.connections.mysql.host')
        );

        $joinQuery = NULL;
        $extraWhere = "";
        $groupBy = "";

        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
        );
    }

}
