<?php

namespace App\Http\Controllers;

use App\UserNotification;
use App\User;
use App\Valuation;
use App\Area;
use App\State;
use Illuminate\Http\Request;
use Gate;
use App\Jobs\PushNotification;
class UserNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isSuper')) {
        $notification=UserNotification::latest()->get();  
        }else {
        $notification=UserNotification::where('sender_id','=',Auth()->user()->id)->latest()->get();  
        }       
       return view('Notification.user_index',compact('notification'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $company=User::where('role','=','4')->join('areas','areas.id','=','users.area_id')->join('valuations','valuations.id','=','users.comp_id')->join('states','states.id','=','areas.state_id')->pluck('valuations.name','valuations.id');
         return view('Notification.user_create',compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
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
         $input=$request->all();
         $input['sender_id']=Auth()->id();
         $data = UserNotification::create($input);
		 $firebaseToken = User::where('id','=',$request->user_id)->pluck('firebase_id')->all();
         $body="You Have New Notification";
         $title='New Notification';
        PushNotification::dispatch($firebaseToken,$body,$title);
        return redirect()->route('user_notification.index')
                        ->with('added','Notification Has been Submited.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::select('users.name','users.id','areas.id as areas_id','areas.name as areas_name','states.id as state_id','states.name as state_name','users.comp_id')->where('users.id','=',$id)->leftjoin('areas','areas.id','=','users.area_id')->leftjoin('states','states.id','=','areas.state_id')->first();
       $company=User::where('role','=','4')->join('areas','areas.id','=','users.area_id')->join('valuations','valuations.id','=','users.comp_id')->join('states','states.id','=','areas.state_id')->pluck('valuations.name','valuations.id');
        $comp_id=User::whereId($id)->value('comp_id');
        return view('Notification.user_create',compact('company','user','comp_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotification $userNotification)
    {
        $company=User::where('role','=','4')->join('areas','areas.id','=','users.area_id')->join('valuations','valuations.id','=','users.comp_id')->join('states','states.id','=','areas.state_id')->pluck('valuations.name','valuations.id');
        $notification=UserNotification::select('areas.name as area_name','states.name as state_name','users.name as exe_name','states.id as state_id')->join('areas','areas.id','=','user_notifications.area_id')->join('states','states.id','=','areas.state_id')->join('users','users.id','=','user_notifications.user_id')->where('user_notifications.id','=',$userNotification->id)->first();
         //return $notification;
         return view('Notification.user_edit',compact('company','userNotification','notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotification $userNotification)
    {
        $request->validate([
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
         $input=$request->all();
         $input['sender_id']=Auth()->id();
         $data = UserNotification::findOrFail($userNotification->id);
         $data->update($input);
          return redirect()->route('user_notification.index')
                        ->with('updated','Notification Has been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotification $userNotification)
    {
        $userNotification->delete();
        return back()->with('deleted', 'Notification has been deleted');
    }
    public function getcompany_area(Request $request){
        if($request->ajax()){
            //$request->all();
            $company=User::where('role','=','4')->where('status','=','active')->join('areas','areas.id','=','users.area_id')->join('valuations','valuations.id','=','users.comp_id')->join('states','states.id','=','areas.state_id');
            if($request->area_id && $request->valuations_by && $request->state){
                $company=$company->where('valuations.id','=',$request->valuations_by);
               $company=$company->where('areas.state_id','=',$request->state);
               $company=$company->where('users.area_id','=',$request->area_id)->pluck('users.name','users.id');
               return $company;
            }
            if($request->state && $request->valuations_by){
              $company=$company->where('valuations.id','=',$request->valuations_by);
              $company=$company->where('areas.state_id','=',$request->state)->pluck('areas.name','areas.id');
              return $company;
            }
             if($request->valuations_by){
               $company=$company->where('valuations.id','=',$request->valuations_by)->pluck('states.name','states.id');
               return $company;
            }
            /*if(!isset($request->user_id)){
                return $company;
            }*/
            return $company;
        }
    }
	private function sendNotification($firebaseToken,$body,$title)
    {
        $firebaseToken = User::whereIn('role',[1,2])->pluck('firebase_id')->all();
        $SERVER_API_KEY = 'AAAAt7BVyrM:APA91bEsKXBsy0l7FNDs8t073Qfk2pxGvUBAHbdx7dy2erdXjeLgnywxLUqt2Yt1UshoY6WAgon05Yz3xSPfj2fv4K7syBuhjfiAymmUFQ3xw_erN0vwpLStlVEgNroVVe9o09jwaEO0';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,  
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);    
        $response = curl_exec($ch);
        //dd($response); 
    }

}
