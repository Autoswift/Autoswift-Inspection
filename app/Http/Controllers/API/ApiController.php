<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Finance;
use Auth;
use Gate;
use App\UserNotification;
use DB;
use Hash;
use App\User;
use App\Valuation;
use App\State;
use App\Area;
use Image;
use App\Jobs\Formpdf;
use App\Jobs\PushNotification;
class ApiController extends BaseController
{
    
    public function get_report(Request $Request)
    {

       $finance= DB::table('finances')->select('finances.id','finances.user_id','finances.created_at','finances.registration_no','finances.make_model','finances.financed_by','finances.reference_no','finances.pdf_file','finances.form_pdf','valuations.name as companyname','users.name','users.role')->leftJoin('valuations','valuations.id','=','finances.valuation_by')->leftJoin('users','users.id','=','finances.user_id')->where('mobile_data','=',1);
        $finance1= DB::table('reject_reports')->select('reject_reports.id','reject_reports.user_id','reject_reports.created_at','reject_reason','reject_reports.registration_no','reject_reports.make_model','reject_reports.financed_by','reject_reports.reference_no','reject_reports.pdf_file','reject_reports.form_pdf','valuations.name as companyname','users.name','users.role')->leftJoin('valuations','valuations.id','=','reject_reports.valuation_by')->leftJoin('users','users.id','=','reject_reports.user_id')->where('mobile_data','=',1);
         if(Auth()->user()->role==4){
           $finance->where('finances.reference_no','like',Auth()->user()->employee_id.'%');
           $finance1->where('reject_reports.reference_no','like',Auth()->user()->employee_id.'%');
         }elseif(Auth()->user()->role==3){
           $finance->where('finances.valuation_by','=',Auth()->user()->comp_id);
           $finance1->where('reject_reports.reference_no','like',Auth()->user()->employee_id.'%');
         }
        
        $finance1=$finance1->latest()->get();
        $finance=$finance->latest()->limit(10)->get();
        $result=array_values($finance->merge($finance1)->sortByDesc('id')->toArray());
        foreach ($result as $key => $value) { 
            if($value->pdf_file!=null &&  $value->pdf_file!=''){
                $result[$key]->pdf_file=asset('finance/pdf/'.$value->pdf_file);
            }
            if($value->form_pdf!=null &&  $value->form_pdf!=''){
                $result[$key]->form_pdf=asset('finance/form_pdf/'.$value->form_pdf);
            }
        }
        return $this->sendResponse($result, 'Report retrieved successfully.'); 
    }
    public function accounstatus(){
        $user_id=Auth()->id();
        $notification=UserNotification::where('user_id','=',Auth()->user()->id)->count();
        $data['id']=Auth()->id();
        $data['profile_name']=Auth()->user()->profile_name;
        $data['name']=Auth()->user()->name;
        $data['employee_id']=Auth()->user()->employee_id;
        $data['role']=Auth()->user()->role;
        $data['firebase_id']=Auth()->user()->firebase_id;
        $data['ref_start']=Auth()->user()->ref_start;
        $data['notification']=$notification;
        $temp='';
        if(Auth()->user()->status == 'active' ){
            $data['user_status']=1;
            $temp="Account Active";
        }
        if(Auth()->user()->status == 'inactive' ){
            $data['user_status']=0;
            $temp="Account Inactive";
        }
        if(Auth()->user()->status == 'requested' ){
            $data['user_status']=3;
            $temp="User Data Required";
        }
        if(Auth()->user()->status == 'pending' ){
            $data['user_status']=2;
            $temp="Account Not Appoved Yet";
        }
        if(Auth()->user()->status == 'rejected' ){
            $data['user_status']=4;
            $temp="Please Register Again";
        }
        return $this->sendResponse($data,$temp); 
    }
    public function get_notification(Request $request){
        if(Auth()->user()->role==4){
            $notification=DB::select("select user_notifications.*,DATE_FORMAT(user_notifications.created_at,'%d-%m-%Y') AS date,users.name as excutive_name,areas.name as area,valuations.name as company_name From user_notifications,users,areas,valuations where valuations.id=user_notifications.valuations_by AND 
                    user_notifications.user_id=users.id AND 
                    areas.id=user_notifications.area_id AND 
                    user_notifications.user_id=".Auth()->user()->id." Order By id Desc");
        }elseif(Auth()->user()->role==1){
            $notification=DB::select("select user_notifications.*,DATE_FORMAT(user_notifications.created_at,'%d-%m-%Y') AS date,users.name as excutive_name,areas.name as area,valuations.name as company_name From user_notifications,users,areas,valuations where valuations.id=user_notifications.valuations_by AND 
                user_notifications.user_id=users.id AND 
                areas.id=user_notifications.area_id Order By id Desc");
        }else{
            $notification=DB::select("select user_notifications.*,DATE_FORMAT(user_notifications.created_at,'%d-%m-%Y') AS date,users.name as excutive_name,areas.name as area,valuations.name as company_name From user_notifications,users,areas,valuations where valuations.id=user_notifications.valuations_by AND 
                user_notifications.user_id=users.id AND 
                areas.id=user_notifications.area_id AND 
                user_notifications.sender_id=".Auth()->user()->id." Order By id Desc");
        }
        return $this->sendResponse($notification,'Notification retrieved successfully.');
    }
    public function send_notification(Request $request){
        $validator = Validator::make($request->all(), [
            'valuations_by'=>'required',
            'user_id'=>'required',
            'area_id'=>'required',
            'registration_no'=>'required',
            'make_model'=>'required',
            'party_name'=>'required',
            'mobile_no'=>'required',
            'place'=>'required',
            'payment'=>'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }
        $input=$request->all();
        $input['sender_id']=Auth()->user()->id;
        if($request->not_id){
          $data = UserNotification::findOrFail($request->not_id);
          $data->update($input);
          $res='Updated'; 
        }else{
           $data = UserNotification::create($input);
           $data->save();
           $res='Submited';
           $input['id']=$data->id;
        }
        return $this->sendResponse($input,'Notification '.$res.' successfully.');
    }
    public function add_user(Request $request){
        $input=$request->all();
        $input['pass1'] =$request->password;
        $input['password'] = Hash::make($request->password);
        $input['employee_id'] =$request->employee_id;
        $input['role'] =$request->position;
        $data = User::create($input);
        $data->save();
        $input['id']=$data->id;
        return $this->sendResponse($input,'User added successfully.');
    }
    public function get_valuations(){
        $valuation = Valuation::select('id','name')->orderBy('position')->get();
        return $this->sendResponse($valuation,'Valuations retrieved successfully.');
    }
    public function get_state(){
        $state = State::select('id','name')->latest()->get();
        return $this->sendResponse($state,'States retrieved successfully.');
    }
    public function get_area(Request $request){
         $validator = Validator::make($request->all(), [
            'state_id'=>'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
       $data = Area::select('id','name')->orderBy('name','asc')->where('state_id','=',$request->state_id)->get();
       return $this->sendResponse($data,'Areas retrieved successfully.'); 
    }
    public function getcompany_area(Request $request){
        $company=User::where('role','=','4')->where('status','=','active')->join('areas','areas.id','=','users.area_id')->join('valuations','valuations.id','=','users.comp_id')->join('states','states.id','=','areas.state_id');
        if($request->area_id && $request->valuations_by && $request->state_id){
           $company=$company->where('valuations.id','=',$request->valuations_by);
           $company=$company->where('areas.state_id','=',$request->state_id);
           $company=$company->where('users.area_id','=',$request->area_id)->pluck('users.name','users.id');
          return $this->sendResponse($company,'Executive retrieved successfully.');
        }
        if($request->state_id && $request->valuations_by){
          $company=$company->where('valuations.id','=',$request->valuations_by);
          $company=$company->where('areas.state_id','=',$request->state_id)->get(['areas.name','areas.id']);
          return $this->sendResponse($company,'Areas retrieved successfully.');
        }
         if($request->valuations_by){
           $company=$company->where('valuations.id','=',$request->valuations_by)->get(['states.name','states.id']);
          return $this->sendResponse($company,'States retrieved successfully.');
        }     
    }
    public function profile(Request $request){
        if (request()->isMethod('post')) {
            if($request->email){
               $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:users,email,'.Auth()->id(),
                ]); 
            }
            if($request->username){
              $validator = Validator::make($request->all(), [
                'username'=>'required|string|unique:users,username,'.Auth()->id(),
                ]); 
            }
            if(isset($validator) && $validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            $input=$request->all();
            if($file = $request->file('icard')) {        
                $optimizeImage = Image::make($file);
                $optimizePath = public_path().'/document/';
                $name = time().$file->getClientOriginalName();
                $optimizeImage->save($optimizePath.$name, 72);
                $input['icard'] = $name;
                $input['status']='pending';
				$firebaseToken = User::where('id','=',Auth()->id())->pluck('firebase_id')->all();
                $body="Registration request submitted";
                $title='Registration';
        		PushNotification::dispatch($firebaseToken,$body,$title);
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
            if($request->password){
                $input['pass1'] =$request->password;
                $input['password'] = Hash::make($request->password);
            }
            $data = User::findOrFail(Auth()->id());
            $data->update($input);
            return $this->sendResponse($input,'Profile Updated successfully.');
        }
        $profile=User::select('email','valuations.name as company_name','username','pass1','profile_name','users.address','icard','govt_issue_id','back_govt_card')->where('users.id','=',Auth()->id())->leftJoin('valuations','valuations.id','=','users.comp_id')->first();
        if($profile->icard){
             $profile->icard=asset('document/'.$profile->icard);
        }
        if($profile->govt_issue_id){
            $profile->govt_issue_id=asset('document/'.$profile->govt_issue_id);
        }
        if($profile->back_govt_card){
            $profile->back_govt_card=asset('document/'.$profile->back_govt_card);
        }
       
        return $this->sendResponse($profile,'Profile retrieved successfully.');
    }
    public function submit_report(Request $request){
         if(!$request->confirm && $request->application_no!='-'){
            $validator = Validator::make($request->all(), [
                'application_no' => 'required|unique:finances,application_no,'.$request->application_no,
            ]); 
            if(isset($validator) && $validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
        }   
        $input=array();
        $tab_1=json_decode($request->tab_1,true);
        $tab_2=json_decode($request->tab_2,true);
        $tab_3=json_decode($request->tab_3,true);
        $right_tyres=[]; $right_COM=[];$right_QTY=[];
        foreach ($tab_2['right_tyres'] as $value) 
        {
            $right_tyres[].= $value['NO_OF_TY'];
            $right_COM[].= $value['COM'];
            $right_QTY[].= $value['QTY'];
        }
        $left_tyres=[]; $left_COM=[];$left_QTY=[];
        foreach ( $tab_2['left_tyres'] as $value) 
        {
            $left_tyres[].= $value['NO_OF_TY'];
            $left_COM[].= $value['COM'];
            $left_QTY[].= $value['QTY'];
        }
        $input['right_tyer_quantity']=json_encode($right_tyres);
        $input['right_tyer_company']=json_encode($right_COM);
        $input['right_quality']=json_encode($right_QTY);

        $input['left_tyer_quantity']=json_encode($left_tyres);
        $input['left_tyer_company']=json_encode($left_COM);
        $input['left_quality']=json_encode($left_QTY);
        unset($tab_2['left_tyres']);
        unset($tab_2['right_tyres']);
        $input_data=array_merge($tab_1,$tab_2,$input);
        $input_data['general_comment']=$tab_3['comment'];
        $input_data['total_amount']=$tab_3['total_amount'];
        $input_data['amount_paid']=$tab_3['paid_amount'];
        $input_data['remaining_amount']=$tab_3['remaining_amount'];
        $input_data['reference_no']=Auth()->user()->employee_id.'-'.Auth()->user()->ref_start;
        $input_data['user_id']=Auth()->id();
        $input_data['application_no']=$request->application_no;
        if($request->file()){
            foreach($request->file() as $key => $file){
                if($key!='video1' && $key!='video2'){
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path().'/finance/';
                    $name = str_replace(' ', '_', time().Str::random(15).'.'.$file->extension());
                    $optimizeImage->save($optimizePath.$name,50);
                    if($key=='chassis_photo'){
                        $input_data['chachees_number_photo']=$name;
                    }
                    elseif($key=='selfie'){
                        $input_data['selfie']=$name;
                        $images[]=$name;
                    }else{
                        $images[]=$name;
                    }
                }elseif($key=='video1' || $key=='video2'){
                    $filename1 = str_replace(' ', '_', time().$file->getClientOriginalName());
                    $path1= public_path().'/videos/';
                    $file->move($path1, $filename1);
                    $videos[]=$filename1;
                }
            }
            if(!empty($images)){
                $input_data['photo']=json_encode($images); 
            }
            if(!empty($videos)){
                $input_data['videos']=json_encode($videos); 
            }
        }
        $input_data['mobile_data']=1;
        $data=Finance::create($input_data);
        $firebaseToken = User::whereIn('role',[1,2])->pluck('firebase_id')->all();
        $valuation_by=Valuation::whereId($input_data['valuation_by'])->value('name');
        $body=$valuation_by.' - '.$input_data['registration_no'];
        $title='New Mobile Report';
        if(isset($data->id)){
            User::where('ref_start','=',Auth()->user()->ref_start)->increment('ref_start');
            $res['report_id']=$data->id;
            Formpdf::dispatch($data->id);
            PushNotification::dispatch($firebaseToken,$body,$title);
            return $this->sendResponse($res,'Report Submited successfully.');
        }     
        return $this->sendResponse($res,'Somthing Went wrong.');
    }
    public function report_status(Request $request){
        $validator = Validator::make($request->all(), [
                'report_id' => 'required',
        ]); 
        if(isset($validator) && $validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $id=explode(',',$request->report_id);
        $data=Finance::select('id','process as status')->whereIn('id',$id)->get()->toArray();
        $data1=DB::table('reject_reports')->select('id','reject_reason')->whereIn('id',$id)->get();
        $result=array();
        foreach ($data1 as $key => $value) {
            $result[$key]['id']=$value->id;
            $result[$key]['status']=3;
            $result[$key]['reject_reason']=$value->reject_reason;
        }
        $result=array_merge($data,$result);
        return $this->sendResponse($result,'retrieved successfully.');
    }
    
}