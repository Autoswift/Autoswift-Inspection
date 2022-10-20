<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
            $user = Auth::user();
			if((!empty($user->device_id) && $user->device_id != $request->device_id) || empty($request->device_id)) {
				return $this->sendError('Unauthorised.', ['error'=>'Device not matched.']);
			}
			
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            $success['id'] =  $user->id;
            $success['employee_id'] =  $user->employee_id;
            $success['is_user'] =  $user->role;
            $success['comp_id'] =  $user->comp_id;
            if($user->role==1){
             $success['position']="SuperAdmin";
            }elseif ($user->role==3) {
             $success['position']="MobileAdmin";
            }elseif ($user->role==4){
             $success['position']="MobileExecutive";
            }elseif ($user->role==2){
             $success['position']="WebAdmin";
            };
            if($user->status == 'active' ){
                $success['user_status']=1; //
            }
            if($user->status == 'inactive' ){
                $success['user_status']=0;
            }
            if($user->status == 'requested' ){
               $success['user_status']=3;
               
            }
            if($user->status == 'pending' ){
               $success['user_status']=2;
            }
            if($user->status == 'rejected' ){
                $success['user_status']=4;
            }
			
			$success['profile_status'] = 'completed';
			if(empty($user->device_id) || $user->status == 'rejected' || $user->status == 'requested') {
				$success['profile_status'] = 'pending';
			}
			
            $input['app_version']=$request->app_version;
            $input['mobile_model']=$request->mobile_model;
            $input['device_id']=$request->device_id;
            $input['firebase_id']=$request->firebase_id;
            $data = User::findOrFail($user->id);
            $data->update($input);
           /* Auth::user()->tokens->each(function($token, $key) {
                $token->delete();
            });*/
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}