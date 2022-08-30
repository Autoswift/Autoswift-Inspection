<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyNotification;
class CompanyadminController extends Controller
{
    public function Home()
    {
    	return View('Admin.company_home');
    }
    public function company_notification()
    {
    	$notification=CompanyNotification::where('sender_id','=',Auth()->id())->latest()->get();
    	return View('Admin.company_notification',compact('notification'));
    }
    public function send_notification(Request $request){
        $input=$request->all();
        $input['sender_id']=Auth()->id();
        $data = CompanyNotification::create($input);
        $data=$data->save();
        if($data){
            return redirect()->back()
                        ->with('success','Notification Has been Submited.');
        }
        return redirect()->back()
                        ->with('error','Somthing Went Wrong');
    }	
}
