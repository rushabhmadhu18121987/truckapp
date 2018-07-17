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
        $orders = 0;
        $completed_order = 0;
        $canceled_order = 0;
        return view('dashboard',compact('users','subscribers','vehicles','category','orders','completed_order','canceled_order'));
    }
}
