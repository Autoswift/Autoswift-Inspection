@extends('layouts.header')
@section('title', 'Edit Report')
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('js/croppic/croppie.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/fancyBox/source/jquery.fancybox.css')}}">
<style type="text/css">
   ::placeholder {
   color: #000!important;
   opacity: 1; /* Firefox */
   font-size:16px!important;
   }
   .form-control
   {
   color:#000!important; 
   font-weight:bold!important;
   font-size:16px!important;
   }
   .row{
   font-weight:500;
   color:#000000;
   }
   .sortable { 
   list-style-type: none; 
   margin: 0; 
   padding: 0; 
   width: 100%; 
   }
   .sortable li { 
   margin: 3px 3px 3px 0; 
   padding: 1px; 
   float: left; 
   border: 0;
   background: none;
   }
   .sortable li img{
   width: 250px;
   height: 140px;
   }
   .photo-remove li
   {
   display: inline-block;
   margin: 3px 53px 3px 3px !important;
   }
   .approve-check
   {
   width: 30px;
   height: 30px;
   margin-top: 10px;
   }
   .form-control{
   color:black;
   font-weight: 500;
   }
   .loading_op{
   opacity:0;
   }
   .row{
   font-weight: bold;
   }  
   .content-header-left
   {
   top:12%!important;
   }
   .img-fluid{
    max-width: 100%;
    height: auto;
   }
   .form-control-position{
    top: 4px;
    right: 0;
    z-index: 2;
    display: block;
    width: 7.5rem;
    height: 7.5rem;
    line-height: 2.5rem;
    text-align: center;
    position: absolute;
   }
    #dp_recordmodle > .modal-lg{
      width: 90%!important;
   }
	ul{
		padding-inline-start: 0px;
	}
