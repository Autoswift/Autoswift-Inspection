<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Fullbackup;
use DB;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('CheckRole:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth()->user()->role==5){
            return redirect()->route('company_home');
        }
        if(Auth()->user()->role==3){
            return redirect()->route('mobile_home');
        }
         $dashboard = DB::select("SELECT sum(case when role = 2 then 1 else 0 end) as admin,sum(case when role = 4 then 1 else 0 end) as employe,sum(case when role = 3 then 1 else 0 end) as mobile_admin from users");
          if(Auth()->user()->role==1){
                $today=DB::table('finances')->whereDate('created_at',date('Y-m-d'))->whereNotNull('report_date')->count();
          }else{
            $today=DB::table('finances')->whereDate('created_at',date('Y-m-d'))->whereNotNull('report_date')->where('user_id','=',Auth()->user()->id)->count();
          }
        $chart_options = [
            'chart_title' => 'Reports by months',
            'report_type' => 'group_by_date',
            'style_class'=>'red',
            'model' => 'App\Finance',
            'conditions'            => [
                ['name' => 'Pending', 'condition' => 'process = 0', 'color' => 'black', 'fill' => ''],
                ['name' => 'Approve', 'condition' => 'process = 1', 'color' => 'blue', 'fill' => ''],
                ['name' => 'Complete', 'condition' => 'process = 2', 'color' => 'red', 'fill' => '']
            ],
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'filter_field' => 'created_at',
            'filter_days' => 365,
            'date_format'=>'m-Y',
            'chart_type' => 'line', 
        ];
        $chart1 = new LaravelChart($chart_options);
        //print_r($chart1);
        return view('home',compact('dashboard','today','chart1'));
    }
    public function saveToken(Request $request)
    {
        auth()->user()->update(['firebase_id'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
    public function sendNotification()
    {
        $firebaseToken = User::whereIn('role',[1,2])->pluck('firebase_id')->all();
        $SERVER_API_KEY = 'AAAAt7BVyrM:APA91bEsKXBsy0l7FNDs8t073Qfk2pxGvUBAHbdx7dy2erdXjeLgnywxLUqt2Yt1UshoY6WAgon05Yz3xSPfj2fv4K7syBuhjfiAymmUFQ3xw_erN0vwpLStlVEgNroVVe9o09jwaEO0';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'New Report',
                "body" => 'Report Submited Mobile User',  
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
        dd($response); 
    }
	public function privacy(){
		return view('privacy');
	}
		
}
