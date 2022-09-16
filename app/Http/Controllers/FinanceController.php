<?php

namespace App\Http\Controllers;

use App\Finance;
use App\Valuation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use App\Staff;
use App\Declaration;
use App\Grid;
use Image;
use Storage;
use App\Header;
use App\Duplicate;
use ZipArchive;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PDF;
use URL;
use DB;
use App\Jobs\PushNotification;
use App\Exports\Export;
use Maatwebsite\Excel\Facades\Excel;
class FinanceController extends Controller
{
	public function __construct() {
		$this->alphabet = range('A', 'Z');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  

         if(\Request::route()->getName()=='report.index' && !$request->ajax()){
              $this->authorize('isSuper');
         }
         if ($request->ajax()) {
             $data = Finance::select('finances.*','valuations.name','users.name as created_by')->leftJoin('valuations','finances.valuation_by','=','valuations.id')->leftJoin('users','finances.user_id','=','users.id');
			$filtring = false;
            if($request->filterdata){
                $filterdata=$request->filterdata;
                if(!empty($filterdata['mobile_data'])){
                    $data->where('finances.mobile_data','=',1);
                    $data->whereNull('finances.report_date');
                }
                if(!empty($filterdata['today_report'])){
                      if(Auth()->user()->role==2){
                         $data->where('finances.user_id','=',Auth()->user()->id);  
                        }
                    $data->whereNotNull('finances.report_date');    
                    $data->whereDate('finances.created_at','=',date('Y-m-d'));
					$filtring = true;
                }
                if(!empty($filterdata['duplicate_entry'])){
                    $data->where('finances.duplicate_entry','=',1);
					$filtring = true;
                }
                if(!empty($filterdata['valuation_by'])){
                    $data->where('finances.valuation_by','=',$filterdata['valuation_by']);
					$filtring = true;
                }
                if(!empty($filterdata['valuation_by'])){
                    $data->where('finances.valuation_by','=',$filterdata['valuation_by']);
					$filtring = true;
                }
                if(!empty($filterdata['financer_representative'])){
                    $data->where('finances.financer_representative','Like','%'.$filterdata['financer_representative'].'%');
					$filtring = true;
                }
                if(!empty($filterdata['make_model'])){
                    //$data->where('finances.make_model','Like','%'.$filterdata['make_model'].'%');
					$make_model_arr = explode(" ", $filterdata['make_model']);
					foreach($make_model_arr as $mma) {
						$data->where('finances.make_model','Like','%'.$mma.'%');
					}
					$filtring = true;
                }
                if(!empty($filterdata['registration_no'])){
                    $data->where('finances.registration_no','Like','%'.$filterdata['registration_no'].'%');
					$filtring = true;
                }
                if(!empty($filterdata['reference_no'])){
                    $data->where('finances.reference_no','Like','%'.$filterdata['reference_no'].'%');
					$filtring = true;
                }
                if(!empty($filterdata['financed_by'])){
                    $data->where('finances.financed_by','Like','%'.$filterdata['financed_by'].'%');
					$filtring = true;
                }
                if(!empty($filterdata['amount_from'])){
                    $data->where('finances.total_amount','>=',$filterdata['amount_from']);
					$filtring = true;
                }
                if(!empty($filterdata['amount_to'])){
                    $data->where('finances.total_amount','<=',$filterdata['amount_to']);
					$filtring = true;
                }
                if(!empty($filterdata['staff_name'])){
                    $data->where('finances.staff_name','Like','%'.$filterdata['staff_name'].'%');
					$filtring = true;
                }
                if(!empty($filterdata['user_id'])){
                    $data->where('finances.user_id','=',$filterdata['user_id']);
					$filtring = true;
                }
                if(!empty($filterdata['application_no'])){
                    $data->where('finances.application_no','=',$filterdata['application_no']);
					$filtring = true;
                }
                 if(!empty($filterdata['chachees_number'])){
                    $data->where('finances.chachees_number','Like','%'.$filterdata['chachees_number'].'%');
					$filtring = true;
                }
                if(!empty($filterdata['create_date'])&&!empty($filterdata['create_end'])){
                    $create_date=date('Y-m-d',strtotime($filterdata['create_date']));
                    $create_end=date('Y-m-d',strtotime($filterdata['create_end'].' + 1 day'));
                    $data->whereBetween('finances.created_at',[$create_date,$create_end]);
					$filtring = true;
                }
                if(!empty($filterdata['search_on'])){
                        switch ($filterdata['search_on']) {
                            case "1":
                                $data->where('finances.remaining_amount','>',0);
								$filtring = true;
                                break;
                            case "2":
                               $data->where('finances.remaining_amount','=',0);
							   $filtring = true;
                                break;
                            case "3":
                                $data->where('finances.amount','>',0);
								$filtring = true;
                                break;
                            case "4":
								$data->where(function ($query) {
									$query->whereNull('finances.amount')
									->orWhere('finances.amount','=','')
									->orWhere('finances.amount','=',0);
								});
								$filtring = true;
                                break;
                            case "5":
                                $data->where('finances.fair_amount','=',0);
								$filtring = true;
                                break;  
                        }
                }
                if(!empty($filterdata['s_date'])&&!empty($filterdata['e_date'])){
                    $data->whereBetween('finances.report_date',[strtotime($filterdata['s_date']),strtotime($filterdata['e_date'])]);
					$filtring = true;
                }
            }
			//dd($filterdata);
            if($filtring){
				$data->where('finances.report_date','!=','');
                $data->orderBy('finances.report_date','asc');
            }else{
				$data->orderBy('finances.report_date','desc');
                //$data->orderBy('finances.id','desc');
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="'.route('report.edit',$row['id']).'" title="Edit" target="_blank"><i class="fa fa-pencil"></i></a>
                                <a href="" class="delete_report" id="'.$row['id'].'" title="Delete"><i class="fa fa-trash"></i></a>
                                <a href="'.route('report.show',$row['id']).'" title="Show"><i class="fa fa-eye"></i></a>
                                <a href="" class="deposite_amount"  id="'.$row['id'].'" title="Deposit"><i class="fa fa-money"></i></a>
                                ';
                                if($row['pdf_file']){
                                   $btn.='<a href="'.env('APP_URL').'/finance/pdf/'.$row['pdf_file'].'" title="pdf"><i class="fa fa-file-pdf-o"></i></a>';
                                }
                            return $btn;
                    })->addColumn('report_date', function($row){
                        if($row->report_date!='' && $row->report_date!=Null){
                           return date('d-m-Y',(int)$row->report_date); 
                       }else{
                        return null;
                       }
                        
                    })->addColumn('created', function($row){
						 return $row->created_at->format('d-m-Y');
                    })
                    ->rawColumns(['action','report_date','created'])
                    ->make(true);
        
        }
      $valuatation = Valuation::orderBy('position')->pluck('name','id');
      $user['SuperAdmin']= User::where('role','=',1)->orderBy('name','asc')->pluck('name','id');
      $user['WebAdmin']= User::where('role','=',2)->orderBy('name','asc')->pluck('name','id'); 
      return view('Reports.index',compact('valuatation','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grid=Grid::orderBy('vehicle_make','asc')->orderBy('vehicle_model','asc')->orderBy('variant','asc')->orderBy('year','asc')->get();
        $vehicle_make=Grid::select('vehicle_make')->groupBy('vehicle_make')->orderBy('vehicle_make')->pluck('vehicle_make','vehicle_make');
        $reference_no = Auth()->user()->employee_id.'-'.Auth()->user()->ref_start;
        $company = Valuation::orderBy('position')->pluck('name','id');
        $staff=Staff::orderBy('position')->where('status','=',1)->pluck('name','id');
        $declaration=Declaration::orderBy('position')->pluck('note','id');
        return view('Reports.create',compact('company','staff','declaration','reference_no','grid','vehicle_make'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //return strtotime($request->report_date);
        $input=$request->all();
        $input['right_tyer_quantity']=json_encode(array_values(array_filter($request->right_tyer_quantity)));
        $input['right_tyer_company']=json_encode(array_values(array_filter($request->right_tyer_company)));
        $input['right_quality']=json_encode(array_values(array_filter($request->right_quality)));
        $input['left_tyer_quantity']=json_encode(array_values(array_filter($request->left_tyer_quantity)));
        $input['left_tyer_company']=json_encode(array_values(array_filter($request->left_tyer_company)));
        $input['left_quality']=json_encode(array_values(array_filter($request->left_quality)));
        $base64_image =$request->ch_upload;
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            $extension = explode('/', mime_content_type($base64_image))[1];
            $name = str_replace(' ', '_', time().'.'.$extension);
            $optimizePath = public_path().'/finance/';
            file_put_contents($optimizePath.$name,$data);
            $input['chachees_number_photo']=$name;
        }
        if($request->file('uploadPhotos')){
            foreach($request->file('uploadPhotos') as $file){
                $optimizeImage = Image::make($file);
                $optimizePath = public_path().'/finance/';
                $name = str_replace(' ', '_', time().$file->getClientOriginalName());
                $optimizeImage->save($optimizePath.$name,50);
                $images[]=$name;
            }
            $input['photo']=json_encode($images);
            $input['approve_photo']=json_encode($images); 
        }
        if($request->duplicate_reason){
            $input['duplicate_entry']=1;
        }
        $input['stamp_show']=$request->stamp_show?1:0;
        $input['report_date']=strtotime($request->report_date);
        $input['process']=1;
        $input['user_id']=Auth()->user()->id;    
        $data=Finance::create($input);
		$data->report_date=strtotime($request->report_date);
		$data->inspection_date=$request->inspection_date;
        if($data){
            User::where('ref_start','=',Auth()->user()->ref_start)->increment('ref_start');
        }
        if(isset($input['approve_photo']) && $request->pdf){
            $data->pdf_file=$this->generate_pdf($data->id);
        }
		$data->save();
        $this->update_status($data->id);
        if(!isset($input['approve_photo']) && $request->pdf){
            return redirect()->route('report.edit', $data->id)->with('warning','Report Created Successfully. But Without Photo Pdf Not Created');
        }
        return redirect()->route('report.edit', $data->id)
                        ->with('added','Report Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show($finance)
    {
        $header=Header::latest()->first();
        $finance=Finance::findOrFail($finance);
       return view('Reports.view',compact('header','finance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit($finance)
    {
        $grid=Grid::orderBy('vehicle_make','asc')->orderBy('vehicle_model','asc')->orderBy('variant','asc')->orderBy('year','asc')->get();
        $vehicle_make=Grid::select('vehicle_make')->groupBy('vehicle_make')->orderBy('vehicle_make')->pluck('vehicle_make','vehicle_make');
        $reference_no = Auth()->user()->employee_id.'-'.Auth()->user()->ref_start;
        $company = Valuation::orderBy('position')->pluck('name','id');
        $staff=Staff::orderBy('position')->where('status','=',1)->pluck('name','id');
        $declaration=Declaration::orderBy('position')->pluck('note','id');
        $finance=Finance::findOrFail($finance);
        $duplicate=Duplicate::orderBy('position')->pluck('reason','id');
        return view('Reports.edit',compact('company','staff','duplicate','declaration','reference_no','finance','grid','vehicle_make'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$financeid)
    {
        $input=$request->all();
        $input['right_tyer_quantity']=json_encode(array_values(array_filter($request->right_tyer_quantity)));
        $input['right_tyer_company']=json_encode(array_values(array_filter($request->right_tyer_company)));
        $input['right_quality']=json_encode(array_values(array_filter($request->right_quality)));
        $input['left_tyer_quantity']=json_encode(array_values(array_filter($request->left_tyer_quantity)));
        $input['left_tyer_company']=json_encode(array_values(array_filter($request->left_tyer_company)));
        $input['left_quality']=json_encode(array_values(array_filter($request->left_quality)));
        $update=Finance::findOrFail($financeid);
        if(!$update['approve_photo'] && $request->pdf){
            return redirect()->back()
                        ->with('deleted','Unable to Make Pdf Without Photo.');
        }
        $base64_image =$request->ch_upload;
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            $extension = explode('/', mime_content_type($base64_image))[1];
            $name = str_replace(' ', '_',time().'.'.$extension);
            $optimizePath = public_path().'/finance/';
            file_put_contents($optimizePath.$name,$data);
            $input['chachees_number_photo']=$name;
        }
        if($request->approve_photo){
            $input['approve_photo']=json_encode($request->approve_photo); 
        }
        if($request->file('uploadPhotos')){
            foreach($request->file('uploadPhotos') as $file){
                $optimizeImage = Image::make($file);
                $optimizePath = public_path().'/finance/';
                $name = str_replace(' ', '_',time().Str::random(15).'.'.$file->extension());
                $optimizeImage->save($optimizePath.$name,50);
                $images[]=$name;
            }
            $input['photo']=json_encode($images);
            $input['approve_photo']=json_encode($images);
            if(!empty($update['photo'])){
                $p=json_decode($update['photo']);
                $input['photo']=json_encode(array_merge($p,$images));  
                $ap=json_decode($update['approve_photo']);
                $input['approve_photo']=json_encode(array_merge($ap,$images));  
            }   
        }
        if(empty($update['report_date'])){
            $input['user_id']=Auth()->id();
            $firebaseToken = User::where('id','=',$update['user_id'])->pluck('firebase_id')->all();
            $body="Report Created Successfully ! Registration No : ".$update['registration_no'];
            $title='Report Created';
            PushNotification::dispatch($firebaseToken,$body,$title);    
        }
       	if($request->report_date){
			$input['report_date']=strtotime($request->report_date);
		}
        $input['duplicate_entry']=0;
        if($request->duplicate_reason){
            $input['duplicate_entry']=1;
        }
        $msg='Report updated Successfully.';
        $input['stamp_show']=$request->stamp_show?1:0;
        if($request->pdf){
            $input['pdf_file']=$this->generate_pdf($update->id);
            if(\File::exists(public_path('/finance/pdf/'.$update['pdf_file']))){
                \File::delete(public_path('/finance/pdf/'.$update['pdf_file']));
            }
            $msg="New PDF Created ".$input['pdf_file'];
        }
        $this->update_status($update->id);  
        $update->update($input);
        return redirect()->back()
                        ->with('updated', $msg);
    }
    private function update_status($id){
       $data=Finance::findOrFail($id);
        if($data){
             if($data->fair_amount==0){
                $data->process=1;
                $data->save();
             }
             if($data->pdf_file && $data->fair_amount>0){
                $data->process=2;
                $data->save();
             }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy($finance)
    {
       
        $this->authorize('isSuper');
        $finance=Finance::findOrFail($finance);
        $reg=$finance->registration_no;
        $data=$finance->toArray();
        $data['updated_at']=date("Y-m-d h:i:s");
        DB::table('deleted_record')->insert($data);
        $finance->delete();
        return back()->with('deleted', 'Report has been deleted ! Registration No - '.$reg);
    }
    public function deleted_report(Request $request){
         $data = DB::table('deleted_record')->select('deleted_record.*','valuations.name')->leftJoin('valuations','deleted_record.valuation_by','=','valuations.id')->orderBy('deleted_record.updated_at','DESC');
         if ($request->ajax()) {
             return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="" Class="restore_report" id="'.$row->id.'"title="Restore"><i class="fa fa-undo"></i></a>
                                <a href="" class="delete_report" id="'.$row->id.'" title="Delete"><i class="fa fa-trash"></i></a>
                                ';
                                if($row->pdf_file){
                                   $btn.='<a href="'.env('APP_URL').'/finance/pdf/'.$row->pdf_file.'" title="pdf"><i class="fa fa-file-pdf-o"></i></a>';
                                }
                            return $btn;
                    })->addColumn('report_date', function($row){
                        if($row->report_date){
                           return date('d-m-Y',$row->report_date); 
                       }else{
                        return null;
                       }
                        
                    })->editColumn('updated_at', function($row){
                        return date('d-m-Y',strtotime($row->updated_at));         
                    })
                    ->rawColumns(['action'])
                    ->make(true);
         }
          return view('Reports.deleted_record');  
    }
    public function report_restore($finance){
         $fin=DB::table('deleted_record')->where('id','=',$finance)->get();
         $reg='';
        if($fin){
            $reg=$fin[0]->registration_no;
            $data = collect($fin)->map(function($x){ return (array) $x; })->toArray(); 
            DB::table('finances')->insert($data);
            DB::table('deleted_record')->delete($finance);
        }
       
        return back()->with('updated', 'Report has been Restore ! Registration No - '.$reg);
    }
    public function rejected_restore($finance){
        $fin=DB::table('reject_reports')->where('id','=',$finance)->get();
        $reg='';
        if($fin){
            $reg=$fin[0]->registration_no;
            $data = collect($fin)->map(function($x){ return (array) $x; })->toArray();
            unset($data[0]['reject_reason']);
            unset($data[0]['rejected_by']);
            DB::table('finances')->insert($data);
            DB::table('reject_reports')->delete($finance);
        }
        return back()->with('updated', 'Report has been Restore ! Registration No - '.$reg);
    }
    public function report_delete($finance){
        $reg=DB::table('deleted_record')->whereId($finance)->value('registration_no');
        DB::table('deleted_record')->delete($finance);
        return back()->with('deleted', 'Report has been deleted ! Registration No - '.$reg);
    }
    public function check_duplicate(Request $request){
        $arr = array('status' => false,'action'=>'get','msg' => 'Successfully');
        if($request->ajax()){
            if($request->for=='create'){
                if($request->registration_no){
                $data = Finance::where('registration_no','=',$request->registration_no)->latest()->first();
                if($data){
                    $arr = array('status' => true,'action'=>'get','data' =>$data,'msg'=>'Registration Number is Duplicate');
                }
                return $arr; 
                }
                if($request->chachees_number){
                    $data = Finance::where('chachees_number','=',$request->chachees_number)->count();
                    if($data){
                        $arr = array('status' => true,'action'=>'get','msg'=>'Chassis Number is Duplicate');
                    }
                    return $arr; 
                }
                 if($request->engine_number){
                    $data = Finance::where('engine_number','=',$request->engine_number)->count();
                    if($data){
                        $arr = array('status' => true,'action'=>'get','msg'=>'Engine Number is Duplicate');
                    }
                    return $arr; 
                }     

            }
            if($request->for=='update'){
                if($request->registration_no){
                    $data = Finance::where('registration_no','=',$request->registration_no)->count();
                    if($data>=2){
                        $arr = array('status' => true,'action'=>'get','msg'=>'Registration Number is Duplicate');
                    }
                    return $arr; 
                }
                if($request->chachees_number){
                    $data = Finance::where('chachees_number','=',$request->chachees_number)->count();
                    if($data>=2){
                        $arr = array('status' => true,'action'=>'get','msg'=>'Chassis Number is Duplicate');
                    }
                    return $arr; 
                }
                if($request->engine_number){
                    $data = Finance::where('engine_number','=',$request->engine_number)->count();
                    if($data>=2){
                        $arr = array('status' => true,'action'=>'get','msg'=>'Engine Number is Duplicate');
                    }
                    return $arr; 
                }
            }
        }
       
    }
    public function make_excel(Request $request){
        $validation=$request->validate([
            's_date' => 'required',
            'e_date'=>'required'
        ]);
        $request['filterdata']=$request->all();
        $header=Header::first()->toArray();
        $data = Finance::select('finances.*','valuations.name','valuations.address')->leftJoin('valuations','finances.valuation_by','=','valuations.id');
        $valu_by=false;
            if($request->filterdata){
                $filterdata=$request->filterdata;
				$excelPage = 'old';
                if(!empty($filterdata['mobile_data'])){
                    $data->where('finances.mobile_data','=',1);
					$excelPage = 'mobile';
                }
                if(!empty($filterdata['today_report'])){
                    $data->where('finances.created_at','=',date($filterdata['today_report']));
					$excelPage = 'today';
                }
                if(!empty($filterdata['duplicate_entry'])){
                    $data->where('finances.duplicate_entry','=',1);
                }
                if(!empty($filterdata['valuation_by'])){
                    $data->where('finances.valuation_by','=',$filterdata['valuation_by']);
                    $valu_by=true;
                }
                if(!empty($filterdata['financer_representative'])){
                    $data->where('finances.financer_representative','Like','%'.$filterdata['financer_representative'].'%');
                }
                if(!empty($filterdata['make_model'])){
                    $data->where('finances.make_model','Like','%'.$filterdata['make_model'].'%');
                }
                if(!empty($filterdata['registration_no'])){
                    $data->where('finances.registration_no','Like','%'.$filterdata['registration_no'].'%');
                }
                if(!empty($filterdata['reference_no'])){
                    $data->where('finances.reference_no','Like','%'.$filterdata['reference_no'].'%');
                }
                if(!empty($filterdata['financed_by'])){
                    $data->where('finances.financed_by','Like','%'.$filterdata['financed_by'].'%');
                }
                if(!empty($filterdata['amount_from'])){
                    $data->where('finances.total_amount','>=',$filterdata['amount_from']);
                }
                if(!empty($filterdata['amount_to'])){
                    $data->where('finances.total_amount','<=',$filterdata['amount_to']);
                }
                if(!empty($filterdata['staff_name'])){
                    $data->where('finances.staff_name','Like','%'.$filterdata['staff_name'].'%');
                }
                if(!empty($filterdata['user_id'])){
                    $data->where('finances.user_id','=',$filterdata['user_id']);
                }
                if(!empty($filterdata['application_no'])){
                    $data->where('finances.application_no','=',$filterdata['application_no']);
                }
                if(!empty($filterdata['create_date'])&&!empty($filterdata['create_end'])){
                    $create_date=date('Y-m-d',strtotime($filterdata['create_date']));
                    $create_end=date('Y-m-d',strtotime($filterdata['create_end']));
                    $data->whereBetween('finances.created_at',[$create_date,$create_end]);
                }
                if(!empty($filterdata['s_date'])&&!empty($filterdata['e_date'])){
                    $data->whereBetween('finances.report_date',[strtotime($filterdata['s_date']),strtotime($filterdata['e_date'])]);
                     $d1 = $filterdata['s_date'];
                     $d2= $filterdata['e_date'];
                }
                if(!empty($filterdata['search_on'])){
                        switch ($filterdata['search_on']) {
                            case "1":
                                $data->where('finances.remaining_amount','>=',1);
                                break;
                            case "2":
                               $data->where('finances.remaining_amount','>=',0);
                                break;
                            case "3":
                                $data->where('finances.amount','>',0);
                                break;
                            case "4":
                                $data->whereNull('finances.amount');
                                $data->where('finances.amount','=','');
                                break;
                            case "5":
                                $data->where('finances.fair_amount','=',0);
                                break;  
                        }
                }
                $data = $data->orderBy('report_date')->get()->toArray();
				//$sql = Str::replaceArray('?', $data->getBindings(), $data->toSql()); dd($sql);
				//echo '<pre>'; print_r($data); die;
				$result=$this->generate_excel($data, $d1, $d2, $header, $valu_by, $excelPage);
                if($result==true){
                  return back()->with('add', 'Grid Excel has been Generated');
                } 
            }
        return back()->with('deleted', 'Somthing went wrong');
    }
    public function image_reorder(Request $request){
        if($request->ajax()){
             $input['photo']=json_encode($request->imageids_arr);
             $data = Finance::findOrFail($request->id);
             $data->update($input);
             if($data){
                $arr = array('status' => true,'action'=>'update','msg'=>'Image Order Change Successfully');
                return $arr;
             }                  
        }
      return $arr = array('status' => false,'action'=>'update','msg'=>'Somthing went wrong');
    } 
    public function image_rotate(Request $request){
        if($request->ajax()){
             $img = Image::make(public_path('finance').'/'.$request->img);
             if($request->pos=='right'){
                $img->rotate(-90);    
             }else{
                $img->rotate(+90);
             }
             $imageName = $request->img;
             $destinationPath = public_path("finance/");
             $img->save($destinationPath . $imageName);
             $path = public_path("finance/".$request->img);
             $data = base64_encode(file_get_contents($path)); 
           return $arr = array('status' => true,'action'=>'update','msg'=>'Image Rotate Successfully','img'=>$data);
        }
      return $arr = array('status' => false,'action'=>'update','msg'=>'Somthing went wrong');
    } 
    public function image_remove(Request $request){
       if($request->ajax()){
            $data = Finance::findOrFail($request->id);
            if(!empty($data['photo'])){
                 $photo=json_decode($data['photo']);
                foreach (array_keys($photo, $request->image, true) as $key) {
                            unset($photo[$key]);
                    }
                $input['photo']=json_encode(array_values($photo));   
            }
            if(!empty($data['approve_photo'])){
                 $approve_photo=json_decode($data['approve_photo']);
                foreach (array_keys($approve_photo, $request->image, true) as $key) {
                            unset($approve_photo[$key]);
                    }
                $input['approve_photo']=json_encode(array_values($approve_photo));   
            }
            if($data){
                    $data->update($input);
                    if(\File::exists(public_path('finance/'.$request->image))){
                        \File::delete(public_path('finance/'.$request->image));
                    return $arr = array('status' => true,'action'=>'deleted','msg'=>'Image Remove Successfully');
                    }else{
                        return $arr = array('status' => false,'action'=>'deleted','msg'=>'Somthing went wrong');
                    }
            }
           
        }
    }
    public function make_zip($id){
            $result = Finance::findOrFail($id); 
            if(!empty($result['photo'])){
                $photo=json_decode($result['photo']);
                $filename = $result['registration_no'].'.zip';
                $zip = new ZipArchive();
                $tmp_file = public_path("tmp/").$filename;
                if(file_exists($tmp_file)){
                    \File::delete(public_path('tmp/'.$filename)); 
                }
                $zip->open($tmp_file, ZipArchive::CREATE);
                foreach($photo as $file){               
                    if(file_exists(public_path("/finance/").$file)){
                        $download_file = file_get_contents(public_path("/finance/").$file);
                        $zip->addFromString(basename($file),$download_file);
                    }
                }
                if(!empty($result['videos'])){
                    $video=json_decode($result['videos']);
                    if(!empty($video)){
                        foreach($video as $file){               
                        if(file_exists(public_path("/videos/").$file)){
                            $download_file = file_get_contents(public_path("/videos/").$file);
                            $zip->addFromString(basename($file),$download_file);
                        }
                      }     
                    }
                   
                }
                if(!empty($result['chachees_number_photo'])){
                     if(file_exists(public_path("/finance/").$result['chachees_number_photo'])){
                        $download_file = file_get_contents(public_path("/finance/").$result['chachees_number_photo']);
                        $zip->addFromString(basename($result['chachees_number_photo']),$download_file);
                    }
                }
                 if(!empty($result['selfie'])){
                     if(file_exists(public_path("/finance/").$result['selfie'])){
                        $download_file = file_get_contents(public_path("/finance/").$result['selfie']);
                        $zip->addFromString(basename($result['selfie']),$download_file);
                    }
                }
                $zip->close();
                if(file_exists($tmp_file)){
                    return response()->download(public_path('tmp/'.$filename));
                }
                return back()->with('deleted', 'Somthing went wrong');  
            }  
        return back()->with('deleted', 'Image Not Found');       
    }
    public function make_pdf(Request $request){
        if($request->report_id){
            $data=Finance::findOrFail($request->report_id);
            if($data){
               $input['pdf_file']=$this->generate_pdf($data->id);
                if(\File::exists(public_path('finance/pdf/'.$data['pdf_file']))){
                    \File::delete(public_path('finance/pdf/'.$data['pdf_file']));
                }
               $data->update($input);
               if($data){
                   return $arr = array('status' => true,'action'=>'add','msg'=>'Pdf Generated Successfully','file'=>$input['pdf_file']);    
               }
            }
             return $arr = array('status' => false,'action'=>'add','msg'=>'Somthing Went Wrong');    
        }
    }
    private function generate_excel($rows, $d1, $d2, $header, $valu_by, $excelPage){
      $valuation_by=' - ';
      if($valu_by){
        $valuation_by=$rows[0]['name'];
      }
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
        ->setCreator('YOUR NAME')
        ->setLastModifiedBy('YOUR NAME')
        ->setTitle('Demo Document')
        ->setSubject('Demo Document')
        ->setDescription('Demo Document')
        ->setKeywords('demo php spreadsheet')
        ->setCategory('demo php file');
         
        // NEW WORKSHEET
        $sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Invoice  '.date('F-Y',strtoTime($d1)));
        $sheet->mergeCells('A1:I1');
        $objRichText = new RichText();
        $run1 = $objRichText->createTextRun($header['authorizer_name']);
        $run1->getFont()->applyFromArray(array( "bold" => true, "size" => 20, "name" => "Arial"));

        $run2 = $objRichText->createTextRun($header['authorizer_education']);
        $run2->getFont()->applyFromArray(array("size" => 10, "name" => "Arial",));

        $sheet->setCellValue("A1", $objRichText);

        $sheet->getStyle('A1')->applyFromArray(array('alignment'=>array('horizontal' => Alignment::HORIZONTAL_CENTER)));


        $sheet->mergeCells('A2:I2');
        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A2',$header['authorizer_designation']);
        $sheet->getStyle('A2')->applyFromArray($styleArray);
        $sheet->mergeCells('A3:I3');
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A3',$header['report_heading'].' BILL - "'.$valuation_by.'"');
        $sheet->getStyle('A3')->applyFromArray($styleArray);
        $sheet->mergeCells('A4:I4');
        $styleArray = array(
            'font'  => array(
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ));
		$sheet->setCellValue('A4', '('.$d1.' To '.$d2.')');
        $sheet->getStyle('A4')->applyFromArray($styleArray);

        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ));

        $sheet->mergeCells('A5:I5');
		//echo '<pre>'; print_r($header); die;
        $sheet->setCellValue('A5','EMAIL:'.$header["email1"].'                '.$header["email2"].''.'                MOBILE NO : '.$header["mobile_number"]);
        $sheet->getStyle('A5')->applyFromArray($styleArray);
        $sheet->mergeCells('A6:I6');
        $sheet->setCellValue('A6', 'LICENCE NO : '.$header["licence_no"].($header["expire"]!=null? '         VALIDITY : '.$header["expire"]:'         IIISLA No : '.$header["iisla_no"]).'           BILL NO : '.date('m/y',strtoTime($d1)).'           DATED : '.date('d-m-Y'));
        $sheet->getStyle('A6')->applyFromArray($styleArray);
        // OUTPUT
        $drawing = new Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(public_path().'/image/logo_auto.png');
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);
        $drawing->setRotation(0);
        $drawing->setWidthAndHeight(120,120);
        $drawing->getShadow()->setVisible(true);
        $drawing->getShadow()->setDirection(100);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $styleArray = array(
            'font'  => array(
                'size'  => 11,
                'name'  => 'Calibri',
            ),'alignment' => array(
                    'vertical' => Alignment::VERTICAL_TOP,
                ));

        $sheet->getStyle('A7:I7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');


        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(14);



        $sheet->setCellValue('A7', 'S.No.');
        $sheet->setCellValue('B7', 'Date');
        $sheet->setCellValue('C7', 'Application No.');
        $sheet->setCellValue('D7', 'Financer Rep');
        $sheet->setCellValue('E7', 'Registration No.');
        $sheet->setCellValue('F7', 'Make & Model');
        $sheet->setCellValue('G7', 'Finance Taken By');
        $sheet->setCellValue('H7', 'Place');
        $sheet->setCellValue('I7', 'Total Amount');
        $i=8;
        $j=1;
        $total=0;
        foreach ($rows  as $key => $value) {
//echo '<pre>'; print_r($value); die;
            $sheet->getRowDimension($i)->setRowHeight(50);
            $sheet->setCellValue('A'.$i,$j);
            $sheet->setCellValue('B'.$i, date('d-m-Y', (int)$value['report_date']));
            $sheet->setCellValue('C'.$i, $value['application_no']);
            $sheet->setCellValue('D'.$i, $value['financer_representative']);
            $sheet->setCellValue('E'.$i, $value['registration_no']);
            $sheet->setCellValue('F'.$i, $value['make_model']);
            $sheet->setCellValue('G'.$i, $value['financed_by']);
            $sheet->setCellValue('H'.$i, $value['place_of_valuation']);
            $sheet->setCellValue('I'.$i, $value['total_amount']);
            $total=$total+$value['total_amount'];
            $i++;
            $j++;
        }
            /*$objs    = new toWords();
            $obj=$objs->toWord($total);*/
        $spreadsheet->getActiveSheet()->getStyle('A7:I'.$i)
            ->getAlignment()->setWrapText(true);
        $sheet->getStyle('A7:I'.$i)->applyFromArray($styleArray);
        $sheet->mergeCells('A'.$i.':H'.$i);

        $sheet->getStyle('A'.$i)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' => Alignment::HORIZONTAL_CENTER,)));
        $sheet->getStyle('I'.$i)->applyFromArray(array('font'  => array('bold'  => true)));

        $sheet->setCellValue('A'.$i, 'Total Amount ('.toWord($total).')');
        $sheet->setCellValue('I'.$i,$total);
        $il=$i+1;
        $ilx=$i+3;
        $sheet->mergeCells('A'.$il.':I'.$ilx);

        $sheet->getStyle('A'.$il)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' => Alignment::HORIZONTAL_RIGHT,)));
        $sheet->setCellValue('A'.$il,'SEAL & SIGNATURE OF SURVEYOR');
        $styleArray = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' =>Border::BORDER_THIN
                ),
                 'bottom' => array(
                    'borderStyle' =>Border::BORDER_THIN
                ),
                  'left' => array(
                    'borderStyle' =>Border::BORDER_THIN
                ),
                   'right' => array(
                    'borderStyle' =>Border::BORDER_THIN
                ),
            ),
        );
        for ($i=7; $i <= $il; $i++) { 
            $sheet->getStyle('A'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('B'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('C'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('E'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('F'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('G'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('I'.$i)->applyFromArray($styleArray);
        }
		if($excelPage == 'mobile') {
			$name = 'Mobile reports from - to'.'.xlsx';
		} else if($excelPage == 'today') {
			$name = 'Today\'s reports '.date('d-m-Y').'.xlsx';
		} else {
			$name = 'Old reports from - to'.'.xlsx'; //to do report date or creation date
		}
        if(!$valu_by){
            $writer = new Xlsx($spreadsheet);

            $date=date_create($d1);
              //$name= date_format($date,"M Y").'.xlsx';

              header('Content-type: application/vnd.xlsx');
              header('Content-Disposition: attachment; filename="'.$name.'"');
              $writer->save('php://output');
			  exit;
              return true;   
        }
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle('Covernote  '.date('F-Y',strtoTime($d1)));
        $sheet =$spreadsheet->setActiveSheetIndex(1);
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $objRichText = new RichText();
        $run1 = $objRichText->createTextRun($header['authorizer_name']);
        $run1->getFont()->applyFromArray(array( "bold" => true, "size" => 15, "name" => "Arial"));

        $run2 = $objRichText->createTextRun($header['authorizer_education']);
        $run2->getFont()->applyFromArray(array("size" => 8, "name" => "Arial",));

        $sheet->setCellValue("A2", $objRichText);

        $sheet->getStyle('A2')->applyFromArray(array('alignment'=>array('horizontal' => Alignment::HORIZONTAL_CENTER)));


        $sheet->mergeCells('A3:K3');
        $sheet->mergeCells('A4:K4');
        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A3',$header['authorizer_designation']);
        $sheet->getStyle('A3')->applyFromArray($styleArray);
       

        $sheet->mergeCells('A6:K6');
        $sheet->setCellValue('A6','EMAIL:'.$header["email1"].'                '.$header["email2"].''.'                MOBILE NO : '.$header["mobile_number"]);
       
        $sheet->mergeCells('A7:K7');
        $sheet->setCellValue('A7', '        LICENCE NO : '.$header["licence_no"].($header["expire"]!=null? '         VALIDITY : '.$header["expire"]:'         IIISLA No : '.$header["iisla_no"]).'           BILL NO : '.date('m/y',strtoTime($d1)).'           DATED : '.date('d-m-Y'));
        // OUTPUT
        $drawing = new Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(public_path().'/image/logo_auto.png');
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);
        $drawing->setRotation(0);
        $drawing->setWidthAndHeight(120,120);
        $drawing->getShadow()->setVisible(true);
        $drawing->getShadow()->setDirection(100);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        $sheet->mergeCells('A8:K8');
        $sheet->mergeCells('A9:K9');
        $sheet->setCellValue('A9',$valuation_by);
        $sheet->getStyle('A9')->applyFromArray(array(
            'font'  => array(
                'size'  => 12
            )));
        $sheet->getStyle('A9')->getFont()->setUnderline(true);
        $sheet->mergeCells('A10:K10');
        $sheet->setCellValue('A10',$rows[0]['address']);
        $sheet->getRowDimension('10')->setRowHeight(40);
        $sheet->mergeCells('A12:K12');
        $sheet->setCellValue('A12','Subject:- Invoice for valuation of vehicles conducted in '.date('F Y',strtotime($d1)));
        $sheet->getStyle('A12')->applyFromArray(array('font'  => array('bold'  => true)));
        $sheet->mergeCells('A14:K14');
        $sheet->setCellValue('A14','Sir/Madam');
        $sheet->mergeCells('A15:K15');
        $objRichText = new RichText();
        
        $objRichText->createText('Please find the attached invoice for the ');

        $objBold = $objRichText->createTextRun(count($rows).' valuations and inspections of vehicles ');
        $objBold->getFont()->setBold(true);

        $objRichText->createText('conducted in the month of ');
        $objBold = $objRichText->createTextRun(date('F Y',strtoTime($d1)));
        $objBold->getFont()->setBold(true);
        $objRichText->createText(' amounting to ');

        $objBold = $objRichText->createTextRun('Rs. '.$total.'/- ('.toWord($total).').');
        $objBold->getFont()->setBold(true);

        $sheet->getCell('A15')->setValue($objRichText);
        $sheet->mergeCells('A16:K16');
        $sheet->setCellValue('A16','Thanking you and assuring our best services, we remain,');
        $sheet->mergeCells('A18:K18');
        $sheet->mergeCells('A19:c19');
        $sheet->setCellValue('A19',"Yours's Faithfully");
        $sheet->mergeCells('A22:c22');
        $sheet->setCellValue('A22',"Arvind Kumar Mittal");
        $sheet->mergeCells('A23:c23');
        $sheet->setCellValue('A23',"Surveyor & Loss Assessor");
       /* $sheet->setCellValue('A15','Please find the attached invoice for the 145 valuations and inspections of vehicles conducted in the month of July 2020 amounting to Rs. 14,500/- (Fourteen Thousand and Five hundred rupees only).');*/
        $sheet->getRowDimension('15')->setRowHeight(50);
        $sheet->getStyle('A15')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A15')->applyFromArray(array(
            'alignment' => array(
                    'vertical' => Alignment::VERTICAL_TOP,
                )));
        $sheet->getStyle('A10')->applyFromArray(array(
            'alignment' => array(
                    'vertical' => Alignment::VERTICAL_TOP,
                )));
        $sheet->getStyle('A10')->getAlignment()->setWrapText(true);
        $styleArray = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' =>Border::BORDER_THICK
                ),
                 'bottom' => array(
                    'borderStyle' =>Border::BORDER_THICK
                ),
                  'left' => array(
                    'borderStyle' =>Border::BORDER_THICK
                ),
                   'right' => array(
                    'borderStyle' =>Border::BORDER_THICK
                ),
            ),
        );
        $sheet->getStyle('A2:K44')->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);

        $date=date_create($d1);
        //$name= date_format($date,"F_Y").'.xlsx';
        header('Content-type: application/vnd.xlsx');
        header('Content-Disposition: attachment; filename="'.$name.'"');
		//ob_end_clean();
        $writer->save('php://output');
		exit;
        return true;

    }
    public function generate_pdf($id){
        $data = Finance::select('finances.*','valuations.name as valuationsname','declarations.note')->leftJoin('valuations','finances.valuation_by','=','valuations.id')->leftJoin('declarations','finances.notice','=','declarations.id')->where('finances.id','=',$id)->first();
        if(!$data){
            return false;
        }
        $FinanceData['Finance']=$data;
        $FinanceData['header']=Header::latest()->first();
        $filename = strtotime('now').'.pdf';  
        //$pdf = new TCPDF();
        PDF::SetTitle('Finance book');
        PDF::SetAuthor('');
        $lg = Array();
        $l['a_meta_charset'] = 'UTF-8';
        $l['a_meta_dir'] = 'ltr';
        $l['a_meta_language'] = 'en';
        $lg['w_page'] = 'page';
        $stamp_show='';
        if($FinanceData["Finance"]["stamp_show"]==1){
            $stamp_show='<img  src="'.public_path("image/st.jpg").'" width="70" height="60" />';
        }
        // set some language-dependent strings (optional)
        PDF::setLanguageArray($lg);
        //$pdf->setPrintHeader('Accept-Ranges: bytes');
        PDF::setPrintHeader(false);
        PDF::AddPage();
        PDF::SetFont('freesans', '', 15,'false');
        PDF::setHeaderCallback(function($pdf) use($FinanceData) {
            $pdf->SetFont('helvetica', 'B', 15);
            $pdf->Cell(0, 10,$FinanceData['Finance']['registration_no'], 0, false, 'L', 0, '', 0, false, 'T', 'M');

        });
        ob_start();
        $html = "";
        $x = 115;
        $y = 35;
        $w = 25;
        $h = 50;
        PDF::Image(public_path('image/logo_auto.png'),15, 10, 40, 29, 'PNG');
        $html = '<table>
                        <tr>                            
                            <td colspan="6" style="text-align:center;"> 
                                <span style="font-size:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'.$FinanceData["header"]["authorizer_name"].'</strong></span><sub>'.$FinanceData["header"]["authorizer_education"].'</sub><br>
                            <span style="text-align:center;padding-right: 20%; font-size:12px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$FinanceData["header"]["authorizer_designation"].' </span>
                            <br><br><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$FinanceData["header"]["report_heading"].' REPORT </strong>
                            </td>
                            <td colspan="2" style="font-size:12px;"> 
                                <br> MOBILE NO : '.$FinanceData["header"]["mobile_number"].'
                                <br> LICENCE NO : '.$FinanceData["header"]["licence_no"].'
                                <br> '.($FinanceData["header"]["expire"]!=null? 'VALIDITY : '.$FinanceData["header"]["expire"]:'IIISLA No : '.$FinanceData["header"]["iisla_no"]).'
                                <br> EMAIL:'.$FinanceData["header"]["email1"].'
                                <br>&nbsp;'.$FinanceData["header"]["email2"].'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    
                    <table cellspacing="0" cellpadding="2" border="1" style="font-size:14px!important;">
                        <tr>
                            <td style="width:22%;"> Ref. No </td>
                            <td style="width:51.5%; font-size:14px!important;"> '.$FinanceData['Finance']['reference_no'].' </td>
                            <td style="width:10%;"> Staff </td>
                            <td style="width:16.5%;"> '.$FinanceData['Finance']['staff_name'].' </td>
                        </tr>
                        <tr>
                            <td> Valuation Initiated By </td>
                            <td colspan="5"><strong> '.$FinanceData['Finance']['valuationsname'].'</strong> </td>
                        </tr>
                        <tr>
                            <td> Financer Representative </td>
                            <td colspan="5"> '.ucfirst($FinanceData['Finance']['financer_representative']).'</td>
                        </tr>
                        <tr>
                            <td> Place of Valuation </td>
                            <td colspan="5"> '.ucfirst($FinanceData['Finance']['place_of_valuation']).'</td>
                        </tr>
                        <tr >
                            <td><strong> Registration No.</strong> </td> 
                            <th style="width:37.5%; top:15px; height:25px; font-size:16px;"><strong > '.$FinanceData['Finance']['registration_no'].'</strong></th>
                            <td style="width:24%;"> Application No</td>
                            <td style="width:16.5%;"> '.$FinanceData['Finance']['application_no'].' </td>
                        </tr>
                    </table>
                        <br>
                        <br>
                        <table cellspacing="0" cellpadding="2" border="1" style="width:100%;">
                        <tr >
                            <td colspan="2" style="width:22%;"><strong style="font-size:14px;"> Make & Model</strong> </td> 
                            <th colspan="3" style="font-size:14px;width:37.5%;"> <strong>'.$FinanceData['Finance']['make_model'].'</strong></th>
                            <td colspan="2" style="width:24%;"> <strong style="font-size:14px;">Date of Report </strong> </td>
                            <td colspan="1" style="font-size:14px;width:16.5%;"> '.date("d-m-Y" ,$FinanceData['Finance']['report_date']). '</td>
                        </tr>
                        <tr >
                            <td colspan="2"><strong style="font-size:14px;"> Chassis Number</strong> </td> 
                            <th colspan="3"><strong style="font-size:14px;"> '.$FinanceData['Finance']['chachees_number'].'</strong></th>
                            <td colspan="2"> <strong style="font-size:14px;">Date of Inspection</strong> </td>
                            <td colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['inspection_date']. '</td>
                        </tr>
                        <tr >
                            <td colspan="2"><strong style="font-size:14px;"> Engine No.</strong> </td> 
                            <th colspan="3"><strong style="font-size:14px;"> '.$FinanceData['Finance']['engine_number'].'</strong></th>
                            <td colspan="2"> <strong style="font-size:14px;">Registration Date </strong> </td>
                            <td colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['registration_date']. '</td>
                        </tr>
                        
                        <tr >
                            <td colspan="2"><strong style="font-size:14px;"> Registered Owner</strong> </td> 
                            <th colspan="3"><strong style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['registerd_owner']).'</strong></th>
                            <td colspan="2"><strong style="font-size:14px;"> Colour</strong> </td>
                            <th colspan="1" style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['color']).'</th>
                            
