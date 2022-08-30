<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tracker;
use DataTables;
use DB;
class AdminController extends Controller
{
    public function logs(Request $request)
    {
    	 $visitor = Tracker::sessions(60*24*365 );
    	if ($request->ajax()) {
    		$data=$visitor;
    		return Datatables::of($data)->addIndexColumn()->editColumn('user.name',function($row){
    			if(isset($row['user']['name'])){
    				return $row['user']['name'];
    			}
    			return 'Anonymous';
    		})->editColumn('updated_at',function($row){
                if(isset($row['updated_at'])){
                    return date('d-m-Y h:i:s a',strtotime($row['updated_at']));
                }
            })->make(true);
    	}
    	return view('Admin.logs');
    }
    public function image(){
        ini_set('max_execution_time',0);
        $data=DB::table('finances2')->get();
        foreach ($data as $key => $value) {
            $dat1=json_decode($value->photo);
            if($dat1){
                foreach ($dat1 as $key => $value1) {
                file_put_contents(public_path('backup/').$value1, file_get_contents('https://arvindam.in/public/finance/'.$value1));
                }
            }
            //print_r($dat1);
        }
        //return $data->photo; 
    }
    public function chases(){
         ini_set('max_execution_time',0);
        $data=DB::table('finances2')->get();
        foreach ($data as $key => $value) {
            if(!empty($value->videos)){
              $dat1=json_decode($value->videos);
                foreach ($dat1 as $key => $value1) {
                file_put_contents(public_path('backup/').$value1, file_get_contents('https://arvindam.in/public/videos/'.$value1));
                }
            }
            //print_r($dat1);
        }
        //return $data->photo; 
    }
    
}
