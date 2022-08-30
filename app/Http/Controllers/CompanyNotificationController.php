<?php

namespace App\Http\Controllers;

use App\CompanyNotification;
use Illuminate\Http\Request;
use App\User;
use App\UserNotification;
class CompanyNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company=User::where('role','=','4')->join('areas','areas.id','=','users.area_id')->join('valuations','valuations.id','=','users.comp_id')->join('states','states.id','=','areas.state_id')->pluck('valuations.name','valuations.id');
        //return $company;
         $notification=CompanyNotification::latest()->get();
         return view('Notification.comp_index',compact('notification','company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CompanyNotification  $companyNotification
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyNotification $companyNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompanyNotification  $companyNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyNotification $companyNotification)
    {
        $notification=$companyNotification;
        return view('Notification.comp_edit',compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompanyNotification  $companyNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyNotification $companyNotification)
    {
        $request->validate([
            'registration_no'=>'required',
            'make_model'=>'required',
            'party_name'=>'required',
            'mobile_no'=>'required',
            'place'=>'required',
            'payment'=>'required',
        ]);
         $input=$request->all();
         $data = CompanyNotification::findOrFail($companyNotification->id);
         $data->update($input);
          return redirect()->route('company_notification.index')
                        ->with('updated','Notification Has been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompanyNotification  $companyNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyNotification $companyNotification)
    {
        $this->authorize('isSuper');
        $companyNotification->delete();
        return back()->with('deleted', 'Notification has been deleted');
    }
    public function sharenote(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'note_id'=>'required',
        ]);
        $notification=CompanyNotification::whereId($request->note_id)->first();
        $arr = array('status' => false,'action'=>'Submited','msg' => 'Somthing Went Wrong');
        if($notification){
            $input=['valuations_by'=>$request->valuations_by,
                    'user_id'=>$request->user_id,
                    'area_id'=>$request->area_id,
                    'registration_no'=>$notification->registration_no,
                    'make_model'=>$notification->make_model,
                    'party_name'=>$notification->party_name,
                    'mobile_no'=>$notification->mobile_no,
                    'place'=>$notification->place,
                    'payment'=>$notification->payment,
                    'sender_id'=>'65',
                    ];
            $data = UserNotification::create($input);
            $data->save();    
            if($data){
                $arr = array('status' => true,'action'=>'Submited','msg' => 'Notification No has been Shared');
            }    
        }
       return Response()->json($arr);
    }
}