                        </tr>
                        <tr >
                            <td colspan="2"><strong style="font-size:14px;"> Finance Taken By</strong> </td> 
                            <th colspan="3"><strong style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['financed_by']).'</strong></th>
                            <td colspan="2"><strong style="font-size:14px;"> Seating Capacity</strong> </td>
                            <th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['seating_capacity'].'</th>
                        </tr>
                        <tr >
                            <td colspan="2"> <strong style="font-size:14px;">Tax Paid Upto </strong> </td>
                            <td colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['tax_paid']. '</td>
                            <td colspan="2"><strong style="font-size:14px;"> Regd. Laden Wt.(Kg)</strong> </td>
                            <th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['laden_wt'].'</th>
                            
                        </tr>
                    
                        <tr >
                            <td colspan="2"><strong style="font-size:14px;"> Hypothecation</strong> </td> 
                            <th colspan="3" style="font-size:14px;"> <strong>'.$FinanceData['Finance']['hypothecation'].'</strong></th>
                            <td colspan="2"><strong style="font-size:14px;"> Regd. Unladen Wt.(Kg)</strong> </td>
                            <td colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['unladen_wt'].'</td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"><strong> Policy No.</strong> </td> 
                            <th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['policy_no'].'</th>
                            <td colspan="2"><strong> Fuel Used</strong> </td>
                            <td colspan="1" style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['fule_used']).'</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong> Validity</strong> </td> 
                            <th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['validity'].'</th>                   
                            <td colspan="2"><strong> Owner Serial No.</strong> </td> 
                            <th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['owner_serial_number'].'</th>
                        </tr>
                        <tr>
                            <td colspan="2"><strong> Policy Type</strong> </td> 
                            <th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['policy_type'].'</th>
                            <td colspan="2"><strong> Cubic Capacity (CC/Bhp)</strong> </td> 
                            <th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['cube_capacity'].'</th>
                        </tr>
                        
                        <tr >
                            <td colspan="2"><strong> SUM Insured(IDV)</strong> </td> 
                            <th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['sum_insured'].'</th>
                            <td colspan="2"><strong> MM Reading (Km/Hour)</strong> </td>
                            <th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['mm_reading'].'</th>
                        </tr>
                        
                        <tr>
                            <td colspan="5" rowspan="7" align="left" style="text-align:left;">
                        ';
                        if(!empty($FinanceData["Finance"]['approve_photo'])){
                            PDF::SetHeaderData('', 1,$FinanceData['Finance']['registration_no'], '');
                            PDF::setPrintHeader(true);
                        }
                        $html.='<table border="1" cellpadding="1" cellspacing="3" width="98%">
                                    <tr>
                                        <td colspan="3">Right Tyres </td>
                                        <td colspan="3">Left Tyres </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:10px; text-align:center;" width="13%"> Quantity </td>
                                        <td style="font-size:10px; text-align:center;" width="24%"> Company </td>
                                        <td style="font-size:10px; text-align:center;"width="13%"> Percentage </td>
                                        <td style="font-size:10px; text-align:center;"width="13%"> Quantity </td>
                                        <td style="font-size:10px; text-align:center;"width="24%"> Company </td>
                                        <td style="font-size:10px; text-align:center;"width="13%"> Percentage </td>
                                    </tr>
                                    ';
                        if(!empty($FinanceData["Finance"]["left_tyer_quantity"])){
                                    $rowSpan = count(array_filter(json_decode($FinanceData["Finance"]["left_tyer_quantity"])));
                                    
                                    $left_tyer_company = json_decode($FinanceData["Finance"]["left_tyer_company"]);
                                    $left_quality = json_decode($FinanceData["Finance"]["left_quality"]);
                                    $right_tyer_quantity = json_decode($FinanceData["Finance"]["right_tyer_quantity"]);
                                    $right_tyer_company = json_decode($FinanceData["Finance"]["right_tyer_company"]);
                                    $right_quality = json_decode($FinanceData["Finance"]["right_quality"]);
                                    $a = array_filter(json_decode($FinanceData["Finance"]["left_tyer_quantity"])); 
                                    $html2 = "";
                                foreach($a as  $key => $tyerData){
                                    //$html .= "<th> </th>";
                                    $html2 .= "<tr>";
                                    if(!empty($right_tyer_quantity[$key])){
                                        $html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$right_tyer_quantity[$key].'</th>';
                                    }else{
                                        $html2 .='<th style="text-align:center;font-size:10px;" class="tg-us36">-</th>';
                                    }
                                    if(!empty($right_tyer_company[$key])){
                                        $html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$right_tyer_company[$key].'</th>';
                                    }else{
                                        $html2 .='<th style="text-align:center;font-size:10px;" class="tg-us36">-</th>';
                                    }

                                    if(!empty($right_quality[$key])){
                                        $html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$right_quality[$key].'</th>';
                                    }else{
                                        $html2 .='<th style="text-align:center;font-size:10px;" class="tg-us36">-</th>';
                                    }
                                     
                                    if(!empty($tyerData)){
                                        $html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$tyerData.'</th>';
                                    }else{
                                        $html2 .='<th style="text-align:center;font-size:10px;" class="tg-us36">-</th>';
                                    }
                                    if(!empty($left_tyer_company[$key])){
                                        $html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$left_tyer_company[$key].'</th>';
                                    }else{
                                        $html2 .='<th style="text-align:center;font-size:10px;" class="tg-us36">-</th>';
                                    }
                                    if(!empty($left_quality[$key])){
                                        $html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$left_quality[$key].'</th>';
                                    }else{
                                        $html2 .='<th style="text-align:center;font-size:10px;" class="tg-us36">-</th>';
                                    }
                                    //if($key > $rowSpan){
                                        //$html .= 'dfs';
                                    //}
                                    $html2 .= '</tr>';
                                }
                                 $html .= $html2.'</table></td>';
                            }
                        $html .= '
                            <td colspan="2"><strong> Battery</strong> </td>
                            <th colspan="1" style="font-size:13px;"> '.$FinanceData['Finance']['battery'].'</th>
                        </tr>
                        <tr>
                            <td colspan="2"><strong> Radiator</strong> </td>
                            <th colspan="1" style="font-size:13px;"> '.$FinanceData['Finance']['radiator'].'</th>
                        </tr>
                        <tr>
                            
                            <td colspan="2"> <strong>AC </strong> </td>
                            <td colspan="1"> '.ucfirst($FinanceData['Finance']['ac']).' </td>
                        </tr>
                        
                        <tr>
                            
                            <td colspan="2"> <strong>Power Steering </strong> </td>
                            <td colspan="1"> '.ucfirst($FinanceData['Finance']['power_steering']).' </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong> Power Window</strong> </td>
                            <th colspan="1"> '.ucfirst($FinanceData['Finance']['power_window']).'</th>                          
                        </tr>
                        <tr>
                            <td colspan="2"> <strong>Air Bag </strong> </td>
                            <td colspan="1"> '.ucfirst($FinanceData['Finance']['air_bag']).' </td>
                            
                        </tr>
                        </table>';
                         $html .= '<table><tr><td>&nbsp;</td></tr></table><table cellpadding="2" border="1">
                            <tr>
                            <td ><strong style="font-size:11px; text-align:center;"> Engine <br>Condition</strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Cooling <br> System </strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Suspension <br> System </strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Electrical <br> System </strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Wheel & <br> Tyres </strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Chassis </strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Cabin & Body Ext. </strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Condition of  Interiors </strong></td>
                            <td ><strong style="font-size:11px; text-align:center;"> Glasses </strong></td>                         
                            <td ><strong style="font-size:11px; text-align:center;"> Paint </strong></td>                           
                            
                        </tr> 

                        <tr>
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_engine_condition']).'</td>
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_cooling_system']).'</td>
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_suspension_system']).'</td>    
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_electrical_system']).'</td>
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_wheel']).'</td>
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_chassis']).'</td>
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_cabin']).'</td>
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_condition_of_interiors']).'</td>                           
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_glass']).'</td>                            
                            <td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_paint']).'</td>                            
                            
                        </tr>
                        </table>
                        <table><tr><td>&nbsp;</td></tr></table>
                        <table border="1" cellpadding="7" style="width:100%;">
                        <tr>
                            <td style="width:20%;"><strong> General Comment</strong></td>
                            <td style="font-size:9px; width:80%;white-space:nowrap;">'.$FinanceData['Finance']['general_comment'].'</td>
                        </tr>
                        </table><table><tr><td>&nbsp;</td></tr></table>
                        <table><tr><td><strong style="font-size:13px;"> CHASSIS IMPRESSION:- </strong></td></tr></table>
                        ';  
                    $html .= '<table style="width: 100%;border-collapse: collapse;border: 1px solid black;"><tr><td> &nbsp; </td></tr><tr><td style="text-align:center;width:15%;" height="65">'.$stamp_show.'</td><td style="width:70%;text-align:center;" height="65"><img src="'.public_path("finance/").$FinanceData["Finance"]["chachees_number_photo"].'" width="350" height="60" style="margin:2px" /></td><td style="width:15%">&nbsp;</td></tr></table>'; 
                    $html .= '
                    <table border="1" cellpadding="3">
                        <tr> 
                            <td width="22%;"> Fair Market Price(Rs.)  </td>
                            <td width="78%" >
                            <strong> ' .$FinanceData["Finance"]['fair_amount'].' ('.toWord($FinanceData["Finance"]['fair_amount']).') </strong>
                            </td>
                        </tr>
                    </table>
                    <table><tr><td style="padding-top:2px; font-size:9px;text-align: justify;">'.$FinanceData["Finance"]["note"].'</td></tr></table>
                   
                    <br>
                    <br>       
                    <table>
                    <tr>
                        <td width="85%"><strong>&nbsp;&nbsp;Arvind Kumar Mittal</strong></td>
                        <td rowspan="2"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.url("/finance/pdf").'/'.$filename.'" title="Link to Google.com" width="70" height="70"/></td>
                    </tr>
                    <tr>
                        <td width="85%">&nbsp;&nbsp;Valuer, Surveyor & Loss Assessor </td>
                    </tr>
                
                    </table>';      
                    if((!empty($FinanceData["Finance"]['approve_photo']))  ){
                        $html .= '<br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        ';
                    }
            PDF::WriteHTML($html, true, false, false, false, '');
            $htmlregistration = "<div>".
            $FinanceData['Finance']['registration_no']."
            </div>";
            $k = 1;
            PDF::SetAlpha(0.5);
        
            PDF::SetAlpha(1);
        //$htmll .= "";
        $anotherKey = 2; 
        $key1 = 0;
        $a = 0;
        $x = 0;
        $y = 0;
        $w = 0;
        $d = 0;
        $htmll = "";
        $ll=array(4,5,6,7,12,13,14,15,21,22,23,24);
        $imgtem=[];
        //pr($FinanceData["Finance"]['approve_photo']);die;
        if(!empty($FinanceData["Finance"]['approve_photo'])){
            $thirdKey = 0;
            $phto=json_decode($FinanceData["Finance"]['approve_photo']);
            $lastPhoto = count(json_decode($FinanceData["Finance"]['approve_photo']));
           
            foreach($phto as $key => $data ){
                $source_img = public_path("/finance/").$data;
                $destination_img = public_path("tmp/").$key.$FinanceData['Finance']['id'].'destination.jpg';
                $imgtem[]=$key;
                $comimg = $this->compress($source_img, $destination_img,20);
                $image = $destination_img;
                if($key == 0){
                    $x = 20;
                    $y = 10;
                }else{
                    if($key == 2){
                        $x = 20;
                        $y = 100;
                    }else if($key == 3){
                        $x = 150;
                        $y = 100;   
                    }else if($key == 4){
                        $x = 20;
                        $y = 190;   
                    }else if($key == 5){
                        $x = 150;
                        $y = 190;   
                    }else if($key == 6){
                        $x = 20;
                        $y = 280;   
                    }else if($key == 7){
                        $x = 150;
                        $y = 280;   
                    }else if($key == 8){
                        $x = 20;
                        $y = 300;   
                    }else if($key == 9){
                        $x = 150;
                        $y = 10;    
                    }else if($key == 10){
                        $x = 20;
                        $y = 100;   
                    }else if($key == 11){
                        $x = 150;
                        $y = 100;   
                    }else if($key == 12){
                        $x = 20;
                        $y = 190;   
                    }else if($key == 13){
                        $x = 150;
                        $y = 190;   
                    }else if($key == 14){
                        $x = 20;
                        $y = 280;   
                    }else if($key == 15){
                        $x = 150;
                        $y = 280;   
                    }else if($key == 16){
                        $x = 20;
                        $y = 300;   
                    }else if($key == 17){
                        $x = 150;
                        $y = 10;        
                    }else if($key == 18){
                        $x = 20;
                        $y = 100;   
                    }else if($key == 19){
                        $x = 150;
                        $y = 100;   
                    }else if($key == 20){
                        $x = 20;
                        $y = 190;   
                    }else if($key == 21){
                        $x = 150;
                        $y = 190;   
                    }else if($key == 22){
                        $x = 20;
                        $y = 280;   
                    }else if($key == 23){
                        $x = 150;
                        $y = 280;   
                    }else{
                        $x = 150;
                        $y = 10;
                    }                   
                }
                            
                if($key == 3){
                    $thirdKey = 3;
                }

                PDF::Image($image,$x,$y, 130, 90, '', '', '', false, 300, '', false, false, 0);
                if($FinanceData["Finance"]["stamp_show"] == 1){
                    if( ($key == 2) && ($lastPhoto == 2) ){
                        $lastPhoto = 3;
                        PDF::Image(public_path('image/st.jpg'), 40, 80, 40, 40, '', '', '', false, 300, 'C');
                    }else if(($thirdKey == 3) ){
                        PDF::Image(public_path('image/st.jpg'), 40, 80, 40, 40, '', '', '', false, 300, 'C');
                    }else if(($key == 1)){
                        PDF::Image(public_path('image/st.jpg'), 40, 80, 40, 40, '', '', '', false, 300, 'C');                        
                    }
                    if(in_array($key,$ll)){
                        PDF::Image(public_path('image/st.jpg'), 140, 260, 40, 40, '', '', '', false, 300, 'C');                      
                    }
                }
            }
        }
           $videos=json_decode($FinanceData['Finance']['videos'],true);
            if($videos!=null){
                    $video1_url="";
                    $video1="";
                    $video2_url="";
                    $video2="";
                    if(isset($videos[0])){
                        $video1_url='<td align="center"><a href="'.url("videos").'/'.$videos[0].'">Video 1</a></td>';
                        $video1='<td align="center"><img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl='.url("videos").'/'.$videos[0].'" title="Link to Google.com" /></td>';
                    }
                    if(isset($videos[1])){
                        $video2_url='<td align="center"><a href="'.url("videos").'/'.$videos[1].'">Video 2</a></td>';
                        $video2='<td align="center"><img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl='.url("videos").'/'.$videos[1].'" title="Link to Google.com" /></td>';

                    }
                    $htmll.='<br pagebreak="true" /><table>
                    <tr>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        '.$video1_url.$video2_url.'
                    </tr>
                    <tr>
                        '.$video1.$video2.'
                    </tr>      
                    </table>';            
            } 
        PDF::WriteHTML($htmll, true, false, false, false, ''); 

        $pdf_string = PDF::Output('pseudo.pdf', 'S');
        file_put_contents(public_path('finance/pdf/').$filename, $pdf_string);
        ob_end_flush();
        ob_end_clean();
        foreach ($imgtem as $key => $value) {
            unlink(public_path('tmp/').$value.$FinanceData['Finance']['id'].'destination.jpg');  
        }       
        return $filename;
    }
    public function compress($source, $destination, $quality) {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function today_report_excel()
    {
		$records=Finance::select('finances.*','valuations.name','users.name as created_by')->leftJoin('valuations','finances.valuation_by','=','valuations.id')->leftJoin('users','finances.user_id','=','users.id')->whereNotNull('finances.report_date')->whereDate('finances.created_at','=',date('Y-m-d'))->get();
        if($records->isEmpty()){
            return redirect()->back()->with('deleted','No Data For Export.');
        }
		
		$A1 = 'AUTOSWIFT FINVALE (AFV)';
		$K1 = 'EFFECTIVE FROM '.date('d-m-Y');
		$header = ['S.No.', 'Creation Date', 'Report Date', 'Inspection Date', 'Reference No', 'Application No', 'Staff', 'Created By', 'Valuation Initiated By', 'Financer Representative', 'Registration No', 'Make & Model', 'Finance Taken By', 'Place of Valuation', 'Total Amount', 'Received Amount', 'Remaining Amount'];
		foreach ($records as $key => $value) {
			$retRecords[$key]['s_no'] = (string)$key+1;
			$retRecords[$key]['created_at'] = $value->created_at->format('d-m-Y');
			$retRecords[$key]['report_date'] = date('d-m-Y', (int)$value->report_date);
			$retRecords[$key]['inspection_date'] = $value->inspection_date;
			$retRecords[$key]['reference_no'] = $value->reference_no;
			$retRecords[$key]['application_no'] = $value->application_no;
			$retRecords[$key]['staff_name'] = $value->staff_name;
			$retRecords[$key]['created_by'] = $value->created_by;
			$retRecords[$key]['name'] = $value->name;
			$retRecords[$key]['financer_representative'] = $value->financer_representative;
			$retRecords[$key]['registration_no'] = $value->registration_no;
			$retRecords[$key]['make_model'] = $value->make_model;
			$retRecords[$key]['financed_by'] = $value->financed_by;
			$retRecords[$key]['place_of_valuation'] = $value->place_of_valuation;
			$retRecords[$key]['total_amount'] = $value->total_amount;
			$retRecords[$key]['amount_paid'] = $value->amount_paid;
			$retRecords[$key]['remaining_amount'] = $value->remaining_amount;
		}	
		$nameOrTitle='Today\'s Reports '.date('d-m-Y');
		$cntHead = count($header)-1;
        $excel = new Export($retRecords, $header, date('d-m-Y'), $this->alphabet[$cntHead]);
        $excel->setRowHeight([1 => 20]);
        $excel->setFont(['A1:Z1265' =>'Arial']);
        $excel->setFontSize(['A1' => 14]);
        $excel->setBold(['A1:'.$this->alphabet[$cntHead].'1' => true]);
        $excel->setBackground(['A2:'.$this->alphabet[$cntHead].'2' => '92D050']);
        $excel->setMergeCells(['A1:'.$this->alphabet[$cntHead].'1']);
        $excel->setCellValues(['A1' => $nameOrTitle]);
        return Excel::download($excel, $nameOrTitle.'.xlsx');
    }
    
    public function get_duplicate(Request $request){
          if ($request->ajax()){
              $data = Finance::select('finances.*','valuations.name','users.name as created_by','duplicate_reasons.reason')->leftJoin('valuations','finances.valuation_by','=','valuations.id')->leftJoin('users','finances.user_id','=','users.id')->leftJoin('duplicate_reasons','finances.duplicate_reason','=','duplicate_reasons.id');
                if($request->registration_no){
                    $data->where('finances.registration_no','=',$request->registration_no);
                }
                if($request->chachees_number){
                    $data->where('finances.chachees_number','=',$request->chachees_number);
                }
                if($request->engine_number){
                    $data->where('finances.engine_number','=',$request->engine_number);
                }
                 $report=$data->get();
              return view('Reports.duplicate_record',compact('report'));
           }
    }
    public function multiple_delete(Request $request){
        if($request->ajax()){
            if($request->report){
                foreach ($request->report as  $item) {
                    $finance=Finance::findOrFail($item);
                    $data=$finance->toArray();
                    $data['updated_at']=date("Y-m-d h:i:s");
                    DB::table('deleted_record')->insert($data);
                    $finance->delete();
                }     
            }
            return $arr = array('status' => true,'action'=>'deleted','msg'=>'Reports Deleted Successfully');
        }
       
    }
    public function rejected_delete(Request $request){
        if($request->ajax()){
            if($request->report){
                foreach ($request->report as  $item) {
                    $finance=DB::table('reject_reports')->whereId($item)->first();
                    $data=(array)$finance;
                    unset($data['reject_reason']);
                    unset($data['rejected_by']);
                    $data['updated_at']=date("Y-m-d h:i:s");
                    DB::table('deleted_record')->insert($data);
                    DB::table('reject_reports')->delete($item);
                }     
            }
            return $arr = array('status' => true,'action'=>'deleted','msg'=>'Reports Deleted Successfully');
        }
    }
    public function update_deposit(Request $request,$id){
        if($request->ajax()){
            if($request->isMethod('put')){
                $finance=Finance::findOrFail($id);
                $finance->update($request->all());
                return $arr = array('status' => true,'action'=>'updated','msg'=>'Deposit Data updated Successfully');
            }
            $finance=Finance::select('amount','paid_person','paid_date')->whereId($id)->first();
            return $finance;
        }
    }
    public function report_reject(Request $request,$id){
        $finance=Finance::findOrFail($id);
        $reg=$finance->registration_no;
        $data=$finance->toArray();
        $data['reject_reason']=$request->reject_reason;
        $data['rejected_by']=Auth()->user()->name;
        $data['updated_at']=date("Y-m-d h:i:s");
        $data['created_at']=date("Y-m-d h:i:s");
        DB::table('reject_reports')->insert($data);
        $finance->delete();
        $firebaseToken = User::where('id','=',$data['user_id'])->pluck('firebase_id')->all();
        $body="Your Report Has Benn Report Rejected ! Registration No : ".$data['registration_no'];
        $title='Report Rejected';
        PushNotification::dispatch($firebaseToken,$body,$title);
        return redirect()->route('mobile_report')->with('added', 'Report Rejected Successfully ! Registration No - '.$reg);
    }
    public function reject_reports(Request $request){
      $data = DB::table('reject_reports')->select('reject_reports.*','valuations.name','users.name as submit_by')->leftJoin('valuations','reject_reports.valuation_by','=','valuations.id')->leftJoin('users','reject_reports.user_id','=','users.id')->orderBy('reject_reports.updated_at','DESC');
         if($request->ajax()){
             return Datatables::of($data)->addIndexColumn()->editColumn('updated_at', function($row){
                    return date('d-m-Y',strtotime($row->updated_at));         
                    })->addColumn('action',function($row){
                        return '<a href="" class="delete_report" id="'.$row->id.'" title="Delete"><i class="fa fa-trash"></i></a>
                                <a href="" title="Show" class="show_reason" id="'.$row->id.'"><i class="fa fa-eye"></i></a>
                                <a href="" class="restore_report"  id="'.$row->id.'" title="Restore"><i class="fa fa-undo"></i></a>
                                ';
                    })->rawColumns(['action'])->make(true);
         }
        return view('Reports.rejected_record');  
    }
    public function delete_rejected($finance){
        $fin=DB::table('reject_reports')->where('id','=',$finance)->get();
        $reg='';
        if($fin){
            $reg=$fin[0]->registration_no;
            $data = collect($fin)->map(function($x){ return (array) $x; })->toArray();
            unset($data[0]['reject_reason']);
            unset($data[0]['rejected_by']);
            $data[0]['updated_at']=date("Y-m-d h:i:s");
            DB::table('deleted_record')->insert($data);
            DB::table('reject_reports')->delete($finance);
        }
        return back()->with('deleted', 'Rejected Report has been deleted ! Registration No - '.$reg);
    }
    public function get_rejected_reason(Request $request,$finance){
        if($request->ajax()){
            $data=DB::table('reject_reports')->where('id','=',$finance)->first('reject_reason');
            if($data){
                 return $arr = array('status' => true,'action'=>'retrive','result'=>$data);
            }
            return $arr = array('status' =>  false,);
        }
    }
    public function multiple_delete_report(Request $request){
        if($request->ajax()){
            if($request->report){
                foreach ($request->report as  $item) {
                    DB::table('deleted_record')->delete($item);
                }     
            }
            return $arr = array('status' => true,'action'=>'deleted','msg'=>'Reports Deleted Successfully');
        }
    }
}