</style>
@endsection
@section('content')
<div id="page-wrapper" style="overflow-x: hidden;">
   <div class="container-fluid">
      @php 
      $role=Auth()->user()->role;
      @endphp
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Edit Report</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i>Edit Report
               </li>
               <span style="float:right;"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Back</a></span>
               @if($finance->pdf_file!=null && $finance->pdf_file!='')
              <span style="float:right;"><a class="openPdf" href="{{asset($finance->pdf_file)}}" style="color: #28c76f;margin-right: 30px;font-weight: 600;" target="_blank">Click to Open PDF<i class="fa fa-file-pdf-o"></i></a></span>
              @endif
              <span style="float:right;">Created At : {{date('d-m-Y h:i:s',strtotime($finance->created_at))}} | {{$finance->mobile_data?'Mobile':'Web'}} &nbsp;&nbsp;</span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
         @include('layouts.alert')
      </section>
      <form class="form" novalidate enctype="multipart/form-data" method="POST" id="addreport" action="{{route('report.update',$finance->id)}}">
         @csrf
         @method('PUT')
		 <select name="pdf" id="savepdf">
			<option value="">Save as Pdf</option>
			@foreach(config('global.pdf_types') as $pdf_type => $pdf_name)
				<optgroup label="{{ $pdf_name }}">
				@foreach($headers as $harr)
					<option value="{{ $harr->id.'***'.$pdf_type }}">{{ $harr->authorizer_name.' ('.$harr->report_heading.')' }}</option>
				@endforeach
				</optgroup>
			@endforeach
		 </select>
         <!--<button type="submit" class="btn mr-1 mb-1 waves-effect waves-light" style="color: #fff; background-color:#4839EB;" id="savepdf" name="pdf" value="pdf">Save as Pdf</button>-->
         <div class="row" style="padding: 30px 0 0 0 ;">
            <div class="col-md-4 col-12">
               <span>Reference No.</span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-group">
                  <div
                     class="form-label-group form-group position-relative has-icon-right"
                     >
                     <input type="text" id="reference_no"
                        class="form-control" name="reference_no"
                        placeholder="Reference No."
                        required readonly value="{{$finance->reference_no}}" style="background-color: rgb(147, 247, 147)";>
                     <div class="form-control-position">
                       <i class="fa fa-lock"></i>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Application No.</span>
            </div>
            <div class="col-md-5 col-12">
               <div
                  class="form-label-group form-group">
                  <input type="text" id="application_no"
                     class="form-control"
                     name="application_no"
                     placeholder="Application No."
                     id="application_no" data-validation-required-message="Please enter Application No" required value="{{$finance->application_no}}"@if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) readonly @endif>
                     @if($finance->report_date!=null && $finance->photo!=null && $finance->report_date!='' && $role==2)  
                     <div class="form-control-position">
                       <i class="fa fa-lock"></i>
                     </div>
                     @endif
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Inspection Requested By<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-label-group form-group form-group">
                  <select class="custom-select form-control" name="valuation_by" id="valuation_by" data-validation-required-message="Please select Valuation Initiated" @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) disabled @endif required>
                     <option value=''>Select Inspection Requested By</option>
                     @foreach($company as $key => $item)
                        <option value='{{$key}}' {{$key==$finance->valuation_by?'Selected':''}}>{{$item}}</option>
                     @endforeach
                  </select>
                   @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2)  
                     <div class="form-control-position">
                       <i class="fa fa-lock"></i>
                     </div>
                     @endif
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Executive Name<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="financer_representative"
                     class="form-control"
                     placeholder="Executive Name"
                     name="financer_representative" data-validation-required-message="Please enter Executive Name" value="{{$finance->financer_representative}}"  @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) readonly @endif required>
                      @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2)  
                     <div class="form-control-position">
                       <i class="fa fa-lock"></i>
                     </div>
                     @endif
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Place Of Inspection<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-label-group form-group">
                  <div class="form-label-group form-group">
                     <input type="text" id="place_of_valuation"
                        class="form-control"
                        name="place_of_valuation" 
                        placeholder="Place Of Inspection" data-validation-required-message="Please enter Place Of Valuation" value="{{$finance->place_of_valuation}}" required>
                     <div class="help-block"></div>
                  </div>
               </div>
            </div>
            <div class="col-md-12 col-12">
            </div>
            <div class="col-md-2 col-12">
               <span>Registration
               Number<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <div class="controls">
                     <input type="text" id="registration_no"
                        class="form-control"
                        name="registration_no"  
                        placeholder="Search Registration Number" required pattern="(([A-Za-z]){2,3}(|-)(?:[0-9]){1,2}(|-)(?:[A-Z0-9]){1}(|-)([0-9]){1,4})|(([A-Za-z]){2,3}(|-)([0-9]){1,4})" data-validation-required-message="Please enter Registration Number" maxlength="33" value="{{$finance->registration_no}}" @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) readonly @endif>
                        @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2)  
                           <div class="form-control-position">
                             <i class="fa fa-lock"></i>
                           </div>
                        @endif
                     <div class="help-block"></div>
                  </div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Report
               Date<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="report_date"
                     class="form-control pickadate"
                     name="report_date" 
                     placeholder="Report Date" data-validation-required-message="Please enter Report Date" maxlength="12" required value="@if($finance->report_date!=null && $finance->report_date!=''){{date('d-m-Y',$finance->report_date)}}@endif" @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) disabled @endif>
                      @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2)  
                           <div class="form-control-position">
                             <i class="fa fa-lock"></i>
                           </div>
                        @endif
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Make & Model<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="make_model"
                     class="form-control"
                     placeholder=" Search Make & Model"
                     name="make_model" data-validation-required-message="Please enter Make And Model" maxlength="33" required value="{{$finance->make_model}}">
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Inspection Date<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="inspection_date"
                     class="form-control pickadate"
                     name="inspection_date" 
                     placeholder="Inspection Date" data-validation-required-message="Please enter Inspection Date" maxlength="12" required value="{{$finance->inspection_date}}">
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Chassis Number<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="chachees_number"
                     class="form-control"
                     name="chachees_number" 
                     placeholder="Chassis Number" data-validation-required-message="Please enter Chassis Number" maxlength="33" value="{{$finance->chachees_number}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Registration Date<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="registration_date"
                     class="form-control pickadate"
                     name="registration_date" 
                     placeholder="Registration Date" data-validation-required-message="Please enter Registration Date" maxlength="50" value="{{$finance->registration_date}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Engine Number<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="engine_number"
                     class="form-control"
                     name="engine_number" 
                     placeholder="Engine Number" data-validation-required-message="Please enter Engine Number" maxlength="33" value="{{$finance->engine_number}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Colour<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="color"
                     class="form-control" name="color" 
                     placeholder="Colour" data-validation-required-message="Please enter Colour" maxlength="12" value="{{$finance->color}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Registered Owner<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="registerd_owner"
                     class="form-control"
                     name="registerd_owner" 
                     placeholder="Registered Owner" data-validation-required-message="Please enter Registered Owner" value="{{$finance->registerd_owner}}" maxlength="33" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Seating Capacity<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="seating_capacity"
                     class="form-control"
                     name="seating_capacity" 
                     placeholder="Seating Capacity" data-validation-required-message="Please enter Seating Capacity" value="{{$finance->seating_capacity}}" maxlength="12" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Borrower Name<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="financed_by"
                     class="form-control"
                     name="financed_by" 
                     placeholder="Borrower Name" data-validation-required-message="Please enter Finance Taken By"  value="{{$finance->financed_by}}" maxlength="33" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Regd. Laden Wt.(Kg) <span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="laden_wt"
                     class="form-control"
                     name="laden_wt" 
                     placeholder="Regd. Laden Wt.(kg)" data-validation-required-message="Please enter Regd. Laden Wt.(Kg)" maxlength="12" value="{{$finance->laden_wt}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Fuel Used<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                   {!! Form::select('fule_used',array("-"=>"-","DIESEL"=>"DIESEL","PETROL"=>"PETROL","PETROL+LPG"=>"PETROL+LPG","PETROL+CNG"=>"PETROL+CNG","CNG"=>"CNG","ELECTRICAL"=>"ELECTRICAL","OTHER"=>"OTHER"),$finance->fule_used, ['class' => 'custom-select form-control','id'=>"ac",'data-validation-required-message'=>"Please enter Fuel Used","placeholder"=>"Select Fuel
                        Used","maxlength"=>"33"]) !!}

                  
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Regd. Unladen Wt.(Kg)<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="unladen_wt"
                     class="form-control"
                     name="unladen_wt" 
                     placeholder="Regd. Unladen Wt.(kg)" data-validation-required-message="Please enter Regd. Unladen Wt.(Kg)" maxlength="12" value="{{$finance->unladen_wt}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Owner Serial Number<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="owner_serial_number"
                     class="form-control"
                     name="owner_serial_number" 
                     placeholder="Owner Serial Number" data-validation-required-message="Please enter Owner Serial Number" maxlength="12" value="{{$finance->owner_serial_number}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Cubic Capacity<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="cube_capacity"
                     class="form-control"
                     name="cube_capacity" 
                     placeholder="Cubic Capacity" data-validation-required-message="Please enter Cubic Capacity" maxlength="12" value="{{$finance->cube_capacity}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Tax</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group">
                  <input type="text" id="tax_paid"
                     class="form-control" name="tax_paid" 
                     placeholder="Tax" data-validation-required-message="Please enter Tax"  maxlength="33" value="{{$finance->tax_paid}}" required value="-">
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>MM Reading(Kms/Hrs)<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="mm_reading"
                     class="form-control" name="mm_reading" 
                     placeholder="MM Reading(Kms/Hrs)" data-validation-required-message="Please enter MM Reading(Kms/Hrs)" maxlength="12" value="{{$finance->mm_reading}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Hypothecation<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="hypothecation"
                     class="form-control"
                     name="hypothecation" 
                     placeholder="Hypothecation" data-validation-required-message="Please enter Hypothecation" maxlength="33" value="{{$finance->hypothecation}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Battery<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="battery"
                     class="form-control" name="battery" 
                     placeholder="Battery" data-validation-required-message="Please enter Battery" maxlength="12" value="{{$finance->battery}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Policy Type & No.</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="policy_no"
                     class="form-control" name="policy_no" 
                     placeholder="Policy Type & No." value="-" data-validation-required-message="Please enter Policy Type & No." maxlength="33" value="{{$finance->policy_no}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Radiator<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="radiator"
                     class="form-control" name="radiator" 
                     placeholder="Radiator" data-validation-required-message="Please enter Radiator" maxlength="12" value="{{$finance->radiator}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Validity</span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group ">
                  <input type="text" id="validity"
                     class="form-control" name="validity" 
                     placeholder="Validity" value="-" data-validation-required-message="Please enter Validity" maxlength="33" value="{{$finance->validity}}" required>
                  <div class="help-block"></div>
               </div>
            </div>

            <div class="col-md-2 col-12">
               <span>AC<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12"> 
               <div class="form-label-group form-group">
                  {!! Form::select('ac',array("-"=>"-","yes"=>"Yes","no"=>"No"),$finance->ac,['class'=> 'custom-select form-control','id'=>"Ac",'data-validation-required-message'=>"Please Select Ac","placeholder"=>"Select Ac"]) !!}
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Permit</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="policy_type"
                     class="form-control"
                     name="policy_type" 
                     placeholder="Permit" value="-" data-validation-required-message="Please enter Permit" maxlength="33" value="{{$finance->policy_type}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Power Steering<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  {!! Form::select('item_id',array("-"=>"-","yes"=>"Yes","no"=>"No"),$finance->power_steering, ['class' => 'custom-select form-control','id'=>"power_steering",'data-validation-required-message'=>"Please enter Power Steering","placeholder"=>"Select Power
                        Steering"]) !!}
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Fitness</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="owner_in_policy"
                     class="form-control"
                     name="owner_in_policy" 
                     placeholder="Fitness" value="-" data-validation-required-message="Please enter Fitness" maxlength="33" value="{{$finance->owner_in_policy}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Power Window<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                   {!! Form::select('power_window',array("-"=>"-","yes"=>"Yes","no"=>"No"),$finance->power_window, ['class' => 'custom-select form-control','id'=>"power_window",'data-validation-required-message'=>"Please enter Power Window","placeholder"=>"Select Power
                        Window"]) !!}
                 
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Sum Insured(IDV)</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="sum_insured"
                     class="form-control"
                     name="sum_insured" 
                     placeholder="Sum Insured(IDV)" value="-" data-validation-required-message="Please enter Sum Insured(IDV)" maxlength="33" value="{{$finance->sum_insured}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Air Bag<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                   {!! Form::select('air_bag',array("-"=>"-","yes"=>"Yes","no"=>"No"),$finance->air_bag, ['class' => 'custom-select form-control','id'=>"air_bag",'data-validation-required-message'=>"Please Select Air
                        Bag","placeholder"=>"Select Air
                        Bag"]) !!}
                 
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-12 col-12">
               &nbsp;
               @php
                $left_tyer_quantity=json_decode($finance->left_tyer_quantity);
                $left_tyer_company=json_decode($finance->left_tyer_company);
                $left_quality=json_decode($finance->left_quality);

                $right_tyer_quantity=json_decode($finance->right_tyer_quantity);
                $right_tyer_company=json_decode($finance->right_tyer_company);
                $right_quality=json_decode($finance->right_quality);
               @endphp
            </div>
            <div class="col-md-2 col-12" style="margin-top: 70px">
               <h4 class="card-title">Right Side Tyres</h4>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <div class="card-header">
                  </div>
                  <div class="card-header"></div>
                  <div class="table-responsive ">
                     <table class="table-control">
                        <thead>
                           <tr>
                              <th>Quantity</th>
                              <th>Company</th>
                              <th>Percentage(%)</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"
                                 data-validation-required-message="Please enter Quantity" value="@if (isset($right_tyer_quantity[0])) {{$right_tyer_quantity[0]}} @endif" required>
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"  value="@if (isset($right_tyer_company[0])) {{$right_tyer_company[0]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"  value="@if (isset($right_quality[0])) {{$right_quality[0]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"  value="@if (isset($right_tyer_quantity[1])) {{$right_tyer_quantity[1]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"  value="@if (isset($right_tyer_company[1])) {{$right_tyer_company[1]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"  value="@if (isset($right_quality[1])) {{$right_quality[1]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"  value="@if (isset($right_tyer_quantity[2])) {{$right_tyer_quantity[2]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"  value="@if (isset($right_tyer_company[2])) {{$right_tyer_company[2]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"  value="@if (isset($right_quality[2])) {{$right_quality[2]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"  value="@if (isset($right_tyer_quantity[3])) {{$right_tyer_quantity[3]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"  value="@if (isset($right_tyer_company[3])) {{$right_tyer_company[3]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"  value="@if (isset($right_quality[3])) {{$right_quality[3]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"  value="@if (isset($right_tyer_quantity[4])) {{$right_tyer_quantity[4]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"  value="@if (isset($right_tyer_company[4])) {{$right_tyer_company[4]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"  value="@if (isset($right_quality[4])) {{$right_quality[4]}} @endif"
                                 >
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="help-block"></div>
                  </div>
               </div>
            </div>

            <div class="col-md-2 col-12" style="margin-top: 70px">
               <h4 class="card-title">Left Side Tyres</h4>
            </div>
            <div class="col-md-4 col-12">
               <div class="card-header">
               </div>
               <div class="card-header"></div>
               <div class="form-label-group form-group">
                  <div class="table-responsive">
                     <table class="table-control">
                        <thead>
                           <tr>
                              <th>Quantity</th>
                              <th>Company</th>
                              <th>Percentage(%)</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]"
                                 data-validation-required-message="Please enter Quantity" value="@if (isset($left_tyer_quantity[0])) {{$left_tyer_quantity[0]}} @endif" required>
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]" value="@if (isset($left_tyer_company[0])) {{$left_tyer_company[0]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]" value="@if (isset($left_quality[0])) {{$left_quality[0]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]" value="@if (isset($left_tyer_quantity[1])) {{$left_tyer_quantity[1]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]" value="@if (isset($left_tyer_company[1])) {{$left_tyer_company[1]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]" value="@if (isset($left_quality[1])) {{$left_quality[1]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]" value="@if (isset($left_tyer_quantity[2])) {{$left_tyer_quantity[2]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]" value="@if (isset($left_tyer_company[2])) {{$left_tyer_company[2]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]" value="@if (isset($left_quality[2])) {{$left_quality[2]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]" value="@if (isset($left_tyer_quantity[3])) {{$left_tyer_quantity[3]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]" value="@if (isset($left_tyer_company[3])) {{$left_tyer_company[3]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]" value="@if (isset($left_quality[3])) {{$left_quality[3]}} @endif"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]" value="@if (isset($left_tyer_quantity[4])) {{$left_tyer_quantity[4]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]" value="@if (isset($left_tyer_company[4])) {{$left_tyer_company[4]}} @endif"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]" value="@if (isset($left_quality[4])) {{$left_quality[4]}} @endif"
                                 >
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="help-block"></div>
                  </div>
               </div>
            </div>
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="engineCondition-column">Engine Condition</label>
                   {!! Form::select('c_engine_condition',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_engine_condition, ['class' => 'custom-select form-control','id'=>"c_engine_condition"]) !!}
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="coolingExhaust-column">Cooling System</label>
                   {!! Form::select('c_cooling_system',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_cooling_system, ['class' => 'custom-select form-control','id'=>"c_cooling_system"]) !!}
                  
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="suspension-column">Suspension System</label>
                   {!! Form::select('c_suspension_system',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_suspension_system, ['class' => 'custom-select form-control','id'=>"c_suspension_system"]) !!}
                
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="electrical-column">Electrical System</label>
                   {!! Form::select('c_electrical_system',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_electrical_system, ['class' => 'custom-select form-control','id'=>"c_electrical_system"]) !!}
                 
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="wheelTyres-column">Tyres Rating</label>
                   {!! Form::select('c_wheel',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_wheel, ['class' => 'custom-select form-control','id'=>"c_wheel"]) !!}
                 
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="chassis-column">Chassis</label>
                   {!! Form::select('c_chassis',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_chassis, ['class' => 'custom-select form-control','id'=>"c_chassis"]) !!}
                  
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="cabinBody-column">Cabin & Exterior</label>
                   {!! Form::select('c_cabin',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_cabin, ['class' => 'custom-select form-control','id'=>"c_cabin"]) !!}
                 
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="conditionInterior-column">Interior</label>
                   {!! Form::select('c_condition_of_interiors',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_condition_of_interiors, ['class' => 'custom-select form-control','id'=>"c_condition_of_interiors"]) !!}
                 
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="">Glasses</label>
                   {!! Form::select('c_glass',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_glass, ['class' => 'custom-select form-control','id'=>"c_glass"]) !!}
                 
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="">Paint</label>
                   {!! Form::select('c_paint',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->c_paint, ['class' => 'custom-select form-control','id'=>"c_paint"]) !!}
                 
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="">Vehicle Overall Rating</label>
                   {!! Form::select('overall_rating',array("good"=>"Good","average"=>"Average","poor"=>"Poor"),$finance->overall_rating, ['class' => 'custom-select form-control','id'=>"overall_rating"]) !!}
                 
               </div>
            </div>
            @if($finance->report_date=='' || $finance->report_date==null)
            <div class="col-md-3 col-12 duplicate_entry" style="display: none;">
               <div class="form-group">
                  <label for="">Duplicate Reason</label>
                 {!! Form::select('duplicate_reason',array(),null,['class' => 'custom-select form-control','id'=>"duplicate_reason","placeholder"=>"Select Duplicate Reason","required","data-validation-required-message"=>"Please Select Duplicate Reason"]) !!}
                  <button type="button" class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light" id="dp_record" style="float: right;margin-top: -35px;margin-right: -60px;">Info</button>
                  <div class="help-block"></div>
               </div>
            </div>
            @else
            <div class="col-md-3 col-12 duplicate_entry" style="display: {{$finance->duplicate_entry?'':'none'}};">
                <label>Duplicate Reason</label>
               <div class="form-group">
                   @if($finance->duplicate_entry)
                  {!! Form::select('duplicate_reason',$duplicate,$finance->duplicate_reason, ['class' => 'custom-select form-control','id'=>"duplicate_reason","placeholder"=>"Select Duplicate Reason","required","data-validation-required-message"=>"Please Select Duplicate Reason"]) !!}
                  @endif
                   <button type="button" class="btn bg-g radient-info mr-1 mb-1 waves-effect waves-light" id="dp_record" style="float: right;margin-top: -35px;margin-right: -60px;">Info</button>
                  <div class="help-block"></div>
               </div>
            </div>
            @endif
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-4 col-12">
               <span>General Comment
               </span>
            </div>
            <div class="col-md-7 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="general_comment"
                     class="form-control"
                     name="general_comment" 
                     placeholder="General Comment"  value="{{$finance->general_comment}}" data-validation-required-message="Please enter General Comment" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Person Showing Vehicle Mobile No (Record Only)
               </span>
            </div>
             <div class="col-md-7 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="mobile_no"
                     class="form-control"
                     name="mobile_no" 
                     placeholder="Mobile No" data-validation-required-message="Please enter Person Showing Vehicle Mobile No" value="{{$finance->mobile_no?$finance->mobile_no:'-'}}" required @if($finance->photo!=null && $role==2) disabled @endif>
                  <div class="help-block"></div>
                  @if($finance->photo!=null && $role==2)  
                     <div class="form-control-position">
                       <i class="fa fa-lock"></i>
                     </div>
                  @endif
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Extra Data (Record Only)
               </span>
            </div>
            <div class="col-md-7 col-12">
               <div
                  class="form-label-group form-label-group">
                  <input type="text" id="c_damage"
                     class="form-control" name="c_damage" 
                     placeholder="Extra Date(Record Only)" value="{{$finance->c_damage}}" data-validation-required-message="Please enter Extra Data (Record Only)" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Fair Amount<span style="color:red;">*</span>
               </span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="fair_amount"
                     class="form-control"
                     name="fair_amount" 
                     placeholder="Fair Amount" data-validation-required-message="Please enter Fair Amount" value="{{$finance->fair_amount}}" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-3 col-12">
               <button type="button" class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light" data-toggle="modal" id="gridbutton">Info</button>
               <button type="button" class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light" data-toggle="modal" id="grid_button">Info</button>   
            </div>
            <div class="col-md-12 col-12">
            </div>
            <div class="col-md-4 col-12">
               <span>Declaration<span style="color:red;">*</span>
               </span>
            </div>
            <div class="col-md-7 col-12">
               <div class="form-label-group form-group">
                  <select class="custom-select form-control"
                     id="notice" name="notice" data-validation-required-message="Please enter Declaration" required>
                     <option value="">Select
                        Declaration
                     </option>
                      @foreach($declaration as $key => $item)
                     <option value="{{$key}}" {{$key==$finance->notice ?'Selected':''}}>{{$item}}</option>
                     @endforeach
                  </select>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Staff Name
               </span>
            </div>
            <div class="col-md-7 col-12">
               <div class="form-label-group form-group">
                  <select class="custom-select form-control"
                     id="staff_name" name="staff_name" data-validation-required-message="Please enter Staff Name" required>
                     <option value="">Select Staff Name</option>
                     @foreach($staff as $key => $item)
                     <option value="{{$item}}" {{$item==$finance->staff_name ?'Selected':''}}>{{$item}}</option>
                     @endforeach
                  </select>
                  <div class="help-block"></div>
               </div>
            </div>
            
            <div class="col-md-2 col-12">
            </div>
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-1 col-12">
               <span>Total Amount<span style="color:red;">*</span>
               </span>
            </div>
            <div class="col-md-3 col-12">
               <div class="form-label-group form-group">
                  <input type="number" id="total_amount"
                     class="form-control"
                     name="total_amount" 
                     placeholder="Total Amount" data-validation-required-message="Please enter Total Amount" value="{{$finance->total_amount}}" required @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) disabled @endif>
                      @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2)  
                           <div class="form-control-position">
                             <i class="fa fa-lock"></i>
                           </div>
                        @endif
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-1 col-12">
               <span>Amount Received<span style="color:red;">*</span>
               </span>
            </div>
            <div class="col-md-3 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="amount_paid"
                     class="form-control"
                     name="amount_paid" 
                     placeholder="Amount Received" data-validation-required-message="Please enter Amount Received" value="{{$finance->amount_paid}}" required @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) disabled @endif>
                      @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2)  
                           <div class="form-control-position">
                             <i class="fa fa-lock"></i>
                           </div>
                        @endif
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-1 col-12">
               <span>Remaining Amount
               </span>
            </div>
            <div class="col-md-3 col-12">
               <div class="form-label-group form-group">
                  <input type="number" id="remaining_amount"
                     class="form-control"
                     name="remaining_amount" 
                     placeholder="Remaining Amount" value="{{$finance->remaining_amount}}" @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2) disabled @endif>
                      @if($finance->report_date!=null && $finance->report_date!='' && $finance->photo!=null && $role==2)  
                           <div class="form-control-position">
                             <i class="fa fa-lock"></i>
                           </div>
                        @endif
               </div>
            </div>
            @can('isSuper')
            <div class="col-md-1 col-12 hideadmin">
               <span>Deposit Amount
               </span>
            </div>
            <div class="col-md-3 col-12 hideadmin">
               <div class="form-label-group form-group">
                  <input type="text" id="amount"
                     class="form-control"
                     name="amount" 
                     placeholder="Deposit Amount" value="{{$finance->amount}}">
               </div>
            </div>
            <div class="col-md-1 col-12 hideadmin">
               <span>Depositor's Name and Date
               </span>
            </div>
            <div class="col-md-3 col-12 hideadmin">
               <div class="form-label-group form-group">
                  <input type="text" id="paid_person"
                     class="form-control"
                     name="paid_person" 
                     placeholder="Depositor Name & Date" value="{{$finance->paid_person}}">
               </div>
            </div>
            <div class="col-md-1 col-12 hideadmin">
               <span>Balance Amount
               </span>
            </div>
            <div class="col-md-3 col-12 hideadmin">
               <div class="form-label-group form-group">
                  <input type="number" id="paid_date"
                     class="form-control"
                     name="paid_date" 
                     placeholder="Balance Amount" value="{{$finance->paid_date}}">
               </div>
            </div>
            @endcan
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-12 col-12" style="margin: 15px 0px 50px 30px;">
               <div style="float: left;"> 
                  <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0 btn-lg waves-effect waves-light">Save</button>
               </div>
               <div id="zip_photo" style="float: right;margin-right: 70px;">
                  <a href="javascript:generatezip()" class="btn btn-primary waves-effect waves-light">Zip Photo</a>
               </div>
            </div>
			
			<div class="row">
				<div class="col-md-2 col-12">
					<span>User or Chassis Photos</span>
				</div>
				<div class="col-md-3 col-12">
					<label>Chassis Impression Photo</label>
					<div class="form-group">
						<input id="upload" type="file" name="upload" style="background-color: #337ab7; color: #fff" class="form-control image" accept="image/*">
					</div>
					<div class="profile-header mb-2">
						<div class="relative ">
							@if($finance-> chachees_number_photo)
								<div class="imagechachees0"><div><ul class="photo-remove"><li><a href="#" onclick=removimg("{{$finance->chachees_number_photo}}","chachees0","chachees")>Remove</a></li><li><a href="#" onclick=rotate("{{$finance->chachees_number_photo}}","right","previewimage")><i class="fa fa-rotate-right"></i></a></li><li><a href="#" onclick=rotate("{{$finance->chachees_number_photo}}","left","previewimage")><i class="fa fa-rotate-left"></i></a></li></ul></div><img id="previewimage" src="{{asset($finance->chachees_number_photo)}}" style="width: 310px; height: 175px;"><div style="text-align: center;"></div></div>
							@else
								<img id="previewimage" style="width: 310px; height: 175px;margin-top: 35px;">
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<label>Front Side Photo</label>
					<div class="form-group">
						<input id="front_side_photo" type="file" name="front_side_photo" style="background-color: #337ab7; color: #fff" class="form-control image" accept="image/*">
					</div>
					<div class="profile-header mb-2">
						<div class="relative ">
							@if($finance-> front_side_photo)
								<div class="imagefrontsidephoto0"><div><ul class="photo-remove"><li><a href="#" onclick=removimg("{{$finance->front_side_photo}}","frontsidephoto0","frontsidephoto")>Remove</a></li><li><a href="#" onclick=rotate("{{$finance->front_side_photo}}","right","front_side_photo_preview")><i class="fa fa-rotate-right"></i></a></li><li><a href="#" onclick=rotate("{{$finance->front_side_photo}}","left","front_side_photo_preview")><i class="fa fa-rotate-left"></i></a></li></ul></div><img id="front_side_photo_preview" src="{{asset($finance->front_side_photo)}}" style="width: 310px; height: 175px;"><div style="text-align: center;"></div></div>
							@else
								<img id="front_side_photo_preview" style="width: 310px; height: 175px;margin-top: 35px;">
							@endif
						</div>
					</div>
				</div>
				@if($finance->mobile_data)
					<div class="col-md-3 col-12">
						<label>Selfi Photo</label>
						<div class="form-group">&nbsp;</div>
						<div class="profile-header mb-2">
							<div class="relative ">
								@if($finance->selfie)
									<img src="{{asset('finance/')}}/{{$finance->selfie}}" style="width: 253px; height: 141px;">
								@endif
							</div>
						</div>
					</div>
				@endif
			</div>
			
			
			
			
            <?php /*<div class="col-md-2 col-12">
               <span>Chassis Impression Photo
               </span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-group">
                  <input id="upload" type="file" name="upload" style="background-color: #337ab7; color: #fff"
                     class="form-control" accept="image/*"
                     class="image">
               </div>
            </div>
            <div class="col-md-3 col-12">
               <div class="profile-header mb-2">
                  <div class="relative ">
                    @if($finance-> chachees_number_photo)
						<div class="imagechachees0"><div><ul class="photo-remove"><li><a href="#" onclick=removimg("{{$finance->chachees_number_photo}}","chachees0","chachees")>Remove</a></li><li><a href="#" onclick=rotate("{{$finance->chachees_number_photo}}","right","previewimage")><i class="fa fa-rotate-right"></i></a></li><li><a href="#" onclick=rotate("{{$finance->chachees_number_photo}}","left","previewimage")><i class="fa fa-rotate-left"></i></a></li></ul></div><img id="previewimage" src="{{asset($finance->chachees_number_photo)}}" style="width: 253px; height: 141px;"><div style="text-align: center;"></div></div>
                    @else
						<img id="previewimage" style="width: 253px; height: 141px;">
                    @endif
                  </div>
               </div>
            </div>
            @if($finance->mobile_data)
            <div class="col-md-3 col-12">
               <div class="profile-header mb-2">
                  <div class="relative ">
                     @if($finance->selfie)
                     <img src="{{asset('finance/')}}/{{$finance->selfie}}" style="width: 253px; height: 141px;">
                     @endif
                  </div>
               </div>
            </div>
            @endif */ ?>
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-2 col-12">
               <span>Permanent Photos ({{config('global.max_permanent_photos')}} Max.)</span>
            </div>
			@php
			$photo_types = config('global.photo_types')
			@endphp
            @include('Reports.upload_photos_common', ['photo_type' => $photo_types[0]])
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-2 col-12">
               <span>Temporary Photos</span>
            </div>
            @include('Reports.upload_photos_common', ['photo_type' => $photo_types[1]])
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
			
			<div class="videoUploadBlock">
				<div class="col-md-2 col-12">
					<span>Videos</span>
				</div>
				<div class="col-md-3 col-12">
					<label>Video 1 (Exterior)</label>
					<div class="form-group">
						<input type="file" name="uploadVideos[0]"  style="background-color: #31708F; color: #fff;" class="form-control" accept="video/mp4">
					</div>
				</div>
				<div class="col-md-3 col-12">
					<label>Video 2 (Interior)</label>
					<div class="form-group">
						<input type="file" name="uploadVideos[1]"  style="background-color: #31708F; color: #fff;" class="form-control" accept="video/mp4">
					</div>
				</div>
				<div class="col-md-3 col-12">
					<label>Video 3 (Running)</label>
					<div class="form-group">
						<input type="file" name="uploadVideos[2]"  style="background-color: #31708F; color: #fff;" class="form-control" accept="video/mp4">
					</div>
				</div>
			</div>
			
			
			
            @php
            if($finance->videos){
               $video=json_decode($finance->videos, 1);
               $approve_video=json_decode($finance->approve_video, 1);
			   //prd($video);
            }
            @endphp
			<div class="col-md-2 col-12 videos">&nbsp;</div>
            <div class="col-md-3 col-12 videos0">
				@if(!empty($video[0]))
					<a href="#" onclick=removimg("{{$video[0]}}","0","videos")>Remove</a><br>
					<video id="video1" width="320" height="240" controls src="{{asset($video[0])}}"></video>
					<div style="text-align: center;"><input type="checkbox" name="approve_video[]" class="approve-check" value="0" @if(in_array(0,$approve_video)) checked @endif></div>
				@endif
            </div>
            <div class="col-md-3 col-12 videos1">
				@if(!empty($video[1]))
					<a href="#" onclick=removimg("{{$video[1]}}","1","videos")>Remove</a><br>
					<video  id="video2" width="320" height="240" controls src="{{asset($video[1])}}"></video>
					<div style="text-align: center;"><input type="checkbox" name="approve_video[]" class="approve-check" value="1" @if(in_array(1,$approve_video)) checked @endif></div>
				@endif
            </div>
            <div class="col-md-3 col-12 videos2">
				@if(!empty($video[2]))
					<a href="#" onclick=removimg("{{$video[2]}}","2","videos")>Remove</a><br>
					<video  id="video2" width="320" height="240" controls src="{{asset($video[2])}}"></video>
					<div style="text-align: center;"><input type="checkbox" name="approve_video[]" class="approve-check" value="2" @if(in_array(2,$approve_video)) checked @endif></div>
				@endif
            </div>
			
            <div class="col-md-12 col-12">
               &nbsp;
            </div>
            <div class="col-md-2 col-12" style="margin-top:30px;">
               Stamp Show
            </div>
            <div class="col-md-4 col-12">
               <div class="form-group col-12" style="overflow: hidden;">
                  <p>
                     <br>
                     <sub style="color:red;"> For show stamp in pdf </sub>
                  </p>
                  <input type = "checkbox"  name = "stamp_show"  id = "stamp_show" style ='height:29px;width:4%;' value = "1" {{$finance->stamp_show?'checked':''}}>
               </div>
            </div>
            <div class="col-md-6 col-12">
            </div>
            <div class="col-md-7 col-12" style="text-align: right;">
               <div class="form-label-group form-group">
                  <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0 btn-lg waves-effect waves-light">Submit</button>
                  @if($finance->process==0)
                  <button type="button" class="btn btn-warning mr-sm-1 mb-1 mb-sm-0 btn-lg waves-effect waves-light" data-toggle="modal" data-target="#reject_modal">Reject</button>
                  @endif
               </div>
            </div>
         </div>
      </form>
   </div>    
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<div id="pdfgrid" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">GRID</h4>
      </div>
      <div class="modal-body" id="showgrid">
      
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary" id="changepdf">NEXT</button>
      </div>
    </div>

  </div>
</div>
<div id="dp_recordmodle" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Duplicate Record</h4>
      </div>
      <div class="modal-body" id="dp_record_show">
      
      </div>
    </div>

  </div>
</div>
<div id="grid_option" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">GRID</h4>
      </div>
      <div class="modal-body" id="showgrid">
            <form id="gridform">
      <div class="row">
         <div class="col-md-6 col-12">
            <div class="form-label-group form-group">
               <select class="custom-select form-control" id="vehicle_make" name="vehicle_make" aria-invalid="false">
               <option value="">Select vehicle</option>
               @foreach($vehicle_make as $item)
                    <option value="{{$item}}">{{$item}}</option>
               @endforeach;
               </select>
            </div>
         </div>
         <div class="col-md-6 col-12">
            <div class="form-label-group form-group">
               <select class="custom-select form-control" id="vehicle_model" name="vehicle_model"  aria-invalid="false">
           <option value="">First Select vehicle</option>
              </select>
              
            </div>
         </div>
       <div class="col-md-6 col-12">
            <div class="form-label-group form-group">
               <select class="custom-select form-control" id="variant" name="variant"  aria-invalid="false">
           <option value="">First Select vehicle Model</option>
              </select>
            </div>
         </div>
         <div class="col-md-6 col-12">
            <div class="form-label-group form-group">
               <select class="custom-select form-control" id="year" name="year"  aria-invalid="false">
           <option value="">First Select vehicle Variant</option>
              </select>
            </div>
         </div>
      </div>
    </form>
      <div class="table-responsive">
      <table class="table table-striped dataex-html5-selectors"  id="DataTables_Table_9">
         <thead><tr>
            <th>Vehicle</th>
            <th>Model</th>
            <th>variant</th>
            <th>Chassis No</th>
            <th>Year</th>
            <th>Cost</th>
            <th>Note</th>
         </tr></thead>
         <tbody>
         @if(isset($grid))
         @foreach($grid as $item)
         <tr>
            <td>{{$item->vehicle_make}}</td>
            <td>{{$item->vehicle_model}}</td>
            <td>{{$item->variant}}</td>
            <td>{{$item->chassis_no}}</td>
            <td>{{$item->year}}</td>
            <td>{{$item->cost}}</td>
            <td>{{$item->note}}</td>
         </tr> 
         @endforeach
         @endif
         </tbody>
      </table>
      </div> 
      </div>
    </div>

  </div>
</div>
<div id="uploadimageModal" class="modal" role="dialog">
<div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-body">
     <div id="image_demo" style="width:400px;"></div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success crop_image">Crop</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
   </div>
   </div>
</div>
<div id="reject_modal" class="modal fade" role="dialog">
         <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            {!! Form::model($finance,['method' => 'PUT', 'action' => ['FinanceController@report_reject',$finance->id],'id'=>'reject_form']) !!}
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Reject Report</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group" style="overflow: hidden;">
                           {!! Form::label('Rejection Reason', 'Rejection Reason*',[]) !!}
                           {!! Form::textarea('reject_reason',null,['class'=>'form-control', 'rows' => 2, 'cols' => 40,'required']) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-warning">Yes</button>
               </div>
            </div>
            {!! Form::close() !!}
         </div>
      </div> 
@include('layouts.custom_image_slider')
@endsection
@section('script')	
<script src="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="https://www.arvindampro.in/app-assets/croppie.js"></script>
<script type="text/javascript" src="https://www.arvindampro.in/app-assets/js/scripts/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://www.arvindampro.in/app-assets/js/scripts/sweetalert.min.js"></script>
<script type="text/javascript">
$('#savepdf').val('');
var dp_rg=0;
var dp_ch=0;
var dp_eg=0;
var grid_pdf;
var count = 0;   
$(document).ready(function(){
	@if(session::has('with_pdf'))
		@if(session('with_pdf') == 'yes')
			$('.openPdf')[0].click();
		@endif
	@endif
	table=$('#DataTables_Table_9').DataTable({
		pageLength: 50,
		lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
    });
   
	$( ".pickadate" ).prop('autocomplete','off');

	$("#report_date,#inspection_date").datepicker({
        dateFormat: 'dd-mm-yy',
	});
	$('#registration_date').datepicker({
		dateFormat: 'dd-mm-yy',
		editable: true, 
		constrainInput: false,
	});
	endDate = $('#report_date').datepicker('getDate'); 
	$("#inspection_date").datepicker("option", "maxDate", endDate); 
	$('#report_date').on('change',function(){
		endDate = $('#report_date').datepicker('getDate'); 
        $("#inspection_date").datepicker("option", "maxDate", endDate); 
	});
	$('#amount_paid,#total_amount').on('change',function(){
		rm_amouint= parseInt($('#total_amount').val())-parseInt($('#amount_paid').val())
        $('#remaining_amount').val(rm_amouint)
    });
    $('button[type=submit]').click(function(){
		window.setTimeout(function () {
            var errors = $('.error')
            if (errors.length) {
                $('html, body').animate({ scrollTop: errors.offset().top - 50}, 500);
            }
		}, 0);
	});
	$('#savepdf').on('change', function(){
		if($(this).val()) {
			window.setTimeout(function () {
				var errors = $('.error')
				if (errors.length) {
					$('html, body').animate({ scrollTop: errors.offset().top - 50}, 500);
				} else {
					$('#addreport').submit();
				}
			}, 0);
		}
	});
	$(".uploadPhoto").change(function() {
		var photo_type = $(this).attr('rel');
		if(photo_type == 'permanent') {
			var sortableCount = $('ul#sortable_'+photo_type+' li.ui-state-default').length;
			var newImageCount = this.files.length;
			if((sortableCount+newImageCount) > "{{config('global.max_permanent_photos')}}"){
				alert('You have already exceed max limit.');
				$(this).val(null);
				return false;
			}
		}
		readMultipleURL(this);
	});
	
	function readMultipleURL(input) {
		var photo_type = $(input).attr('rel');
		$('#listImages_'+photo_type).empty();
		for (var i = 0; i < input.files.length; i++) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#listImages_'+photo_type).append('<div class="col-md-2 col-12"><img src="' + e.target.result + '"class="img-fluid mb-4"/></div>');
			}
			reader.readAsDataURL(input.files[i]);
		}
	}
	
	$('input[type=text]').keyup(function () {
		if($(this).attr('id')!='general_comment'){
			this.value = this.value.toUpperCase();
		}
	});
	
	$('form').trigger('change');
	
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	
      $image_crop = $('#image_demo').croppie({
              enableExif: true,
              viewport: {
                  width: 450,
                  height: 150,
                  type: 'square' //circle
              },
              boundary: {
                  width: 470,
                  height: 300
              }
          });
		  
			front_side_photo.onchange = evt => {
				const [file] = front_side_photo.files
				if (file) {
					front_side_photo_preview.src = URL.createObjectURL(file)
				}
			}
      
          $('#upload').on('change', function() {
              var reader = new FileReader();
              reader.onload = function(event) {
                  $image_crop.croppie('bind', {
                      url: event.target.result
                  }).then(function() {});
              }
              reader.readAsDataURL(this.files[0]);
              $('#uploadimageModal').modal('show');
          });
      
          $('.crop_image').click(function(event) {
              $image_crop.croppie('result', {
                  type: 'canvas',
                  size: 'viewport'
              }).then(function(response) {
                     $('#uploadimageModal').modal('hide');
                     $('#previewimage').attr('src',response)
                  $('form').append('<input type="hidden" name="ch_upload" value='+response+'>');   
              })
          });
		$('#previewimage').click(function (){
				var imgSrc = $(this).attr('src');
				window.open(imgSrc,"","width=550,height=170,left=150,top=200,toolbar=0,status=0,");
		});
		
      $('#reject_form').submit(function() {
         return confirm("Are you sure that you want to Reject Report?");
      });
      $('#registration_no,#chachees_number,#engine_number').on('change', function() {
         val=$(this).val();
         index=$(this).attr('id');
         formdata = {for:'update'}
         formdata[$(this).attr('id')] = $(this).val()
         $.post('{{route("check_duplicate")}}',formdata,function(result){ 
            if(result.status==true){
               toastr.info(result.msg,'Info');
               if(index='registration_no'){
                  dp_rg=1;
               }
               if(index=='chachees_number'){
                  dp_ch=1
               }
               if(index=='engine_number'){
                  dp_eg=1
               }
            }else{
               if(index=='registration_no'){
                  dp_rg=0
               }
               if(index=='chachees_number'){
                  dp_ch=0
               }
               if(index=='engine_number'){
                  dp_eg=0
               }
            }
             getduplicate()
         });
      });
     $(document).on('click','#dp_record',function(){
         registration_no=$('#registration_no').val()
         chachees_number=$('#chachees_number').val()
         engine_number=$('#engine_number').val()
        $.post('{{route("get_duplicate")}}',{registration_no:registration_no,chachees_number:chachees_number,engine_number:engine_number},function(data){
            $('#dp_record_show').html(data)
            $('#dp_recordmodle').modal('show');
        })
      })
     if("{{$finance->report_date}}"==null || "{{$finance->report_date}}"==''){
       $('#registration_no').trigger('change'); 
     }
    
})
function getduplicate(){
   if(dp_rg==1 || dp_ch==1 || dp_eg==1){
      $.get('{{route("getreason")}}',function(result){
         $(".duplicate_entry").show();
         $("#duplicate_reason").empty();
         $("#duplicate_reason").append('<option value="">Select Duplicate Reason</option>');
         $.each(result,function(i,v){
            $("#duplicate_reason").append('<option value="' + v + '">' +i+ '</option>');
         })
         $("#duplicate_reason").prop('required',true);
         $(function () { $("#duplicate_reason").not("[type=submit]").jqBootstrapValidation(); } );
      })         
   }else{
      $("#duplicate_reason").prop('required',false);
      $(".duplicate_entry").hide();
      $("#duplicate_reason").empty();
   }
}
function rotate(img,pos,photoId){
	event.preventDefault();
	$.post("{{route('image_rotate')}}",{img:img,pos:pos},function(result){
		if (result.status == true) {
			$("#"+photoId).attr('src','data:image/gif;base64,'+result.img);
			toastr.success(result.msg, "success");
		} else {
			toastr.error(result.msg, "Error");
		}
	})
}
function removimg(id, ii, image_type, photo_type = null) {
          event.preventDefault();
		if(image_type == 'videos') {
			var swaltoast = "You Want  Remove Video! it's Permanently Deleted";
		} else {
			var swaltoast = "You Want  Remove Image! it's Permanently Deleted";
		}
          swal({
                  title: "Are you sure?",
                  text: swaltoast,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                     $.post("{{route('image_remove')}}",{id:"{{$finance->id}}",image: id,image_type:image_type,photo_type:photo_type},function(result){
                        if (result.status == true) {
                           toastr.success(result.msg, "success");
                        } else {
                           toastr.error(result.msg, "Error");
                        }
						if(image_type == 'videos') {
							$('.videos' + ii).empty();
						} else {
							if(image_type == 'chachees') {
								$('.image' + ii).html('<img id="previewimage" style="width: 310px; height: 175px;margin-top: 35px;">');
							} else if(image_type == 'frontsidephoto') {
								$('.image' + ii).html('<img id="front_side_photo_preview" style="width: 310px; height: 175px;margin-top: 35px;">');
							} else {
								$('.image' + ii).remove();
							}
						}
                     })
                  }
              });
      }
function generatezip(){
   window.location.href = "{{route('make_zip',$finance->id)}}" ;
}       
$(document).on('change','form',function(){
    $('form input,select[id]').each(function() {
         id = $(this).attr('id')
         if ($('#' + id).val()) {
             $('#' + id).css('background-color', '#93f793')
         } else {
             $('#' + id).css('background-color', '#f39797')
         }
      })
})
 $('#gridbutton').click(function(){
            if($('#valuation_by').val()!=''){
            $.post("{{route('get_grid_pdf')}}",{valu_id:$('#valuation_by').val()},function(response){
              if(response.status==true){
                grid_pdf=response.data.grid_pdf
                grid_pdf=$.parseJSON(grid_pdf);
                 $('#showgrid').html('<iframe src="{{asset("com_pdf")}}/'+grid_pdf[0]+'" width="100%" height="600px"></iframe>');
                 $('#pdfgrid').modal('show');
              }else{
                  toastr.info("There are No Grid to show", "info");
               }
            })
            }else{
              toastr.error("Select Company First", "Error");
            }
 })
 $('#changepdf').click(function(){
           grid_pdf.length
           count=count+1 
           $('#showgrid').html('<iframe src="{{asset("com_pdf")}}/'+grid_pdf[count-1]+'" width="100%" height="600px"></iframe>')
           if(grid_pdf.length==count){
             count=0;
           }
 })
	
	
 $('#grid_button').click(function(){
      $('#gridform').trigger('reset'); 
      $('#grid_option').modal('show');      
 }) 
 $('#gridform select').change(function() {
         var select
          table.search($(this).val()).draw();
         if($(this).attr('name')=='vehicle_make'){
            var select = $('form select[name=vehicle_model]');
            select.html('<option value="0">Select Vehicle Make</option>');
            $('form select[name=variant]').html('<option value="0">First Select Vehicle Model</option>');
            $('form select[name=year]').html('<option value="0">First Select Variant</option>');

         }
         if($(this).attr('name')=='vehicle_model'){
            var select = $('form select[name=variant]');
             select.html('<option value="0">Select Vehicle Model</option>');
            $('form select[name=year]').html('<option value="0">First Select Variant</option>');
         }
         if($(this).attr('name')=='variant'){
            var select = $('form select[name=year]');
             select.html('<option value="0">Select Variant</option>');
         }
         var url = '{{route("get_grid")}}'
         formdata=$("#gridform select").serialize()
         $.post(url,formdata,function(data) {
             $.each(data,function(key, value) {
                 select.append('<option value="' + key + '">' + value + '</option>');
             });
         });
 });        
</script>
@endsection