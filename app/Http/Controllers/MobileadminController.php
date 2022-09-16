<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Finance;
use App\User;
use App\UserNotification;
use DB;
use DataTables;
use Image;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
class MobileadminController extends Controller
{
    public function Home()
    {	
    	
    	$pending=Finance::join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','=',0)->where('mobile_data','=',1)->count();
        $approve=Finance::join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','=',1)->where('mobile_data','=',1)->count();
        $complete=Finance::join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','=',2)->where('mobile_data','=',1)->count();
        $rejected=DB::table('reject_reports')->join('users','reject_reports.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('mobile_data','=',1)->count();
        $all=array('pending'=>$pending,'approve'=>$approve,'complete'=>$complete,'rejected'=>$rejected);
        $pending=Finance::join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','=',0)->whereDate('finances.created_at',date('Y-m-d'))->where('mobile_data','=',1)->count();
        $complete=Finance::join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','=',2)->whereDate('finances.created_at',date('Y-m-d'))->where('mobile_data','=',1)->count();
        $daily=array('pending'=>$pending,'complete'=>$complete);
        $pending=Finance::join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','=',0)->whereMonth('finances.created_at',date('m'))->whereYear('finances.created_at',date('Y'))->where('mobile_data','=',1)->count();
        $complete=Finance::join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','=',2)->where('mobile_data','=',1)->whereMonth('finances.created_at',date('m'))->whereYear('finances.created_at',date('Y'))->count();
        $month=array('pending'=>$pending,'complete'=>$complete);
        $date = \Carbon\Carbon::today()->subDays(365);
        $d=$date->format('d')-1;
        $date=date('Y-m-d', strtotime('-'.$d.' day', strtotime($date)));
        $reports=Finance::select(DB::Raw('COUNT(*) as count,Month(finances.created_at) as month'))->join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('finances.created_at','>=',$date)->groupBy(DB::Raw("DATE_FORMAT(finances.created_at, '%Y-%m')"))->where('mobile_data','=',1)->get();
    	return View('Admin.index',compact('all','daily','month','reports'));
    }
    public function mobile_executive(){
        $user=User::where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->get();
      
        return View('Admin.mobile_executive',compact('user'));
    }
    public function reports(Request $request){
        if($request->ajax()){
             $data=Finance::select('finances.*','users.name')->join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('mobile_data','=',1)->orderBy('finances.id','desc');
            if($request->status=='complete'){
                $data=$data->where('process','=',2)->get();
            }
            elseif($request->status=='approve'){
               $data=$data->where('process','=',1)->get();
            }else{
                $data=$data->where('process','=',0)->get();
            }
            return Datatables::of($data)
                    ->addIndexColumn()->editColumn('report_date', function($row){
                       if($row->report_date!=Null && $row->report_date!=''){
                           return date('d-m-Y',(int)$row->report_date); 
                       }else{
                        return null;
                       }
                   })->make(true);
        }
        return  View('Admin.reports');
    }
    public function rejected_reports(Request $request){
        if($request->ajax()){
         $data=DB::table('reject_reports')->select('reject_reports.*','users.name')->join('users','reject_reports.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->orderBy('reject_reports.updated_at','asc')->where('mobile_data','=',1)->get();
        return Datatables::of($data)
                ->addIndexColumn()->editColumn('report_date', function($row){
                   if($row->report_date!=Null && $row->report_date!=''){
                       return date('d-m-Y',(int)$row->report_date); 
                   }else{
                    return null;
                   }
               })->editColumn('updated_at', function($row){
                     return date('d-m-Y',strtotime($row->updated_at));
               })->make(true);
        }
         return  View('Admin.rejected_reports');
       
    }
    public function notification(){
        $mobile_executive=User::where('role','=',4)->where('status','=','active')->where('comp_id','=',Auth()->user()->comp_id)->orderBy('name','ASC')->pluck('name','id');
        $notification=UserNotification::where('sender_id','=',Auth()->id())->latest()->get();
        return View('Admin.notification',compact('mobile_executive','notification'));
    }
    public function send_notification(Request $request){
        $input=$request->all();
        $input['sender_id']=Auth()->id();
        $data = UserNotification::create($input);
        $data=$data->save();
        if($data){
            return redirect()->back()
                        ->with('success','Notification Has been Submited.');
        }
        return redirect()->back()
                        ->with('error','Somthing Went Wrong');
    }
    public function profile_image(Request $request){
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
    public function make_reports_excel(Request $request){
      /* return $request->all();*/
       $d1=$request->s_date;
       $d2=$request->e_date;
        $approve=Finance::select('finances.*','users.name as excutive_name','users.username','users.pass1','users.mobile_number','valuations.name as valuation_name','states.name as state_name','areas.name as area_name')->join('users','finances.reference_no','like',DB::raw("CONCAT(users.employee_id,'%')"))->where('users.role','=',4)->where('comp_id','=',Auth()->user()->comp_id)->where('process','!=',0)->leftjoin('valuations','valuations.id','=','finances.valuation_by')->leftjoin('areas','areas.id','=','users.area_id')->leftjoin('states','areas.state_id','=','states.id')->whereBetween('finances.report_date',[strtotime($d1),strtotime($d2)])->where('mobile_data','=',1)->orderBy('finances.report_date','asc')->get();
        if($approve->isEmpty()){
          return redirect()->back()
                        ->with('error','No Data to Exporte.');
        }
        $this->generate_excel($approve,$d1,$d2);
    }
    private function generate_excel($rows,$d1,$d2){
        $valuation_by=$rows[0]->valuation_name;  
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

        $sheet->setTitle('Valuation Record');
        
        
        $sheet->mergeCells('A1:O1');
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' =>Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A1','"'.$valuation_by.'"');
        $sheet->getStyle('A1')->applyFromArray($styleArray);
        $sheet->mergeCells('A2:O2');
        $styleArray = array(
            'font'  => array(
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' =>Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A2', '('.$d1.' To '.$d2.')');
        $sheet->getStyle('A2')->applyFromArray($styleArray);

        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' =>Alignment::HORIZONTAL_CENTER,
                ));

       
        // OUTPUT
        

        $styleArray = array(
            'font'  => array(
                'size'  => 11,
                'name'  => 'Calibri',
            ),'alignment' => array(
                    'vertical' =>Alignment::VERTICAL_TOP,
                ));
        $sheet->getStyle('A4:O4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(12);
        $sheet->getColumnDimension('O')->setWidth(12);



        $sheet->setCellValue('A4', 'S.No.');
        $sheet->setCellValue('B4', 'State');
        $sheet->setCellValue('C4', 'City');
        $sheet->setCellValue('D4', 'Inspection  Date');
        $sheet->setCellValue('E4', 'Completed Date');
        $sheet->setCellValue('F4', 'Application No.');
        $sheet->setCellValue('G4', 'Financer Rep');
        $sheet->setCellValue('H4', 'Registration No.');
        $sheet->setCellValue('I4', 'Make & Model');
        $sheet->setCellValue('J4', 'Finance Taken By');
        $sheet->setCellValue('K4', 'Place');
        $sheet->setCellValue('L4', 'Link');
        $sheet->setCellValue('M4', 'Executive Name');
        $sheet->setCellValue('N4', 'Employee ID');
        $sheet->setCellValue('O4', 'Mobile No.');
        $i=5;
        $j=1;
        $total=0;
        foreach ($rows  as $key => $value) {

            $sheet->getRowDimension($i)->setRowHeight(50);
            $sheet->setCellValue('A'.$i,$j);
            $sheet->setCellValue('B'.$i, $value['state_name']);
            $sheet->setCellValue('C'.$i, $value['area_name']);
            $sheet->setCellValue('D'.$i, $value['inspection_date']);
            $sheet->setCellValue('E'.$i, date('d-m-Y', (int)$value['report_date']));
            $sheet->setCellValue('F'.$i, $value['application_no']);
            $sheet->setCellValue('G'.$i, $value['financer_representative']);
            $sheet->setCellValue('H'.$i, $value['registration_no']);
            $sheet->setCellValue('I'.$i, $value['make_model']);
            $sheet->setCellValue('J'.$i, $value['financed_by']);
            $sheet->setCellValue('K'.$i, $value['place_of_valuation']);
            $sheet->setCellValue('L'.$i, asset('/finance/pdf/').'/'.$value['pdf_file']);
            $sheet->setCellValue('M'.$i, $value['excutive_name']);
            $sheet->setCellValue('N'.$i, $value['username']);
            $sheet->setCellValue('O'.$i, $value['mobile_number']);
            $i++;
            $j++;
        }
        $spreadsheet->getActiveSheet()->getStyle('A4:O'.$i)
            ->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:O'.$i)->applyFromArray($styleArray);
       

        $sheet->getStyle('A'.$i)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' =>Alignment::HORIZONTAL_CENTER,)));
        $sheet->getStyle('O'.$i)->applyFromArray(array('font'  => array('bold'  => true)));

        
        $il=$i-1;
        $ilx=$i+3;
        
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
            ),'alignment' => array('horizontal' =>Alignment::HORIZONTAL_LEFT,),
        );
        for ($i=4; $i <= $il; $i++) { 
            $sheet->getStyle('A'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('B'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('C'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('E'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('F'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('G'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('I'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('J'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('K'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('L'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('M'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('N'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('O'.$i)->applyFromArray($styleArray);
        }
        
        $writer = new Xlsx($spreadsheet);
        $name='Valuation Record_'.$d1.'_to_'.$d2.'.xlsx';
        header('Content-type: application/vnd.xlsx');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        $writer->save('php://output');
		exit;
        return true;
    }
}
