<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    public function __construct() {
        
    }

    /**
     * Admin dashboard
     *
     */
    public function index() {
        $users = \App\Models\User::count();
        return view('admin/dashboard', compact('users'));
    }

}
