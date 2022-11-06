<?php

namespace App\Http\Controllers;
use App\User;
use App\Valuation;
use App\State;
use App\Area;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use ZipArchive;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->authorize('isSuper');
        $users = User::orderBy('id','desc')->get();
		$comp_filter_id = 'all';
		$company = Valuation::orderBy('name')->pluck('name', 'id')->toArray();
        return view('User.index',compact('users', 'company', 'comp_filter_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($role_id = null)
    {
		if(empty($role_id) || $role_id > 5 || $role_id < 1) {
			return redirect()->route('users.index')->with('error','Invalid position found!.');
		}
		$roles = array('1' => 'Super Admin', '2' => 'Web Admin (P)','3' => 'Company Admin (P)','4' => 'Mobile Executive (A)','5' => 'Company Executive (P)');
		$role_pages = array('1' => 'super_admin/all', '2' => 'web_admin/all','3' => 'mobile_admin/all','4' => 'mobile_executive/all','5' => 'company_user/all');
		$role_list_page = $role_pages[$role_id];
		$role = $roles[$role_id];
		$roles = array($role_id => $role);
        $this->authorize('isSuper');
        $company = Valuation::where('status', '=', 'active')->orderBy('name')->pluck('name', 'id');
        $state = State::pluck('name', 'id');
        return view('User.create',compact('company','state', 'roles', 'role', 'role_list_page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(Request $request)
    { 
        $this->authorize('isSuper');
		$messages = [
			'pass1.required' => 'The password field is required.',
			'employee_id.required' => 'The reference number field is required.',
		];
		$validateArr = [];
        $validateArr = [
            'role' => 'required',
            'name' => 'required|string|max:255',
            'pass1' => 'required|string',
            'username'=>'required|string|unique:users',
            'mobile_number'=>'required',
            'state'=>'required',
            'area_id'=>'required'
        ];
		
        if($request->role==1||$request->role==2||$request->role==3||$request->role==4){
			$validateArr['employee_id'] = 'required';
        }
        if($request->email) {
			$validateArr['email'] = 'required|string|email|max:255|unique:users';			
        }
        if($request->role==3||$request->role==4||$request->role==5) {
			$validateArr['comp_id'] = 'required';
        }
		$request->validate($validateArr, $messages); 
        $input=$request->all();
        if($request->role==4){
            $input['status']='requested';
        }else{
			$input['status'] ='active'; 
		}
		$newUser = User::create(['is_deleted' => 0]);
		$optimizePath = config('global.employees_main_folder').$newUser->id.'/';
		if(!file_exists(public_path().$optimizePath)) {
			mkdir(public_path().$optimizePath, 0777, true);
		}
        if($file = $request->file('icard')) {
			$input['icard'] = uploadDocs($file, $optimizePath);
		}
        if($file = $request->file('govt_issue_id')) {        
            $input['govt_issue_id'] = uploadDocs($file, $optimizePath);
        }   
        if($file = $request->file('back_govt_card')) {        
            $input['back_govt_card'] = uploadDocs($file, $optimizePath);
        }
        $input['pass1'] =$request->pass1;
        $input['password'] = Hash::make($request->pass1);
        $data = $newUser->update($input);
        //$data->save();
        if($request->role==1){
            $role='super_admin';
        }elseif($request->role==2){
			$role='web_admin';
        }elseif($request->role==3){
            $role='mobile_admin';
        }elseif($request->role==4){
            $role='mobile_executive';
        }elseif($request->role==5){
            $role='company_user';
        }else{
            return redirect()->route('users.index')->with('added','User Created Successfully.');
        };
        return redirect()->route('userfill',$role)->with('added','User Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $role)
    {   //prd($_GET);
        $status='';
        if($role=='super_admin'){
            $role=1;    
        }elseif($role=='web_admin'){
            $role=2;
        }elseif($role=='mobile_admin'){
            $role=3;
        }elseif($role=='mobile_executive'){
            $role=4;
        }elseif($role=='company_user'){
            $role=5;
        }elseif($role=='active'){
            $status='active';
        }elseif($role=='inactive'){
            $status='inactive';
        }elseif($role=='pending'){
            $status='pending';
        }elseif($role=='requested'){
            $status='requested';
        }
        if($status){
          $users=User::where('status','=',$status)->latest(); 
        }elseif($role=='all'){
           $users = User::orderBy('id','desc');
        }    
        else{
           $users = User::where('role','=',$role)->orderBy('id','desc');
        } 
		$comp_filter_id = 'all';
		if($request->has('comp_id') && $request->filled('comp_id')) {
			$users->where('comp_id','=',$request->comp_id);
			$comp_filter_id = $request->comp_id;
		}
		$users = $users->get();
		$company = Valuation::orderBy('name')->pluck('name', 'id')->toArray();
        return view('User.index',compact('users', 'company','comp_filter_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('isSuper');
        $users = User::select('users.*','areas.state_id as state')->leftJoin('areas','users.area_id','=','areas.id')->where('users.id','=',$user->id)->first();
        $company = Valuation::orderBy('name')->pluck('name', 'id');
        $state = State::pluck('name', 'id');
        $areas = Area::where('state_id','=',$users->state)->pluck('name', 'id');
		$roles = array('1' => 'Super Admin', '2' => 'Web Admin (P)','3' => 'Company Admin (P)','4' => 'Mobile Executive (A)','5' => 'Company Executive (P)');
		$role_pages = array('1' => 'super_admin/all', '2' => 'web_admin/all','3' => 'mobile_admin/all','4' => 'mobile_executive/all','5' => 'company_user/all');
		$role_list_page = $role_pages[$user->role];
		$role = $roles[$user->role];
		$roles = array($user->role => $role);
        return view('User.edit',compact('users','company','state','areas', 'roles', 'role', 'role_list_page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('isSuper');
		$messages = [
			'pass1.required' => 'The password field is required.',
			'employee_id.required' => 'The reference number field is required.',
		];
		$validateArr = [];
        $validateArr = [
           'role' => 'required',
            'name' => 'required|string|max:255',
            'pass1' => 'required|string',
            'username'=>'required|string|unique:users,username,'.$user->id,
            'mobile_number'=>'required',
            'state'=>'required',
            'area_id'=>'required'
        ];
        if($request->role==1||$request->role==2||$request->role==3||$request->role==4) {
			$validateArr['employee_id'] = 'required';
        }
        if($request->email){
			$validateArr['email'] = 'required|string|email|max:255|unique:users,email,'.$user->id; 
        }
        if($request->role==3||$request->role==4||$request->role==5) {
			$validateArr['area_id'] = 'required';			
			$validateArr['comp_id'] = 'required';			
        }
		$request->validate($validateArr, $messages);
        $input=$request->all();
		//$data = User::findOrFail($id);
		if($request->role != 4) {
			$optimizePath = config('global.employees_main_folder').$id.'/';
			if(!file_exists(public_path().$optimizePath)) {
				mkdir(public_path().$optimizePath, 0777, true);
			}
			if($file = $request->file('icard')) {
				$input['icard'] = uploadDocs($file, $optimizePath, $user->icard);
			}
			if($file = $request->file('govt_issue_id')) {        
				$input['govt_issue_id'] = uploadDocs($file, $optimizePath, $user->govt_issue_id);
			}   
			if($file = $request->file('back_govt_card')) {        
				$input['back_govt_card'] = uploadDocs($file, $optimizePath, $user->back_govt_card);
			}
		} else {
			unset($input['address']);
			unset($input['email']);
			unset($input['device_id']);
			if(!empty($input['reset_kyc']) && $input['reset_kyc'] == 'yes') {
				$input['address'] = '';
				$input['email'] = '';
				$input['device_id'] = '';
				$input['icard'] = '';
				$input['govt_issue_id'] = '';
				$input['back_govt_card'] = '';
				$input['status'] = 'requested';
				$this->removeUserImages($user);
			}
		}
        $input['pass1'] =$request->pass1;
        $input['password'] = Hash::make($request->pass1);
        $user->update($input);
         if($request->role==1){
            $role='super_admin';
        }elseif($request->role==2){
			$role='web_admin';
        }elseif($request->role==3){
            $role='mobile_admin';
        }elseif($request->role==4){
            $role='mobile_executive';
        }elseif($request->role==5){
            $role='company_user';
        }else{
            return redirect()->route('users.index')->with('updated','User Updated Successfully.');
        };
		if(!empty($input['reset_kyc']) && $input['reset_kyc'] == 'yes') {
			return redirect()->route('users.edit',$user->id)->with('updated','User KYC reset Successfully.');
		} else {
			return redirect()->route('userfill',$role)->with('updated','User Updated Successfully.');
		}
    }
	
	
	public function removeUserImages($data = null) {
		if(!empty($data->icard) && file_exists(public_path().$data->icard)) {
			unlink(public_path().$data->icard);
		}
		if(!empty($data->govt_issue_id) && file_exists(public_path().$data->govt_issue_id)) {
			unlink(public_path().$data->govt_issue_id);
		}
		if(!empty($data->back_govt_card) && file_exists(public_path().$data->back_govt_card)) {
			unlink(public_path().$data->back_govt_card);
		}
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('isSuper');
         $user->delete();
         return back()->with('deleted', 'User has been deleted');
    }
    public function users(Request $request, $role, $status=null)
    {
        if($role=='super_admin'){
              $this->authorize('isSuper');
            $role=1;    
        }elseif($role=='web_admin'){
              $this->authorize('isSuper');
            $role=2;
        }elseif($role=='mobile_admin'){
              $this->authorize('isSuper');
            $role=3;
        }elseif($role=='mobile_executive'){
            $role=4;
        }elseif($role=='company_user'){
              $this->authorize('isSuper');
            $role=5;
        }
        $users = User::where('role','=',$role);
        if($status!='all'){
           $users=$users->where('status','=',$status)->orderBy('id','desc');
        }else{
           $users=$users->orderBy('id','desc');
        }
		$comp_filter_id = 'all';
		if($request->has('comp_id') && $request->filled('comp_id')) {
			$users->where('comp_id','=',$request->comp_id);
			$comp_filter_id = $request->comp_id;
		}
		$users = $users->get();
        $company = Valuation::orderBy('name')->pluck('name', 'id')->toArray();
        return view('User.index',compact('users', 'company', 'comp_filter_id'));
    }
    public function changereferno(Request $request){
        $request->validate([
            'id' => 'required|exists:users,id',
            'ref_start' => 'required',
        ]);
        $data = User::findOrFail($request->id);
        $data=$data->update($request->all());
        $arr = array('status' => false,'action'=>'Submited','msg' => 'Somthing Went Wrong');
        if($data){
            $arr = array('status' => true,'action'=>'Submited','msg' => 'Notification  No has been Shared');
        }
        return Response()->json($arr);
    }
	public function changerolereferno(Request $request){
        $request->validate([
            'role' => 'required|exists:users,role'
        ]);
        $arr = array('status' => false,'action'=>'Submited','msg' => 'Somthing Went Wrong');
        if(User::where('role', $request->role)->update(['ref_start'=>1])){
            $arr = array('status' => true,'action'=>'Submited','msg' => 'reset successfully');
        }
        return Response()->json($arr);
    }
	
	public function multicheck_action(Request $request){
        $request->validate([
            'action' => 'required',
			'multicheck' => 'required'
        ]);
		$arr = array('status' => false,'action'=>'Submited','msg' => 'Somthing Went Wrong');
		if(in_array($request->action, ['active', 'inactive', 'delete'])) {
			if($request->action == 'delete') {
				foreach($request->multicheck as $key => $user_id) {
					$user = User::findOrFail($user_id);
					remove_user_docs($user);
					if($user->delete()) {
						$arr = array('status' => true,'action'=>'Submited','msg' => 'User(s) deleted successfully');
					}
				}
			} else {
				$updateIds = $request->multicheck;
				$users = User::whereIn('id', $updateIds)->pluck('status', 'id');
				foreach($users as $user_id => $status) {
					if($status == 'requested') {
						if (($key = array_search($user_id, $updateIds)) !== false) {
							unset($updateIds[$key]);
						}
					}
				}
				if(User::whereIn('id', $updateIds)->update(['status'=>$request->action])){
					$arr = array('status' => true,'action'=>'Submited','msg' => 'User(s) status changed successfully');
				}
			}
		}
        return Response()->json($arr);
    }
	
    public function documents(Request $request){
        if($request->ajax()){
            $data = User::select('icard','govt_issue_id','back_govt_card')->whereId($request->user_id)->first();
            return $data;
        }
    }
	
    public function profile(request $request){
        if($request->isMethod('post')){
            $id=Auth()->user()->id;
            $request->validate([
            'name' => 'required|string',
            /*'employee_id' => 'required',
            'ref_start' => 'required|numeric',
            'username'=>'required|string|unique:users,username,'.$id,
            'mobile_number'=>'required',*/
            ]);
            $input=$request->all();
            $data = User::findOrFail($id);
            $data->update($input);
            return back()->with('updated','Users Updated Successfully.');
        }
        return view('User.profile');
    }
	
    public function changepassword(request $request){
        if($request->isMethod('post')){
            if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
                return back()->with('deleted','Current password does not match'); 
        }
        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            return back()->with('deleted','New Password cannot be same as your current password'); 
            
        }
        $validatedData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6',
        ]);
        $user = Auth::user();
        $user->pass1=$request->get('new_password');
        $user->password = Hash::make($request->get('new_password'));
        $user->save();
            return back()->with('updated','Password Change Successfully.');
        }
        return view('User.changepassword');
    }
	
    public function image(Request $request){
         if($request->ajax()){
            $request->validate([
               'profile_pic' => 'required',
            ]); 
            if($file=$request->file('profile_pic')){
                $optimizeImage = Image::make($file);
                $optimizePath = public_path().'/images/users/';
                $name = time().$file->getClientOriginalName();
                $optimizeImage->save($optimizePath.$name,50);
                $input['photo']=$name;
            }else{
                $input['photo']='img_avatar.png';
            }
            $data = User::findOrFail(Auth()->user()->id);
            $data=$data->update($input);
            $arr = array('status' => false,'action'=>'update','msg' => 'Somthing Went Wrong');
            if($data){
                $arr = array('status' => true,'action'=>'update','msg' => 'Image Update Successfully');
            }
            return Response()->json($arr);
        }     
    }
	
    public function change_status(Request $request){
        if($request->ajax()){
            $user = User::findOrFail($request->id);
			$input = [];
			if($request->status == 'requested') {
				$input['address'] = '';
				$input['email'] = '';
				$input['device_id'] = '';
				$input['icard'] = '';
				$input['govt_issue_id'] = '';
				$input['back_govt_card'] = '';
				$this->removeUserImages($user);
			}
			$input['status'] = $request->status;
            if($user->update($input)){
                $arr = array('status' => true,'action'=>'update','msg' => 'Status Change Successfully');
            }
            return Response()->json($arr);
        }
    }
	
	
	public function make_users_zip($id){
		$data = User::findOrFail($id);
		if(!empty($data['icard']) || !empty($data['govt_issue_id']) || !empty($data['back_govt_card'])) {
			$filename = $data->name.'_'.$data->id.'.zip';
			$zip = new ZipArchive();
			$tmp_file = public_path("tmp/").$filename;
			if(file_exists($tmp_file)){
				\File::delete(public_path('tmp/'.$filename)); 
			}
			$zip->open($tmp_file, ZipArchive::CREATE);
			if(!empty($data['icard'])){
				 if(file_exists(public_path().$data['icard'])){
					$download_file = file_get_contents(public_path().$data['icard']);
					$zip->addFromString(basename($data['icard']),$download_file);
				}
			}
			if(!empty($data['govt_issue_id'])){
				 if(file_exists(public_path().$data['govt_issue_id'])){
					$download_file = file_get_contents(public_path().$data['govt_issue_id']);
					$zip->addFromString(basename($data['govt_issue_id']),$download_file);
				}
			}
			if(!empty($data['back_govt_card'])){
				 if(file_exists(public_path().$data['back_govt_card'])){
					$download_file = file_get_contents(public_path().$data['back_govt_card']);
					$zip->addFromString(basename($data['back_govt_card']),$download_file);
				}
			}
			$zip->close();
			if(file_exists($tmp_file)){
				return response()->download(public_path('tmp/'.$filename));
			}
			return back()->with('deleted', 'Somthing went wrong');  
		}  
        return back()->with('deleted', 'Docs Not Found');       
    }
}
