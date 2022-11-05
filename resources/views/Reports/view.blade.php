@extends('layouts.header')
@section('title', 'Finance View')
@section('style')
<style type="text/css">
        .loading_op{
            opacity:0;
        }
      .horizontal-menu.navbar-floating:not(.blank-page) .app-content
    {
      padding:0!important;
    }
        td
        {
            color:#000!important;
            text-transform: capitalize;

        }
        th
        {
            color:#000!important;
            text-transform: capitalize;
			text-align: left;
        }

    </style>
@endsection
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Finance Detail</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> All Finance Detail
               </li>
                <span style="float:right;"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <div class="buttons" style="padding:0 0 15px;" id="commn_button">
           @if($finance->form_pdf)
           <a href="{{asset('finance/form_pdf/'.$finance->form_pdf)}}" target="_blank"><button type="submit" class="btn btn-primary">Mobile PDF</button></a>
           @endif
           <a href="javascript:generatepdf()"><button type="submit" class="btn btn-primary">Generate PDF</button></a>
           <a href="javascript:generatezip()"><button type="submit" class="btn btn-primary">Zip Photo</button></a>
           <a href="javascript:printreport()"><button type="submit" class="btn btn-primary"> Print </button></a>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
       <div class="row" id="printreport">
               <div class="col-md-12">
                  <div class="card">
                     <div class="col-lg-12">
                        <br>
                        <div class="heading" style="border-radius: 15px; text-align:center; border:1px solid #e2d7d7; padding:30px;">
                           <span style="font-size:30px;" id="authorizer_name">{{$header->authorizer_name}} </span>
                           <span class="short" id="authorizer_education">{{$header->authorizer_education}}</span>
                           <hr width="25%;" style="">
                           <span id="authorizer_designation">{{$header->authorizer_designation}}</span>
                        </div>
                        <h2 style="padding:20px;"> Valuation Report:- Superadmin </h2>
                        <div class="card" style="border-radius: 15px; border:1px solid #e2d7d7;">
                           <div class="table-responsive">
                              <table class="table table-bordered table-hover table-striped" border="1" width="100%" >
                                 <thead>
                                    <tr>
                                       <th colspan="2">Reference No. </th>
                                       <th colspan="" id="reference_no">{{$finance->reference_no}}</th>
                                       <th colspan="">Application No. </th>
                                       <th colspan="" id="application_no">{{$finance->application_no}}</th>
                                       <th colspan="">Staff Name </th>
                                       <th colspan="" id="staff_name">{{$finance->staff_name}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2">Valuation Initiated By </td>
                                       <td colspan="6" id="valuation_by">{{$finance->valuation?$finance->valuation->name:''}}</td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">Financer Representative </td>
                                       <td colspan="6" id="financer_representative">{{$finance->financer_representative}}</td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">Place of Valuation </td>
                                       <td colspan="6" id="place_of_valuation">{{$finance->place_of_valuation}}</td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">Owner Mobile Number</td>
                                       <td colspan="6" id="mobile_no">{{$finance->mobile_no}}</td>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Registration No.</strong> </td>
                                       <th colspan="2" id="registration_no">{{$finance->registration_no}}</th>
                                       <td colspan="2"><strong>Report Date</strong> </td>
                                       <th colspan="2" id="report_date">{{date('d-m-Y',$finance->report_date)}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Make &amp; Model</strong> </td>
                                       <th colspan="2" id="make_model">{{$finance->make_model}}</th>
                                       <td colspan="2"><strong>Inspection Date</strong> </td>
                                       <th colspan="2" id="inspection_date">{{$finance->inspection_date}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Chassis No.</strong> </td>
                                       <th colspan="2" id="chachees_number">{{$finance->chachees_number}}</th>
                                       <td colspan="2"><strong>Registration Date</strong> </td>
                                       <th colspan="2" id="registration_date">{{$finance->registration_date}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Engine No.</strong> </td>
                                       <th colspan="2" id="engine_number">{{$finance->engine_number}}</th>
                                       <td colspan="2"><strong>Colour</strong> </td>
                                       <th colspan="2" id="color">{{$finance->color}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Registered Owner</strong> </td>
                                       <th colspan="2" id="registerd_owner">{{$finance->registerd_owner}}</th>
                                       <td colspan="2"><strong>Seating Capacity</strong> </td>
                                       <th colspan="2" id="seating_capacity">{{$finance->seating_capacity}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Finance Taken By</strong> </td>
                                       <th colspan="2" id="financed_by">{{$finance->financed_by}}</th>
                                       <td colspan="2"><strong>Regd. Laden Wt.(Kg)</strong> </td>
                                       <th colspan="2" id="laden_wt">{{$finance->laden_wt}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Hypothecation</strong> </td>
                                       <th colspan="2" id="hypothecation">{{$finance->hypothecation}}</th>
                                       <td colspan="2"><strong>Regd. Unladen Wt.(Kg)</strong> </td>
                                       <th colspan="2" id="unladen_wt">{{$finance->unladen_wt}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Tyre</strong> </td>
                                       <th colspan="2" id="tyres">{{$finance->tyres}}</th>
                                       <td colspan="2"><strong>Fuel Used</strong> </td>
                                       <th colspan="2" id="fule_used">{{$finance->fule_used}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Policy No.</strong> </td>
                                       <th colspan="2" id="policy_no">{{$finance->policy_no}}</th>
                                       <td colspan="2"><strong>MM Reading (Kms/Hrs)</strong> </td>
                                       <th colspan="2" id="mm_reading">{{$finance->mm_reading}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Validity</strong> </td>
                                       <th colspan="2" id="Validity">{{$finance->validity}}</th>
                                       <td colspan="2"><strong>Battery</strong> </td>
                                       <th colspan="2" id="battery">{{$finance->battery}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Policy Type</strong> </td>
                                       <th colspan="2" id="policy_type">{{$finance->policy_type}}</th>
                                       <td colspan="2"><strong>Radiator</strong> </td>
                                       <th colspan="2" id="radiator">{{$finance->radiator}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>SUM Insured(IDV)</strong> </td>
                                       <th colspan="2" id="sum_insured">{{$finance->sum_insured}}</th>
                                       <td colspan="2"><strong>AC</strong> </td>
                                       <th colspan="2" id="ac">{{ucfirst($finance->ac)}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Owner in Policy</strong> </td>
                                       <th colspan="2" id="owner_in_policy">{{$finance->owner_in_policy}}</th>
                                       <td colspan="2"><strong>Stereo</strong> </td>
                                       <th colspan="2" id="steereo">{{ucfirst($finance->steereo)}}</th>
                                    </tr>
                                    <tr>
                                    <td colspan="2"><strong>Tax Paid Upto</strong> </td> 
                                    <th colspan="2" id="tax_paid">{{$finance->tax_paid}}</th>  
                                    <td colspan="2"><strong>Power Steering</strong> </td>
                                    <th colspan="2" id="power_steering">{{ucfirst($finance->power_steering)}}</th>
                                </tr>
                                    <tr>
                                       <td colspan="2"><strong>Overall Condition Of Vehicle</strong> </td>
                                       <th colspan="2" id="owner_serial_number">{{$finance->owner_serial_number}}</th>
                                       <td colspan="2"><strong>Power Window</strong> </td>
                                       <th colspan="2" id="power_window">{{ucfirst($finance->power_window)}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Whether Major Accident</strong> </td>
                                       <th colspan="2" id="major_accidentented">{{$finance->major_accidentented}}</th>
                                       <td colspan="2"><strong>Air Bag</strong> </td>
                                       <th colspan="2" id="air_bag">{{ucfirst($finance->air_bag)}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Fair Market Price(Rs.)</strong> </td>
                                       <th colspan="6" id="fair_amount">{{$finance->fair_amount}}</th>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><strong>Location</strong> </td>
                                       <th colspan="2" id="location_address">{{$finance->location_address}}</th>
                                       <td colspan="2"><strong>Axis</strong> </td>
                                       <th colspan="2" id="axis">{{$finance->axis}}</th>
                                    </tr>
                                   
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        @php
                        $array_count=count(json_decode($finance->right_tyer_quantity));
                        @endphp
                        <div class="card" style="border-radius: 15px; border:1px solid #e2d7d7;">
                           <div id="quantity">
                              <table class="table table-bordered table-hover table-striped" border="1" width="100%">
                                 <tbody id=rldata>
                                    <tr>
                                       <th class="tg-us36" rowspan="7">Right Tyre</th>
                                       <th class="tg-us36">Quantity</th>
                                       <th class="tg-us36">Company</th>
                                       <th class="tg-us36">Percentage(%)</th>
                                       <th class="tg-us36" rowspan="7">Left Tyre</th>
                                       <th class="tg-us36">Quantity</th>
                                       <th class="tg-us36">Company</th>
                                       <th class="tg-us36">Percentage(%)</th>
                                    </tr>
                                    @php
                                    $right_tyer_quantity=json_decode($finance->right_tyer_quantity);
                                    $right_tyer_company=json_decode($finance->right_tyer_company);
                                    $right_quality=json_decode($finance->right_quality);

                                    $left_tyer_quantity=json_decode($finance->right_tyer_quantity);
                                    $left_tyer_company=json_decode($finance->right_tyer_quantity);
                                    $left_quality=json_decode($finance->left_quality);
                                     @endphp
                                    @for($i=0;$i<$array_count;$i++)
                                      <tr>
                                         <th class="tg-us36">{{isset($right_tyer_quantity[$i])?$right_tyer_quantity[$i]:''}}</th>
                                         <th class="tg-us36">{{isset($right_tyer_company[$i])?$right_tyer_company[$i]:''}}</th>
                                         <th class="tg-us36">{{isset($right_quality[$i])?$right_quality[$i]:''}}</th>
                                         <th class="tg-us36">{{isset($left_tyer_quantity[$i])?$left_tyer_quantity[$i]:''}}</th>
                                         <th class="tg-us36">{{isset($left_tyer_company[$i])?$left_tyer_company[$i]:''}}</th>
                                         <th class="tg-us36">{{isset($left_quality[$i])?$left_quality[$i]:''}}</th>
                                      </tr>
                                     @endfor
                                   
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        
                        <div class="card" style="border-radius: 15px; border:1px solid #e2d7d7;">
                           <table id="comment" class="table table-bordered table-hover table-striped" border="1" width="100%">
                              <tbody>
                                 <tr>
                                    <td><strong>Engine Conditition </strong></td>
                                    <td><strong>Cooling &amp; Exhaust System</strong></td>
                                    <td><strong>Suspension System</strong></td>
                                    <td><strong>Electrical System</strong></td>
                                    <td><strong>Wheel &amp; System</strong></td>
                                    <td><strong>Chassis</strong></td>
                                    <td><strong>Cabin &amp; Body Ext.</strong></td>
                                    <td><strong>Condition of Interiors</strong></td>
                                    <td><strong>Glasses</strong></td>
                                    <td><strong>Paint</strong></td>
                                    <td><strong>Damage / Repair</strong></td>
                                 </tr>
                                 <tr>
                                    <td id="c_engine_condition">{{ucfirst($finance->c_engine_condition)}}</td>
                                    <td id="c_cooling_system">{{ucfirst($finance->c_cooling_system)}}</td>
                                    <td id="c_suspension_system">{{ucfirst($finance->c_suspension_system)}}</td>
                                    <td id="c_electrical_system">{{ucfirst($finance->c_electrical_system)}}</td>
                                    <td id="c_wheel">{{ucfirst($finance->c_wheel)}}</td>
                                    <td id="c_chassis">{{ucfirst($finance->c_chassis)}}</td>
                                     <td id="c_cabin">{{ucfirst($finance->c_cabin)}}</td>
                                     <td id="c_condition_of_interiors">{{ucfirst($finance->c_condition_of_interiors)}}</td>
                                     <td id="c_glass">{{ucfirst($finance->c_glass)}}</td>
                                     <td id="c_paint">{{ucfirst($finance->c_paint)}}</td>
                                     <td id="c_damage">{{ucfirst($finance->c_damage)}}</td>
                                     
                                 </tr>
                                 
                              </tbody>
                           </table>
                           
                           <table id="comment" class="table table-bordered table-hover table-striped" border="1" width="100%">
        
                               <tr>
                                   <td style="width:20%;"><strong>General Comment</strong></td>
                                   <td id="general_comment">{{$finance->general_comment}}</td>
                               </tr>
                               
                           </table>
                           
                            <table id="comment" class="table table-bordered table-hover table-striped" border="1" width="100%">
                               
                               <tr>

                                   <td style="width:20%;"><img src="{{env('APP_URL')}}/image/st.jpg"></td>
                                   <td>
                     <div style="width:300px; height:150px;"><img src="{{env('APP_URL')}}/finance/{{$finance->chachees_number_photo}}" id="chachees_number_photo" style="width:100%; height:100%;"></div>
                  </td>
                                   <td>
                     <div style="width:300px; height:150px;"><img src="{{env('APP_URL')}}/finance/{{$finance->selfie}}" id="selfie" style="width:100%; height:100%;"></div>
                   </td>
                               </tr>
                               
                           </table>
                        </div>
                        
                         <div class="card" style="border-radius: 15px; border:1px solid #e2d7d7; padding:20px;">
                             <div class="row" id="photo">
                              @php
                              $photo=json_decode($finance->photo);
                              @endphp
                              @if($finance->photo)
                              @foreach($photo as $item)
                                <div class="col-sm-2">
                                  <label style="margin-bottom: 15px; color:#333; font-weight: bold; padding-top: 15px;"> Photo: </label>
                                   <div style="width: 218px;height: 114px;"><img src="{{env('APP_URL')}}/finance/{{$item}}" style="max-width: 100%;max-height: 100%;"></div>
                                </div>
                              @endforeach
                              @endif  
                             </div>
                         </div>
                     </div>
                  </div>
       </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
   $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
   });
  function printreport()
    {
    var divToPrint=document.getElementById('printreport');
     var newWin=window.open('','Print-Window');
     newWin.document.open();
     newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
     newWin.document.close();
     setTimeout(function(){newWin.close();},0);
    }
function generatezip(){
   window.location.href = "{{route('make_zip',$finance->id)}}" ;
}
function generatepdf(){
   $.post("{{route('make_pdf')}}",{report_id:"{{$finance->id}}"},function(result){
     if (result.status == true) {
          toastr.success(result.msg, "success");
          window.open("{{asset('')}}/"+result.file, '_blank');
       } else {
          toastr.error(result.msg, "Error");
       }
   });
}

</script>
@endsection