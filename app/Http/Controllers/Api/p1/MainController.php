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
    public function get_vehicles(Request $request) {
        try{
            $token = $request->header('token');
            $user = JWTAuth::toUser($token);
            if($request->has('category_id')){
                $category_id = $request->get('category_id');
                $vehicles = DB::table('vehicles')->where('type',$category_id)->select('*')->get();
                $responseData = array();
                $responseData['meta']['status'] = 'success';
                $responseData['meta']['message'] = 'vehicles retrived successfully';
                $responseData['meta']['code'] = 200;
                $responseData['data'] = $vehicles;
                return response()->json($responseData);
            }else{
                $responseData = array();
                $responseData['meta']['status'] = 'failure';
                $responseData['meta']['message'] = 'category_id required.';
                $responseData['meta']['code'] = 304;
                $responseData['data'] = array('status'=>"failure");
                return response()->json($responseData);
            }
        }catch(Exception $e){
                $responseData = array();
                $responseData['meta']['status'] = 'failure';
                $responseData['meta']['message'] = $e->getMessage();
                $responseData['meta']['code'] = 304;
                $responseData['data'] = array('status'=>"failure");
                return response()->json($responseData);
        }
    }

	public function getprofile(Request $request) {
        try{
        	$token = $request->header('token');
            $user = JWTAuth::toUser($token);
            $responseData = array();
            $responseData['meta']['status'] = 'success';
            $responseData['meta']['message'] = 'User profile successfully';
            $responseData['meta']['code'] = 200;
            $responseData['data'] = $user;
            return response()->json($responseData);
        }catch (JWTAuthException $e) {
            $responseData = array();
            $responseData['meta']['status'] = 'failure';
            $responseData['meta']['message'] = 'Token Error';
            $responseData['meta']['code'] = 500;
            $responseData['data'] = array('status'=>'failure');
            return response()->json($responseData);
        }
        catch(Exception $e){
            $responseData = array();
            $responseData['meta']['status'] = 'failure';
            $responseData['meta']['message'] = 'Catched Error:'.$e->getMessage();
            $responseData['meta']['code'] = 400;
            $responseData['data'] = array();
        }
    }

    public function get_categories(Request $request) {

        try{
            $token = $request->header('token');
            $category = DB::table('category')->get();
            $responseData = array();
            $responseData['meta']['status'] = 'success';
            $responseData['meta']['message'] = 'Categories retrived successfully';
            $responseData['meta']['code'] = 200;
            $responseData['data'] = $category;
            return response()->json($responseData);
        }catch (JWTAuthException $e) {
            $responseData = array();
            $responseData['meta']['status'] = 'failure';
            $responseData['meta']['message'] = 'Token Error';
            $responseData['meta']['code'] = 500;
            $responseData['data'] = array("status"=>"failure");
            return response()->json($responseData);
        }
        catch(Exception $e){
            $responseData = array();
            $responseData['meta']['status'] = 'failure';
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
        $responseData['meta']['message'] = 'Token refresh successfully';
        $responseData['meta']['code'] = 200;
        $responseData['data'] = $user;
        return response()->json($responseData);
    }


}
