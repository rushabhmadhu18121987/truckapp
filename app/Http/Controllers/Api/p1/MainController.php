<?php
namespace App\Http\Controllers\Api\p1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class MainController extends Controller
{
    // Common api
    public function login(Request $request) {
    	$returnData = array();
    	return response()->json($returnData);
    }


    //v1 API
	public function getprofile(Request $request) {
    	$returnData = array();
    	return response()->json($returnData);
    }


}
