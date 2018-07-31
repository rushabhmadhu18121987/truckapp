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
use App\Vehicle;

class MainController extends Controller
{
    public function get_vehicles(Request $request) {
        try{
            $token = $request->header('token');
            $user = JWTAuth::toUser($token);
            if($request->has('category_id')){
                $category_id = $request->get('category_id');
                $vehicles = Vehicle::where('type',$category_id)->select('*')->get();
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

    public function add_vehicles(Request $request) {
        try{
            $token = $request->header('token');
            $user = JWTAuth::toUser($token);

            $vehicle = new Vehicle();
            $vehicle->user_id = $request['user_id'];
            $vehicle->title = $request['title'];
            $vehicle->category_type = $request['category_type'];
            $vehicle->make = $request['make'];
            $vehicle->model = $request['model'];
            $vehicle->color = $request['color'];

            $files = $request->file('photo');

            $fileName = 'Vehicle-' . date('Hsi') . '.' . $files->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/vehicles/';
            $files->move($destinationPath, $fileName);
            chmod($destinationPath . "/" . $fileName, 0777);
            $profile_image = $fileName;
            $vehicle->photo = $profile_image;
            /*$vehicle_images = array();
            if (isset($files) && $files != null && count($files)) {
                $i = 1;
                foreach ($files as $file) {
                    $fileName = 'Img-' . $i . date('YmdHsi') . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path() . '/uploads/vehicles/';
                    $file->move($destinationPath, $fileName);
                    $vehicle_images[] = $fileName;
                    $i++;
                }
                $vehicle->photo = implode(',', $vehicle_images);
            }*/

            $vehicle->vehicle_condition = $request['vehicle_condition'];

            $vehicle->hours_price   = $request['hours_price'];
            $vehicle->daily_price = $request['daily_price'];
            $vehicle->weekly_price = $request['weekly_price'];
            $vehicle->mothly_price = $request['mothly_price'];
            $vehicle->status = $request['status'];
            $vehicle->save();

            $responseData = array();
            $responseData['meta']['status'] = 'success';
            $responseData['meta']['message'] = 'vehicles saved successfully';
            $responseData['meta']['code'] = 200;
            $responseData['data'] = $vehicle;
            return response()->json($responseData);
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
