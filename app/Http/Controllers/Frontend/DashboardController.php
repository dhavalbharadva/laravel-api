<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{

    protected $auth;

    public function __construct()
    {
        $this->auth = auth()->guard('user');
    }

    public function index()
    {
        $user_id  = $this->auth->user()->id;
        $orders = Order::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return view('frontend.dashboard', compact('orders'));
    }
}
