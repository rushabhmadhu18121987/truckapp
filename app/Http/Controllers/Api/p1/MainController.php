<?php
namespace App\Http\Controllers\Api\p1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use JWTAuth;
use Mail;
use Validator;
use Exception;

class MainController extends Controller
{

    //v1 API
	public function getprofile(Request $request) {
        try{
        	$token = JWTAuth::refresh($request->header('token'));
            $user = JWTAuth::toUser($token);
            $responseData = array();
            $responseData['meta']['status'] = 'success';
            $responseData['meta']['message'] = 'User created successfully';
            $responseData['meta']['code'] = 200;
            $responseData['data'] = $user;
            return response()->json($responseData);
        }catch (JWTAuthException $e) {
            $responseData = array();
            $responseData['meta']['status'] = 'failure';
            $responseData['meta']['message'] = 'Token Error';
            $responseData['meta']['code'] = 500;
            $responseData['data'] = array();
            return response()->json($responseData);
        }
        catch(Exception $e){
            $responseData = array();
            $responseData['meta']['status'] = 'success';
            $responseData['meta']['message'] = 'Catched Error:'.$e->getMessage();
            $responseData['meta']['code'] = 400;
            $responseData['data'] = array();
        }
    }

    public function get_categories(Request $request) {

        try{
            $token = JWTAuth::refresh($request->header('token'));
            $category = DB::table('category')->get();
            $responseData = array();
            $responseData['meta']['status'] = 'success';
            $responseData['meta']['message'] = 'User created successfully';
            $responseData['meta']['code'] = 200;
            $responseData['data'] = $category;
            return response()->json($responseData);
        }catch (JWTAuthException $e) {
            $responseData = array();
            $responseData['meta']['status'] = 'failure';
            $responseData['meta']['message'] = 'Token Error';
            $responseData['meta']['code'] = 500;
            $responseData['data'] = array();
            return response()->json($responseData);
        }
        catch(Exception $e){
            $responseData = array();
            $responseData['meta']['status'] = 'success';
            $responseData['meta']['message'] = 'Catched Error:'.$e->getMessage();
            $responseData['meta']['code'] = 400;
            $responseData['data'] = array();
        }
    }

    public function refresh_token(Request $request) {
        $token = JWTAuth::refresh($request->header('token'));
        $user = JWTAuth::toUser($token);
        $responseData = array();
        $responseData['meta']['status'] = 'success';
        $responseData['meta']['message'] = 'User created successfully';
        $responseData['meta']['code'] = 200;
        $responseData['data'] = $user;
        return response()->json($responseData);
    }


}
