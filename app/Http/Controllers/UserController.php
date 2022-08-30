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
        return view('User.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isSuper');
        $company = Valuation::orderBy('position')->pluck('name', 'id');
        $state = State::pluck('name', 'id');
        return view('User.create',compact('company','state'));
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
        $request->validate([
            'role' => 'required',
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'username'=>'required|string|unique:users',
            'mobile_number'=>'required',
        ]);
        if($request->role==1||$request->role==2||$request->role==3||$request->role==4){
           $request->validate([
            'employee_id' => 'required',
            ]); 
        }
        if($request->email){
           $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            ]); 
        }
        if($request->role==3||$request->role==4||$request->role==5){
           $request->validate([
            'area_id' => 'required',
            'comp_id' => 'required',
            ]); 
        }
        $input=$request->all();
        if($request->role==3||$request->role==4){
            $input['status']='requested';
        }else{
			$input['status'] ='active'; 
		}
        if($file = $request->file('icard')) {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/document/';
            $name = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['icard'] = $name;
        }
        if($file = $request->file('govt_issue_id')) {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/document/';
            $name = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['govt_issue_id'] = $name;
        }   
        if($file = $request->file('back_govt_card')) {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/document/';
            $name = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['back_govt_card'] = $name;
        }  
        $input['pass1'] =$request->password;
        $input['password'] = Hash::make($request->password);
        $data = User::create($input);
        $data->save();
        if($request->role==2){
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
    public function show($role)
    {   
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
          $users=User::where('status','=',$status)->latest()->get(); 
        }elseif($role=='all'){
           $users = User::orderBy('id','desc')->get();
        }    
        else{
           $users = User::where('role','=',$role)->orderBy('id','desc')->get();
        } 
        return view('User.index',compact('users'));
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
        $company = Valuation::orderBy('position')->pluck('name', 'id');
        $state = State::pluck('name', 'id');
        $areas = Area::where('state_id','=',$users->state)->pluck('name', 'id');
        return view('User.edit',compact('users','company','state','areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isSuper');
        $request->validate([
            'role' => 'required',
            'name' => 'required|string|max:255',
            'pass1' => 'required|string',
            'username'=>'required|string|unique:users,username,'.$id,
            'mobile_number'=>'required',
        ]);
        if($request->role==1||$request->role==2||$request->role==3||$request->role==4){
           $request->validate([
            'employee_id' => 'required',
            ]); 
        }
        if($request->email){
           $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            ]); 
        }
        if($request->role==3||$request->role==4||$request->role==5){
           $request->validate([
            'area_id' => 'required',
            'comp_id' => 'required',
            ]); 
        }
        $input=$request->all();
        if($file = $request->file('icard')) {        
            $optimizeImage = Image::make($file);
            echo $optimizePath = public_path().'/document/';
            $name = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['icard'] = $name;
        }
        if($file = $request->file('govt_issue_id')) {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/document/';
            $name = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['govt_issue_id'] = $name;
        }   
        if($file = $request->file('back_govt_card')) {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/document/';
            $name = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['back_govt_card'] = $name;
        }

        $input['pass1'] =$request->pass1;
        $input['password'] = Hash::make($request->pass1);
        $data = User::findOrFail($id);
        $data->update($input);
         if($request->role==2){
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
        return redirect()->route('userfill',$role)->with('updated','User Updated Successfully.');
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
    public function users($role,$status=null)
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
           $users=$users->where('status','=',$status)->orderBy('id','desc')->get();
        }else{
           $users=$users->orderBy('id','desc')->get();
        }
      
        return view('User.index',compact('users'));
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
            $data = User::findOrFail($request->id);
            $data=$data->update(array('status'=>$request->status));
            if($data){
                $arr = array('status' => true,'action'=>'update','msg' => 'Status Change Successfully');
            }
            return Response()->json($arr);
        }
    }
}
