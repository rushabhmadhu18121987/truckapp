<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	$users = User::count();
        $subscribers = User::where('is_subscribers','1')->count();
        $vehicles = DB::table('vehicles')->count();
        $category = DB::table('category')->count();
        $orders = DB::table('orders')->count();
        $completed_order = DB::table('orders')->count();
        $canceled_order = DB::table('orders')->where('status','2')->count();
	    $promocodes = DB::table('promocodes')->where('status','1')->count();
        return view('dashboard',compact('users','subscribers','vehicles','promocodes','category','orders','completed_order','canceled_order'));
    }
}
