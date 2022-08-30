<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DOMPDF;
use App\Finance;
class Formpdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     private $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Finance::select('finances.*','valuations.name as valuationsname','declarations.note')->leftJoin('valuations','finances.valuation_by','=','valuations.id')->leftJoin('declarations','finances.notice','=','declarations.id')->where('finances.id','=',$this->id)->first();
        if(!$data){
            return false;
        }
        $left_tyer_quantity =json_decode($data['left_tyer_quantity']);
     $left_tyer_company =json_decode($data['left_tyer_company']);
     $left_quality= json_decode($data['left_quality']);
     $right_tyer_quantity=json_decode($data['right_tyer_quantity']);
     $right_tyer_company= json_decode($data['right_tyer_company']);
     $right_quality= json_decode($data['right_quality']);
     $left='';
   foreach ($left_tyer_quantity as $key => $value) 
   {   
        $ltq='&nbsp;';$ltc='&nbsp;';$lq='&nbsp;';
        if(isset($left_tyer_quantity[$key])){
            $ltq=$left_tyer_quantity[$key];
        }
        if(isset($left_tyer_company[$key])){
            $ltc=$left_tyer_company[$key];
        }
        if(isset($left_quality[$key])){
            $lq=$left_quality[$key];
        }
        $left.='<tr>
          <td>'.$ltq.'</td>
          <td>'.$ltc.'</td>
          <td>'.$lq.'</td>
          </tr>'; 
   }
   $right='';
   foreach ($right_tyer_quantity as $key => $value) 
   {     
         $rtq='&nbsp;';$rtc='&nbsp;';$rq='&nbsp;';
        if(isset($right_tyer_quantity[$key])){
            $rtq=$right_tyer_quantity[$key];
        }
        if(isset($right_tyer_company[$key])){
            $rtc=$right_tyer_company[$key];
        }
        if(isset($right_quality[$key])){
            $rq=$right_quality[$key];
        }   
        $right.='<tr>
          <td>'.$rtq.'</td>
          <td>'.$rtc.'</td>
          <td>'.$rq.'</td>
          </tr>'; 
   }
    $photo =json_decode($data['photo']);
    $phot='';
     if($photo){
         $i=0;
       foreach ($photo as $key => $value) {
            $i++;
           if($i==1){
               $phot.='<tr>';
              }
          $phot.='
                      <td style="margin-top:30px;">
                          <div style="width: 200px; height:200px; margin-top: 30px; margin-right:20px;">
                              <img src="'.url("/finance").'/'.$value.'" style="width: 100%; height:100%;">
                          </div>
                      </td>';
                 if($i==2){
                    $i=0;
                    $phot.='</tr>';
                 }
       }   
    }
   
   $html ='<html><head></head><body style="background-image:url('.url("image/autoswift.png").'); background-size:auto; background-repeat:no-repeat;">
          <div class="form-title" style="text-align:center;">
                  <table align="center" border="1" cellspacing="0" cellpadding="2">
                      <tr>
                          <td style="height:30px; padding:0 20px; font-size:18px;">
                              Registration No
                          </td>
                          <td style="height:30px; padding:0 20px; font-size:18px;">
                              '.$data["registration_no"].'
                          </td>
                      </tr>
                  </table>
                    <h2 style="margin-bottom: 5px;">TAB 1</h2>
                    <h2 style="margin:0;">GENERAL INFO</h2>
                 </div>
                 <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; margin-bottom: 0px; margin-top: 15px;"class="tab1-table">
                    <tbody>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Reference No.</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["refenence_no"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Company Name</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["valuationsname"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Financer Representative</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["financer_representative"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Inspection Date</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["inspection_date"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Place of Valuation</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["place_of_valuation"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Registration No</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["registration_no"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Make & Model</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["make_model"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Chassis No</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["chachees_number"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Engine No</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["engine_number"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">MM Reading(Kms/Hrs)</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["mm_reading"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Color</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["color"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Battery</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["battery"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Radiator</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["radiator"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Registered Owner</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["registerd_owner"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Finance Taken Name</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["financed_by"].'</td>
                       </tr>
                       <tr class="name-list">
                          <td style="height:30px; padding-left:20px; font-size:18px;">Mobile No.</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["mobile_no"].'</td>
                       </tr>
                    </tbody>
                 </table><div class="page-break" style="page-break-before:always"></div>
   
                 <div class="form-title" style="text-align:center;">
                    <h2 style="margin-bottom: 5px;">TAB 2</h2>
                 </div>
   
                  <h2 style="margin:0; border-bottom: 1px solid #000; display: inline-block;">INNER CONDITION</h2>
   
                 <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; margin-bottom: 0px; margin-top: 15px;" class="tab1-table">
                    
   
                    <tr>
                       <td style="height:30px; padding-left:20px; font-size:18px;">AC</td>
                       <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["ac"].'</td>
                    </tr>
                    <tr>
                       <td style="height:30px; padding-left:20px; font-size:18px;">POWER STEERING</td>
                       <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["power_steering"].'</td>
                    </tr>
                    <tr>
                       <td style="height:30px; padding-left:20px; font-size:18px;">POWER WINDOW</td>
                       <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["power_window"].'</td>
                    </tr>
                    <tr>
                       <td style="height:30px; padding-left:20px; font-size:18px;">AIR BAG</td>
                       <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["air_bag"].'</td>
                    </tr>
   
                 </table>
   
                 <h2 style="margin-top:30px; border-bottom: 1px solid #000; display: inline-block;">TYRES</h2>
   
                 <h3 style="margin-bottom: 5px;">Right Tyres</h3>
   
                 <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; margin-bottom: 0px; margin-top: 15px;" class="tab1-table">
                    
   
                      <tr>
                          <td style="height:30px; padding-left:20px; font-size:18px;">No of Tyres</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">Company Name</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">Tyres Quality</td>
                      </tr>
                      '.$left.'
                     
   
                 </table>
   
                 <h3 style="margin-bottom: 5px; margin-top: 50px;">Left Tyres</h3>
   
                 <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; margin-bottom: 0px; margin-top: 15px;" class="tab1-table">
                    
   
                      <tr>
                          <td style="height:30px; padding-left:20px; font-size:18px;">No of Tyres</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">Company Name</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">Tyres Quality</td>
                      </tr>
                     '.$right.'
   
                 </table>
   
                 <div class="page-break" style="page-break-before:always"></div>
   
                  <div class="form-title" style="text-align:center;">
                    <h2 style="margin-bottom: 5px;">TAB 3</h2>
                 </div>
   
                  <h2 style="margin:0; border-bottom: 1px solid #000; display: inline-block;">GENERAL COMMENT</h2>
                  <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; margin-bottom: 0px; margin-top: 15px;" class="tab1-table">
                       <tr>
                          <td style="padding:15px">'.$data["general_comment"].'</td>
                       </tr>
                  </table>
   
                  <h2 style="margin:0; margin-top: 50px; border-bottom: 1px solid #000; display: inline-block;">AMOUNT</h2>
                  <table border="1" cellspacing="0" cellpadding="2" style="width: 100%; margin-bottom: 0px; margin-top: 15px;" class="tab1-table">
                       <tr>
                          <td style="height:30px; padding-left:20px; font-size:18px;">TOTAL AMOUNT</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["total_amount"].'</td>
                       </tr>
                       <tr>
                          <td style="height:30px; padding-left:20px; font-size:18px;">PAID AMOUNT</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["amount_paid"].'</td>
                       </tr>
                       <tr>
                          <td style="height:30px; padding-left:20px; font-size:18px;">REMAINING AMOUNT</td>
                          <td style="height:30px; padding-left:20px; font-size:18px;">'.$data["remaining_amount"].'</td>
                       </tr>
                  </table>
   
   
                 <div class="form-title" style="text-align:center; margin-bottom:20px; margin-top:30px;">
                    <h2 style="margin-bottom: 5px;">TAB 4</h2>
                    <h2>CHASSIS AND SELFIE IMAGES</h2>
                 </div>
   
                  <table align="center">
                      <tr>
                          <td>
                              <div style="width: 250px; height:250px; margin-top: 20px; margin-right:20px;">
                                  <img src="'.url("/finance").'/'.$data["chachees_number_photo"].'" style="width: 100%;">
                              </div>
                          </td>
                          <td>
                              <div style="width: 250px; height:250px; margin-top: 20px; margin-right:20px;">
                                  <img src="'.url("/finance").'/'.$data["selfie"].'" style="width: 100%;">
                              </div>
                          </td>
                      </tr>s
                  </table>
   
                 <div class="page-break" style="page-break-before:always"></div>
   
                 <div class="form-title" style="text-align:center; margin-bottom:30px;">
                    <h2 style="margin-bottom: 5px;">TAB 5</h2>
                    <h2>VEHICLE & DOCUMENT IMAGES</h2>
                 </div>
   
                 <table align="center">
                          '.$phot.'
                      </body></html>';
       $pdf = DOMPDF::loadHTML($html);
       $filename=$this->id.".pdf";
       $data->form_pdf=$filename;
       $data->save();
       $pdf->save(public_path('finance/form_pdf/'.$filename));
       return  true;   
    }
}
