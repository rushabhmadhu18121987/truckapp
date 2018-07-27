<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use App\Jobs\SendVerificationEmail;
use App\Models\FavoriteList;
use App\Jobs\SendVerificationEmail;
use App\User;
use DB;
use Hash;
use Exception;
//use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;

class UserController extends Controller {
	private $user;

	public function __construct(User $user) {
		$this->user = $user;
	}

	public function test(Request $request){
		var_dump($request->all());
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create($data) {
		if($data->file('profile_image')){
			$image = $data->file('profile_image');
			$validFileExtentions = array('jpg','gif','png','JPG','GIF','PNG');
			if(!in_array($image->getClientOriginalExtension(), $validFileExtentions)){
				$responseData = array();
				$responseData['meta']['status'] = 'failure';
				$responseData['meta']['message'] = 'Invalid Profile Image. Allowed(.jpg, .png, .gif';
				$responseData['meta']['code'] = 500;
				$responseData['data'] = array();
				return response()->json($responseData);	
			}
			$fileName = 'Profile-' . date('Hsi') . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path() . '/uploads/profile/';
			$image->move($destinationPath, $fileName);
			chmod($destinationPath . "/" . $fileName, 0777);
			$data->profile_image = $fileName;
		}

		return User::create([
			'firstname' => $data->firstname,
			'lastname' => $data->lastname,
			'email' => $data->email,
			'password' => bcrypt($data->password),
			'remember_token' => base64_encode($data->email),
			'mobile' => $data->mobile,
			'profile_image' => $data->profile_image,
			'referral_code' => $data->referral_code,
			'is_subscribers' => $data->is_subscribers,
			'user_login_type' => $data->user_login_type,
			'status' => 1,
			'is_verify' => 0,
			'driving_licence_doc' => $data->driving_licence_doc,
			'created_at'=>date('Y-m-d H:i:s'),
		]);
	}
	/**
	 * Handle a registration request for the application.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request) {
		try{
			$validator = Validator::make($request->all(), [
				'firstname' => 'required|string|min:2|max:20',
				'lastname' => 'required|string|min:2|max:20',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6',
			]);
			// return count($validator->errors());
			$message = 'Error';
			$errors = $validator->errors()->getMessages();
			$obj = $validator->failed();
			$result = [];
			foreach ($obj as $input => $rules) {
				$i = 0;
				foreach ($rules as $rule => $ruleInfo) {
					$key = $rule;
					foreach ($ruleInfo as $tag) {
						$key .= '.' . $tag;
					}
					$key = $input . '[' . strtolower($key) . ']';
					$message = $errors[$input][$i];
					break;
				}
			}
			if ($validator->fails()) {
				$responseData = array();
				$responseData['meta']['status'] = 'failure';
				$responseData['meta']['message'] = $message;
				$responseData['meta']['code'] = 304;
				$responseData['data'] = array();
				return response()->json($responseData);
			}
			/* Upload Profile Pics */
			/*$image = $request->file('profile_image');
			$validFileExtentions = array('jpg','gif','png','JPG','GIF','PNG');
			if(!in_array($image->getClientOriginalExtension(), $validFileExtentions)){
				$responseData = array();
				$responseData['meta']['status'] = 'failure';
				$responseData['meta']['message'] = 'Invalid Profile Image. Allowed(.jpg, .png, .gif';
				$responseData['meta']['code'] = 500;
				$responseData['data'] = array();
				return response()->json($responseData);	
			}
			$fileName = 'Profile-' . date('Hsi') . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path() . '/uploads/profile/';
			$image->move($destinationPath, $fileName);
			chmod($destinationPath . "/" . $fileName, 0777);
			$request->profile_image = $fileName;*/
			/* Upload Profile Pics */
			// $request['ip'] = $request->ip();
			$user = $this->create($request);
			dispatch(new SendVerificationEmail($user));
			$responseData = array();
			$responseData['meta']['status'] = 'success';
			$responseData['meta']['message'] = 'User created successfully';
			$responseData['meta']['code'] = 200;
			$responseData['data'] = $user;
		}catch(Exception $e){
			$responseData = array();
			$responseData['meta']['status'] = 'success';
			$responseData['meta']['message'] = 'Catched Error:'.$e->getMessage().$e->getLine();
			$responseData['meta']['code'] = 400;
			$responseData['data'] = array();
		}
		return response()->json($responseData);
	}

	public function login(Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email',
			'password' => 'required|string',
		]);

		if ($validator->fails()) {
			$result = json_decode($validator->errors(), true);
			$message = '';
			foreach ($result as $value) {
				$message = implode(', ', $value);
				break;
			}
			$responseData = array();
			$responseData['meta']['status'] = 'failure';
			$responseData['meta']['message'] = $message;
			$responseData['meta']['code'] = 304;
			$responseData['data'] = array();
			return response()->json($responseData);
		}

		$credentials = $request->only('email', 'password');
		$token = null;
		try {
			if (!$token = JWTAuth::attempt($credentials)) {
				$responseData = array();
				$responseData['meta']['status'] = 'failure';
				$responseData['meta']['message'] = 'Invalid email or password. Please try again';
				$responseData['meta']['code'] = 304;
				$responseData['data'] = array();
				return response()->json($responseData);
			} else {
				$user = JWTAuth::toUser($token);
				$nuser = User::findOrFail($user->id);
				if ($request->has('lat')) {
					$nuser->lat = $request->get('lat');
				}
				if ($request->has('long')) {
					$nuser->long = $request->get('long');
				}
				/*if ($request->has('device_id')) {
					$nuser->device_id = $request->device_id;
				}
				if ($request->has('device_type')) {
					$nuser->device_type = $request->device_type;
				}*/
				$nuser->save();

				$nuser['token'] = $token;
				if ($user->is_verify != 1) {
					$message = 'please verify your email to access your account';
					$responseData = array();
					$responseData['meta']['status'] = 'failure';
					$responseData['meta']['message'] = $message;
					$responseData['meta']['code'] = 304;
					$responseData['data'] = array();
					return response()->json($responseData);
				} else {
					$responseData = array();
					$responseData['meta']['status'] = 'failure';
					$responseData['meta']['message'] = 'Logged in success';
					$responseData['meta']['code'] = 304;
					$responseData['data'] = $nuser;
					$responseData['meta']['profile_baseurl'] = url('/public/uploads/profile');
					return response()->json($responseData);
				}
			}
		} catch (JWTAuthException $e) {
			$responseData = array();
			$responseData['meta']['status'] = 'failure';
			$responseData['meta']['message'] = 'Failed to create token';
			$responseData['meta']['code'] = 500;
			$responseData['data'] = array();
			return response()->json($responseData);
		}
		return response()->json(compact('token'));
	}

	public function getAuthUser(Request $request) {

		try {
			$user = JWTAuth::toUser($request->token);

			if ($user->verified != 1) {
				return response()->json(['status' => 1, 'message' => 'please verify your email to access your account', 'result' => null]);
			} else {
				return response()->json(['status' => 0, 'message' => 'Logged in', 'result' => $user]);
			}
		} catch (Exception $e) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $e->getMessage()]);
		}
	}

	public function account_details(Request $request) {
		$validator = Validator::make($request->all(), [
			'mobile' => 'nullable|min:10|max:15|regex:/^[0-9+]+$/',
			'postal_code' => 'nullable|max:8|regex:/^[a-zA-Z0-9 ]+$/',
			'vehicle_number' => 'nullable|unique:users',
		]);

		if ($validator->fails()) {
			$result = json_decode($validator->errors(), true);
			$message = '';
			foreach ($result as $value) {
				$message = implode(', ', $value);
				break;
			}
			return response()->json(['status' => 1, 'message' => $message, 'result' => null]);
		}

		/*if ($validator->fails()) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $validator->errors()]);
		}*/

		try {
		    $country = DB::table('country')->where('id', $request->country)->select('phonecode')->first();
		    $mobile_code = "+".$country->phonecode.''.$request->mobile;
		    $existingUsers = DB::table('users')->where('mobile_code',$mobile_code)->get();
		    if(count($existingUsers)>0){
		        return response()->json(['status' => 1, 'message' => 'Mobile number already exist', 'result' => null]);    
		    }
			$user = User::findOrFail($request->id);
			$user->dob = $request->dob;
			$user->mobile = $request->mobile;
			$user->address_1 = $request->address_1;
			$user->address_2 = $request->address_2;
			$user->city = $request->city;
			$user->postal_code = $request->postal_code;
			$user->vehicle_number = $request->vehicle_number;
			$user->country = $request->country;
			$user->updated_by = $request->id;
			$user->mobile_code = $mobile_code;
			$user->save();

			return response()->json(['status' => 0, 'message' => 'Data submitted', 'result' => $user]);

		} catch (Exception $e) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $e->getMessage()]);
		}
	}

	public function profile_image(Request $request) {
		$validator = Validator::make($request->all(), [
			'profile_img' => 'image',
		]);

		if ($validator->fails()) {
			$result = json_decode($validator->errors(), true);
			$message = '';
			foreach ($result as $value) {
				$message = implode(', ', $value);
				break;
			}
			return response()->json(['status' => 1, 'message' => $message, 'result' => null]);
		}

		/*if ($validator->fails()) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $validator->errors()]);
		}*/

		try {
			$fileName = null;
			if ($request->profile_img != '') {
				$image = $request->file('profile_img');
				$fileName = 'Img-' . date('YmdHsi') . '.' . $image->getClientOriginalExtension();
				$destinationPath = public_path() . '/images/profile/';
				$image->move($destinationPath, $fileName);
				chmod($destinationPath . "/" . $fileName, 0777);
			}
			$user = User::findOrFail($request->id);
			$user->profile_img = $fileName;
			$user->save();

			if ($user->profile_img != null) {
				$user->profile_img = url('/') . '/images/profile/' . $user->profile_img;
			}

			return response()->json(['status' => 0, 'message' => 'Success', 'result' => $user]);

		} catch (Exception $e) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $e->getMessage()]);
		}
	}

	public function update_profile(Request $request) {
		$user = JWTAuth::toUser($request->token);
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|string|min:2|max:20',
			'last_name' => 'required|string|min:2|max:20',
			'gender' => 'required',
			'mobile' => 'nullable|min:10|max:15|regex:/^[0-9+]+$/',
			'postal_code' => 'nullable|max:8|regex:/^[a-zA-Z0-9 ]+$/',
			'profile_img' => 'image',
			'vehicle_number' => 'nullable|unique:users,vehicle_number,' . $user->id,
		]);

		if ($validator->fails()) {
			$result = json_decode($validator->errors(), true);
			$message = '';
			foreach ($result as $value) {
				$message = implode(', ', $value);
				break;
			}
			return response()->json(['status' => 1, 'message' => $message, 'result' => null]);
		}

		try {
		    $nuser = User::findOrFail($user->id);
		    //Get Country Code
            $countryData = DB::table('country')->where('id', $request->country)->select('phonecode')->first();
            $phoneWithCountry = '+'.$countryData->phonecode.''.$request->mobile;
            //Validate phone number with country code
			$countryDataUsers = DB::table('users')->where('mobile_code', $phoneWithCountry)->select('id')->where('id','!=',$user->id)->get();
			if(count($countryDataUsers)>0){
			    return response()->json(['status' => 1, 'message' => 'User already exist with same phone number and country code', 'result' => null]);    
			}
			$nuser->first_name = $request->first_name;
			$nuser->last_name = $request->last_name;
			$nuser->dob = $request->dob;
			$nuser->mobile = $request->mobile;
			$nuser->address_1 = $request->address_1;
			$nuser->address_2 = $request->address_2;
			$nuser->city = $request->city;
			$nuser->postal_code = $request->postal_code;
			$nuser->vehicle_number = $request->vehicle_number;
			$nuser->country = $request->country;
			$nuser->gender = $request->gender;
			$nuser->mobile_code = $phoneWithCountry;

			if ($request->has('profile_show_type')) {
				if ($request->get('profile_show_type') == 1) {
					//nickname
					if (strlen($nuser->unzeenu_nickname) == 0) {
						$nuser->unzeenu_nickname = strtolower($nuser->first_name . '_' . $nuser->lastname);
					}
					$nuser->show_name = $nuser->unzeenu_nickname;
					$nuser->profile_show_type = 1;
				} else {
					//first_name , lastname
					$nuser->show_name = $nuser->first_name . ' ' . $nuser->last_name;
					$nuser->profile_show_type = 0;
				}
			}

			if ($request->profile_img != "") {
				$image = $request->file('profile_img');
				$fileName = 'Img-' . date('YmdHsi') . '.' . $image->getClientOriginalExtension();
				$destinationPath = public_path() . '/images/profile/';
				$image->move($destinationPath, $fileName);
				chmod($destinationPath . "/" . $fileName, 0777);

				if ($nuser->profile_img != null && file_exists(public_path() . '/images/profile/' . $nuser->profile_img)) {
					unlink(public_path() . '/images/profile/' . $nuser->profile_img);
				}

				$nuser->profile_img = $fileName;
			}
			$nuser->updated_by = $user->id;
			$nuser->save();
			$nuser->token = $request->header('token');
			return response()->json(['status' => 0, 'message' => 'Profile Updated successfully', 'result' => $nuser]);

		} catch (Exception $e) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $e->getMessage()]);
		}
	}

	public function logout(Request $request) {

		try {
			echo $request->token;
			$user = JWTAuth::toUser($request->token);
			$user = User::findOrFail($user['id']);
			$user->device_id = '';
			$user->save();
			$user = JWTAuth::invalidate($request->token);

			return response()->json(['status' => 0, 'message' => 'Logged Out', 'result' => null]);
		} catch (Exception $e) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $e->getMessage()]);
		}
	}

	public function changePassword(Request $request) {

		$validator = Validator::make($request->all(), [
			'old_password' => 'required|min:6',
			'password' => 'required|string|min:6|confirmed',
		]);

		if ($validator->fails()) {
			$result = json_decode($validator->errors(), true);
			$message = '';
			foreach ($result as $value) {
				$message = implode(', ', $value);
				break;
			}
			return response()->json(['status' => 1, 'message' => $message, 'result' => null]);
		}

		/*if ($validator->fails()) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $validator->errors()]);
		}*/

		try {
			$user = JWTAuth::toUser($request->token);

			$user_id = $user->id;

			if (Hash::check($request->old_password, $user->password)) {
				User::where('id', $user_id)->update([
					'password' => bcrypt(str_replace(' ', '', $request->password)),
				]);

				return response()->json(['status' => 0, 'message' => 'Password changed successfully', 'result' => null]);
			} else {

				return response()->json(['status' => 1, 'message' => 'Please enter valid old password', 'result' => null]);
			}

		} catch (Exception $e) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $e->getMessage()]);
		}
	}

	public function forgotPassword(Request $request) {
		try {
			$validator = Validator::make($request->all(), [
				'email' => 'required|string|email',
			]);

			if ($validator->fails()) {
				$result = json_decode($validator->errors(), true);
				$message = '';
				foreach ($result as $value) {
					$message = implode(', ', $value);
					break;
				}
				return response()->json(['status' => 1, 'message' => $message, 'result' => null]);
			}

			/*if ($validator->fails()) {
				return response()->json(['status' => 1, 'message' => 'Email is required', 'result' => null]);
			}*/

			$user = User::where('email', $request->input('email'))->first();
			if (!empty($user)) {
				$response = Password::sendResetLink(["email" => $request->input('email')]);

				if (Password::RESET_LINK_SENT == $response) {
					return response()->json([
						'status' => '0',
						'message' => 'We have e-mailed your password reset link!',
						'result' => null,
					]);
				} else {
					return response()->json([
						'status' => '1',
						'message' => 'Opss..! Something went wrong,please try again.',
						'result' => null,
					]);
				}
			} else {
				return response()->json([
					'status' => '1',
					'message' => "We can't find this e-mail address.",
					'result' => null,
				]);
			}
		} catch (Exception $e) {
			return response()->json([
				'status' => '0',
				'message' => $e->getMessage(),
				'result' => null,
			]);
		}
	}

	public function delete_account(Request $request) {
		$validator = Validator::make($request->all(), [
			'curr_password' => 'required|min:6',
		]);

		if ($validator->fails()) {
			$result = json_decode($validator->errors(), true);
			$message = '';
			foreach ($result as $value) {
				$message = implode(', ', $value);
				break;
			}
			return response()->json(['status' => 1, 'message' => $message, 'result' => null]);
		}

		/*if ($validator->fails()) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $validator->errors()]);
		}*/
		try {
			$user = JWTAuth::toUser($request->token);
			$user_id = $user->id;
			if (Hash::check($request->curr_password, $user->password)) {
				$user_id = $user_id;

				$messages = DB::table('messages')->where('created_by', $user_id)->get();
				if (isset($messages) && count($messages)) {
					foreach ($messages as $message) {
						$msgid = $message->id;

						if ($message->images != null) {
							$image_arr = explode(",", $message->images);
							if (isset($image_arr) && count($image_arr)) {
								foreach ($image_arr as $image) {
									if (file_exists(public_path() . '/images/media/images/' . $image)) {
										unlink(public_path() . '/images/media/images/' . $image);
									}
								}
							}
						}

						if ($message->videos != null) {
							$video_arr = explode(",", $message->videos);
							if (isset($video_arr) && count($video_arr)) {
								foreach ($video_arr as $video) {
									if (file_exists(public_path() . '/images/media/video/' . $video)) {
										unlink(public_path() . '/images/media/video/' . $video);
									}
								}
							}
						}

						$favorite = FavoriteList::select('*')->get();
						foreach ($favorite as $key) {
							if ($key->msg_id != '') {
								$MsgList = explode(',', $key->msg_id);
								if (in_array($msgid, $MsgList)) {
									$update_fav = FavoriteList::find($key->id);
									$findex = array_search($msgid, $MsgList);
									unset($MsgList[$findex]);
									$update_fav->msg_id = implode(',', $MsgList);
									$update_fav->save();
								}

							}
						}

						$deletemsg = DB::table('messages')->where('id', $msgid)->delete();
					}
				}

				$community = DB::table('community')->where('user_id', $user_id)->delete();
				$favorite = DB::table('favorite_list')->where('user_id', $user_id)->delete();
				$IgnoreList = DB::table('ignore_list')->where('sender_id', $user_id)->orWhere('user_id', $user_id)->delete();
				$business = DB::table('business')->where('user_id', $user_id)->get();
				if (isset($business) && count($business)) {
					foreach ($business as $busi) {
						if ($busi->logo != null && file_exists(public_path() . '/images/business/' . $busi->logo)) {
							unlink(public_path() . '/images/business/' . $busi->logo);
						}

						if ($busi->id_proof != null && file_exists(public_path() . '/images/business/' . $busi->id_proof)) {
							unlink(public_path() . '/images/business/' . $busi->id_proof);
						}

						if ($busi->address_proof != null && file_exists(public_path() . '/images/business/' . $busi->address_proof)) {
							unlink(public_path() . '/images/business/' . $busi->address_proof);
						}

						if ($busi->business_images != null) {
							$busi_img_arr = explode(",", $busi->business_images);
							if (isset($busi_img_arr) && count($busi_img_arr)) {
								foreach ($busi_img_arr as $busi_img) {
									if (file_exists(public_path() . '/images/business/media/' . $busi_img)) {
										unlink(public_path() . '/images/business/media/' . $busi_img);
									}
								}
							}
						}
					}
				}
				$business = DB::table('business')->where('user_id', $user_id)->delete();

				$adverts = DB::table('adverts')->where('user_id', $user_id)->get();
				if (isset($adverts) && count($adverts)) {
					foreach ($adverts as $advert) {
						$advtid = $advert->id;
						if ($advert->advert_type == 1) {
							if ($advert->advert_content != null && file_exists(public_path() . '/images/adverts/' . $advert->advert_content)) {
								unlink(public_path() . '/images/adverts/' . $advert->advert_content);
							}
						}
						$advt = DB::table('adverts')->where('id', $advtid)->delete();
					}

				}

				$user = DB::table('users')->where('id', $user_id)->delete();

				return response()->json(['status' => 0, 'message' => 'User deleted successfully', 'result' => null]);
			} else {
				return response()->json(['status' => 1, 'message' => 'Please enter your current password', 'result' => null]);
			}
		} catch (Exception $e) {
			return response()->json(['status' => 1, 'message' => 'Error', 'result' => $e->getMessage()]);
		}
	}

}