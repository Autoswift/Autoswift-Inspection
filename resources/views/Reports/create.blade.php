@extends('layouts.header')
@section('title', 'Add Report')
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('js/croppic/croppie.css')}}">
<style type="text/css">
   .error {
   color: black;
   }
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
   font-weight:500;
   color:#000000;
   }
   #sortable { 
   list-style-type: none; 
   margin: 0; 
   padding: 0; 
   width: 100%; 
   }
   #sortable li { 
   margin: 3px 3px 3px 0; 
   padding: 1px; 
   float: left; 
   border: 0;
   background: none;
   }
   #sortable li img{
   width: 250px;
   height: 140px;
   }
   .photo-remove li
   {
   display: inline-block;
   margin: 3px 83px 3px -26px !important;
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
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Add New Report</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Add New Report
               </li>
               <span style="float:right;"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
         @include('layouts.alert')
      </section>
      <form class="form" novalidate enctype="multipart/form-data" method="POST" id="addreport" Action="{{route('report.store')}}">
         @csrf
         <button type="submit" class="btn mr-1 mb-1 waves-effect waves-light" style="color: #fff; background-color:#4839EB;" id="savepdf" name="pdf" value="pdf">Save as Pdf</button>
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
                        required readonly value="{{$reference_no}}" style="background-color: #93f793;">
                     <div class="form-control-position" style="position: absolute;">
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
                     id="application_no" data-validation-required-message="Please enter Application No" style="background-color: #97e6f3;" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Valuation Initiated By<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-label-group form-group form-group">
                  <select class="custom-select form-control" name="valuation_by" id="valuation_by" data-validation-required-message="Please enter Valuation Initiated" style="background-color: #97e6f3;" required>
                     <option value=''>Select Valuation Initiated By</option>
                     @foreach($company as $key => $item)
                     <option value='{{$key}}'>{{$item}}</option>
                     @endforeach
                  </select>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Financer's Representative<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="financer_representative"
                     class="form-control"
                     placeholder="Financer's Representative"
                     name="financer_representative" data-validation-required-message="Please enter Financer's Representative" style="background-color: #97e6f3;" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-4 col-12">
               <span>Place Of
               Valuation<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-5 col-12">
               <div class="form-label-group form-group">
                  <div class="form-label-group form-group">
                     <input type="text" id="place_of_valuation"
                        class="form-control"
                        name="place_of_valuation" 
                        placeholder="Place Of Valuation" data-validation-required-message="Please enter Place Of Valuation" style="background-color: #97e6f3;" required>
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
                        placeholder="Search Registration Number" style="background-color: #f39797;" required pattern="(([A-Za-z]){2,3}(|-)(?:[0-9]){1,2}(|-)(?:[A-Z0-9]){1}(|-)([0-9]){1,4})|(([A-Za-z]){2,3}(|-)([0-9]){1,4})" data-validation-required-message="Please enter Registration Number" maxlength="33">
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
                     placeholder="Report Date" data-validation-required-message="Please enter Report Date" maxlength="12" style="background-color: #97e6f3;" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Make And Model<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="make_model"
                     class="form-control"
                     placeholder="Search Make And Model"
                     name="make_model" data-validation-required-message="Please enter Make And Model" style="background-color: #f39797;" maxlength="33" required>
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
                     placeholder="Inspection Date" data-validation-required-message="Please enter Inspection Date" maxlength="12" style="background-color: #97e6f3;" required>
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
                     placeholder="Chassis Number" data-validation-required-message="Please enter Chassis Number" style="background-color: #f39797;" maxlength="33" required>
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
                     placeholder="Registration Date" data-validation-required-message="Please enter Registration Date" style="background-color: #f39797;" maxlength="50" required>
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
                     placeholder="Engine Number" data-validation-required-message="Please enter Engine Number" style="background-color: #f39797;" maxlength="33" required>
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
                     placeholder="Colour" data-validation-required-message="Please enter Colour" maxlength="12" style="background-color: #f39797;" required>
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
                     placeholder="Registered Owner" data-validation-required-message="Please enter Registered Owner" style="background-color: #f39797;" maxlength="33" required>
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
                     placeholder="Seating Capacity" data-validation-required-message="Please enter Seating Capacity" style="background-color: #f39797;" maxlength="12" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Finance Taken By<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="financed_by"
                     class="form-control"
                     name="financed_by" 
                     placeholder="Finance Taken By" data-validation-required-message="Please enter Finance Taken By" maxlength="33" style="background-color: #97e6f3;" required>
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
                     placeholder="Regd. Laden Wt.(kg)" data-validation-required-message="Please enter Regd. Laden Wt.(Kg)" style="background-color: #f39797;" maxlength="12" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Fuel Used<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <select class="custom-select form-control"
                     id="fule_used" name="fule_used"  data-validation-required-message="Please enter Fuel Used" maxlength="33" style="background-color: #f39797;" required>
                     <option value="">Select Fuel
                        Used
                     </option>
                     <option value="-">-</option>
                     <option value="DIESEL">DIESEL</option>
                     <option value="PETROL">PETROL</option>
                     <option value="PETROL+LPG">PETROL+LPG
                     </option>
                     <option value="PETROL+CNG">PETROL+CNG
                     </option>
                     <option value="CNG">CNG</option>
                     <option value="ELECTRICAL">ELECTRICAL
                     </option>
                     <option value="OTHER">OTHER</option>
                  </select>
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
                     placeholder="Regd. Unladen Wt.(kg)" data-validation-required-message="Please enter Regd. Unladen Wt.(Kg)" style="background-color: #f39797;" maxlength="12" required>
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
                     placeholder="Owner Serial Number" data-validation-required-message="Please enter Owner Serial Number" style="background-color: #f39797;" maxlength="12" required>
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
                     placeholder="Cubic Capacity" data-validation-required-message="Please enter Cubic Capacity" style="background-color: #f39797;" maxlength="12" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Tax Paid Upto</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group">
                  <input type="text" id="tax_paid"
                     class="form-control" name="tax_paid" 
                     placeholder="Tax Paid Upto" data-validation-required-message="Please enter Tax Paid Upto"  style="background-color: #93f793;" maxlength="33" required value="-">
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
                     placeholder="MM Reading(Kms/Hrs)" data-validation-required-message="Please enter MM Reading(Kms/Hrs)" style="background-color: #97e6f3;" maxlength="12" required>
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
                     placeholder="Hypothecation" data-validation-required-message="Please enter Hypothecation" style="background-color: #f39797;" maxlength="33" required>
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
                     placeholder="Battery" data-validation-required-message="Please enter Battery" maxlength="12" style="background-color: #97e6f3;" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Policy No.</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="policy_no"
                     class="form-control" name="policy_no" 
                     placeholder="Policy Number" value="-" data-validation-required-message="Please enter Policy No" style="background-color: #93f793;" maxlength="33" required>
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
                     placeholder="Radiator" data-validation-required-message="Please enter Radiator" maxlength="12" style="background-color: #97e6f3;" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Validity</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="validity"
                     class="form-control" name="validity" 
                     placeholder="Validity" value="-" data-validation-required-message="Please enter Validity" style="background-color: #93f793;" maxlength="33" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>AC<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <select class="custom-select form-control"
                     id="ac" name="ac" data-validation-required-message="Please enter AC" style="background-color: #97e6f3;" required>
                     <option value="">Select Ac
                     </option>
                     <option value="-">-</option>
                     <option value="yes">Yes</option>
                     <option value="no">No</option>
                  </select>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Policy Type</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="policy_type"
                     class="form-control"
                     name="policy_type" 
                     placeholder="Policy Type" value="-" data-validation-required-message="Please enter Policy Type" style="background-color: #93f793;" maxlength="33" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Power Steering<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <select class="custom-select form-control"
                     id="power_steering"
                     name="power_steering" data-validation-required-message="Please enter Power Steering" style="background-color: #97e6f3;" required>
                     <option value="">Select Power
                        Steering
                     </option>
                     <option value="-">-</option>
                     <option value="yes">Yes</option>
                     <option value="no">No</option>
                  </select>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Owner in Policy</span>
            </div>
            <div class="col-md-4 col-12">
               <div
                  class="form-label-group form-group ">
                  <input type="text" id="owner_in_policy"
                     class="form-control"
                     name="owner_in_policy" 
                     placeholder="Owner In Policy" value="-" data-validation-required-message="Please enter Owner in Policy" style="background-color: #93f793;" maxlength="33" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Power Window<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <select class="custom-select form-control"
                     id="power_window" name="power_window" data-validation-required-message="Please enter Power Window" style="background-color: #97e6f3;" required>
                     <option value="">Select Power
                        Window
                     </option>
                     <option value="-">-</option>
                     <option value="yes">Yes</option>
                     <option value="no">No</option>
                  </select>
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
                     placeholder="Sum Insured(IDV)" value="-" data-validation-required-message="Please enter Sum Insured(IDV)" style="background-color: #93f793;" maxlength="33" required>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <span>Air Bag<span style="color:red;">*</span></span>
            </div>
            <div class="col-md-4 col-12">
               <div class="form-label-group form-group">
                  <select class="custom-select form-control"
                     id="air_bag" name="air_bag" data-validation-required-message="Please enter Air Bag" style="background-color: #97e6f3;" required>
                     <option value="">Select Air
                        Bag
                     </option>
                     <option value="-">-</option>
                     <option value="yes">Yes</option>
                     <option value="no">No</option>
                  </select>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-12 col-12">
               &nbsp;
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
                                 data-validation-required-message="Please enter Quantity" style="background-color: #97e6f3;" required>
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"
                                 style="background-color: #97e6f3;" >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"
                                 style="background-color: #97e6f3;">
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="right_tyer_quantity"
                                 class="form-control"
                                 name="right_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_tyer_company"
                                 class="form-control"
                                 name="right_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="right_quality"
                                 class="form-control"
                                 name="right_quality[]"
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
                                 data-validation-required-message="Please enter Quantity" style="background-color: #97e6f3;" required>
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]"
                                 style="background-color: #97e6f3;">
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]"
                                 style="background-color: #97e6f3;">
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]"
                                 >
                              </td>
                           </tr>
                           <tr>
                              <td><input type="text"
                                 id="left_tyer_quantity"
                                 class="form-control"
                                 name="left_tyer_quantity[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_tyer_company"
                                 class="form-control"
                                 name="left_tyer_company[]"
                                 >
                              </td>
                              <td><input type="text"
                                 id="left_quality"
                                 class="form-control"
                                 name="left_quality[]"
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
                  <select class="custom-select form-control"
                     id="c_engine_condition"
                     name="c_engine_condition" style="background-color: #93f793;" >
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="coolingExhaust-column">Cooling &
                  Exhaust System</label>
                  <select class="custom-select form-control"
                     id="c_cooling_system"
                     name="c_cooling_system" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="suspension-column">Suspension
                  System</label>
                  <select class="custom-select form-control"
                     id="c_suspension_system" name="c_suspension_system" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="electrical-column">Electrical
                  System</label>
                  <select class="custom-select form-control"
                     id="c_electrical_system" name="c_electrical_system" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="wheelTyres-column">Wheel &
                  Tyres</label>
                  <select class="custom-select form-control"
                     id="c_wheel" name="c_wheel" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="chassis-column">Chassis</label>
                  <select class="custom-select form-control"
                     id="c_chassis" name="c_chassis" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="cabinBody-column">Cabin & Body
                  Ext</label>
                  <select class="custom-select form-control"
                     id="c_cabin" name="c_cabin" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="conditionInterior-column">Condition
                  & Interior</label>
                  <select class="custom-select form-control"
                     id="c_condition_of_interiors"
                     name="c_condition_of_interiors" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="">Glasses</label>
                  <select class="custom-select form-control"
                     id="c_glass" name="c_glass" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12">
               <div class="form-group">
                  <label for="">Paint</label>
                  <select class="custom-select form-control"
                     id="c_paint" name="c_paint" style="background-color: #93f793;">
                     <option value="good">Good</option>
                     <option value="average">Average</option>
                     <option value="poor">Poor</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2 col-12 duplicate_entry" style="display: none;">
               <div class="form-group">
                  <label for="">Duplicate Reason</label>
                 {!! Form::select('duplicate_reason',array(),null,['class' => 'custom-select form-control','id'=>"duplicate_reason","placeholder"=>"Select Duplicate Reason","required","data-validation-required-message"=>"Please Select Duplicate Reason"]) !!}
                  <button type="button" class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light" id="dp_record" style="float: right;margin-top: -35px;margin-right: -60px;">Info</button>
                  <div class="help-block"></div>
               </div>
            </div>
            <div class="col-md-2 col-12 duplicate_entry" style="display: none;">
            </div>
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
                     placeholder="General Comment" value="-" data-validation-required-message="Please enter General Comment" style="background-color: #93f793;" required>
                  <div class="help-block"></div>
               </div>
            </div>
             <div class="col-md-4 col-12">
               <span>Mobile No- Person showing Veh (Record only)
               </span>
            </div>
             <div class="col-md-7 col-12">
               <div class="form-label-group form-group">
                  <input type="text" id="mobile_no"
                     class="form-control"
                     name="mobile_no" 
                     placeholder="Mobile No" data-validation-required-message="Please enter Person Showing Vehicle Mobile No" value="-" style="background-color: #93f793;" required>
                  <div class="help-block"></div>
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
                     placeholder="Extra Date(Record Only)" value="-" data-validation-required-message="Please enter Extra Data (Record Only)" style="background-color: #93f793;" required>
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
                     placeholder="Fair Amount" data-validation-required-message="Please enter Fair Amount" style="background-color: #97e6f3;" required>
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
                     id="notice" name="notice" data-validation-required-message="Please enter Declaration" style="background-color: #97e6f3;" required>
                     <option value="">Select
                        Declaration
                     </option>
                     @foreach($declaration as $key => $item)
                     <option value="{{$key}}">{{$item}}</option>
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
                     id="staff_name" name="staff_name" data-validation-required-message="Please enter Staff Name" style="background-color: #97e6f3;" required>
                     <option value="">Select Staff Name</option>
                     @foreach($staff as $key => $item)
                     <option value="{{$item}}">{{$item}}</option>
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
               <div
                  class="form-label-group form-group">
                  <input type="number" id="total_amount"
                     class="form-control"
                     name="total_amount" 
                     placeholder="Total Amount" data-validation-required-message="Please enter Total Amount" style="background-color: #97e6f3;" required>
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
                     placeholder="Amount Received" data-validation-required-message="Please enter Amount Received" style="background-color: #97e6f3;" required>
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
                     placeholder="Remaining Amount" style="background-color: #97e6f3;">
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
                     placeholder="Deposit Amount" style="background-color: #97e6f3;">
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
                     placeholder="Depositor Name & Date" style="background-color: #97e6f3;">
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
                     placeholder="Balance Amount" style="background-color: #97e6f3;">
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
							<img id="previewimage" style="width: 310px; height: 175px;margin-top: 35px;">
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
							<img id="front_side_photo_preview" style="width: 310px; height: 175px;margin-top: 35px;">
						</div>
					</div>
				</div>
			</div>
			
            <?php /* <div class="col-md-2 col-12">
               <span>Chassis Impression Photo
               </span>
            </div>
            <div class="col-md-4 col-12">
				<div class="form-group">
					<input id="upload" type="file" name="upload" style="background-color: #337ab7; color: #fff" class="image form-control" accept="image/*">
				</div>
            </div>
            <div class="col-md-6 col-12">
               <div class="profile-header mb-2">
                  <div class="relative ">
                     <img id="previewimage" style="width: 253px; height: 141px;">
                  </div>
               </div>
            </div>*/ ?>
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
			
			
			
            <div class="col-md-4 col-12 videos" style="display: none;">
               <video id="video1" width="320" height="240" controls src=""></video>
               <p><b>Video-1</b></p>
            </div>
            <div class="col-md-4 col-12 videos" style="display: none;">
               <video  id="video2" width="320" height="240" controls src=""></video>
               <p><b>Video-2</b></p>
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
                  <input type = "checkbox"  name = "stamp_show"  id = "stamp_show" style ='height:29px;width:4%;' value = "1" checked = "checked">
               </div>
            </div>
            <div class="col-md-6 col-12">
            </div>
            <div class="col-md-7 col-12" style="text-align: right;">
               <div class="form-label-group form-group">
                  <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0 btn-lg waves-effect waves-light">Submit</button>
               </div>
            </div>
         </div>
      </form>
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
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
                           <option value>First Select vehicle</option>
                        </select>
                        <div class="help-block"></div>
                     </div>
                  </div>
                  <div class="col-md-6 col-12">
                     <div class="form-label-group form-group">
                        <select class="custom-select form-control" id="variant" name="variant"  aria-invalid="false">
                           <option value>First Select vehicle Model</option>
                        </select>
                        <div class="help-block"></div>
                     </div>
                  </div>
                  <div class="col-md-6 col-12">
                     <div class="form-label-group form-group">
                        <select class="custom-select form-control" id="year" name="year"  aria-invalid="false">
                           <option value>First Select vehicle Variant</option>
                        </select>
                        <div class="help-block"></div>
                     </div>
                  </div>
               </div>
            </form>
            <div class="table-responsive">
               <table class="table table-striped dataex-html5-selectors"  id="DataTables_Table_9">
                  <thead>
                     <tr>
                        <th>Vehicle</th>
                        <th>Model</th>
                        <th>variant</th>
                        <th>Chassis No</th>
                        <th>Year</th>
                        <th>Cost</th>
                        <th>Note</th>
                     </tr>
                  </thead>
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
   <div class="modal-dialog" style="width: 505px;">
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
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="{{asset('js/croppic/croppie.js')}}"></script>
<script type="text/javascript" src="https://www.arvindampro.in/app-assets/js/scripts/moment-with-locales.min.js"></script>
<script type="text/javascript">
   var dp_rg=0;
   var dp_ch=0;
   var dp_eg=0;
   var grid_pdf;
   var count = 0;   
   $(document).ready(function(){
      table=$('#DataTables_Table_9').DataTable({
         pageLength: 50,
         lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
      });
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
      
      $('button[type=submit]').click(function(){
        window.setTimeout(function () {
               var errors = $('.error')
               if(errors.length) {
                   $('html, body').animate({ scrollTop: errors.offset().top - 50}, 500);
                   return false;
               }
         }, 0);
      }) 
     
      $( ".pickadate" ).prop('autocomplete','off');
      $("#report_date,#inspection_date").datepicker({
           dateFormat: 'dd-mm-yy',
           
      });
      $('#registration_date').datepicker({
         dateFormat: 'dd-mm-yy',
         editable: true, 
         constrainInput: false,
      })
      $(document).on('click','#dp_record',function(){
            registration_no=$('#registration_no').val()
            chachees_number=$('#chachees_number').val()
            engine_number=$('#engine_number').val()
           $.post('{{route("get_duplicate")}}',{registration_no:registration_no,chachees_number:chachees_number,engine_number:engine_number},function(data){
               $('#dp_record_show').html(data)
               $('#dp_recordmodle').modal('show');
           })
         })
      //$('form').trigger('change'); 
      $('#report_date').on('change',function(){
             endDate = $('#report_date').datepicker('getDate'); 
           $("#inspection_date").datepicker("option", "maxDate", endDate); 
      })
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
             /*$("#uploadPhoto").change(function() {
                 readMultipleURL(this);
             });
             function readMultipleURL(input) {
                 $('#listImages').empty();
                 for (var i = 0; i < input.files.length; i++) {
                     var reader = new FileReader();
                     reader.onload = function(e) {
         
                         $('#listImages').append('<div class="col-md-2 col-12"><img src="' + e.target.result + '"class="img-fluid mb-4"/></div>')
         
                     }
                     reader.readAsDataURL(input.files[i]);
                 }
             }*/
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
   }) 
      $('#registration_no,#chachees_number,#engine_number').on('change', function() {
            val=$(this).val();
            index=$(this).attr('id');
            formdata = {for:'create'}
            formdata[$(this).attr('id')] = $(this).val()
            $.post('{{route("check_duplicate")}}',formdata,function(result){ 
               if(result.status==true){
                  toastr.info(result.msg,'Info');
                  if(index='registration_no'){
                     dp_rg=1;  
                     $.each(result.data,function(i,v){
                        if(i!='reference_no' && i!='report_date' && i!='right_tyer_quantity' && i!='right_tyer_company' &&  i!='right_quality' && i!='left_tyer_quantity' && i!='left_tyer_company' && i!='left_quality'){
                           $('#'+i).val(v);
                           }
                     });
                     if(result.data.report_date!=null){
                       $('#report_date').val(moment.unix(result.data.report_date).format("DD-MM-YYYY"));
                     } 
                     var right_tyer_quantity = $.parseJSON(result.data.right_tyer_quantity)
                     $.each(right_tyer_quantity, function(idx, val) {
                         $('[name = "right_tyer_quantity[]"]').eq(idx).val(val);
                     });
                     var right_tyer_company = $.parseJSON(result.data.right_tyer_company)
                     $.each(right_tyer_company, function(idx, val) {
                         $('[name = "right_tyer_company[]"]').eq(idx).val(val);
                     });
                     var right_quality = $.parseJSON(result.data.right_quality)
                     $.each(right_quality, function(idx, val) {
                         $('[name = "right_quality[]"]').eq(idx).val(val);
                     });
                     var left_tyer_quantity = $.parseJSON(result.data.left_tyer_quantity)
                     $.each(left_tyer_quantity, function(idx, val) {
                         $('[name = "left_tyer_quantity[]"]').eq(idx).val(val);
                     });
                     var left_tyer_company = $.parseJSON(result.data.left_tyer_company)
                     $.each(left_tyer_company, function(idx, val) {
                         $('[name = "left_tyer_company[]"]').eq(idx).val(val);
                     });
                     var left_quality = $.parseJSON(result.data.left_quality)
                     $.each(left_quality, function(idx, val) {
                         $('[name = "left_quality[]"]').eq(idx).val(val);
                     });
   
                     $('#chachees_number').trigger('change');
                     $('#engine_number').trigger('change');
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
    $('#amount_paid,#total_amount').on('change',function(){
        rm_amouint= parseInt($('#total_amount').val())-parseInt($('#amount_paid').val())
        $('#remaining_amount').val(rm_amouint)
      })
    $('#grid_button').click(function(){
         $('#gridform').trigger('reset'); 
         $('#grid_option').modal('show');      
    }) 
	
	setTimeout(function(){
		$('.help-block ul').css({ "padding" : "0px" })
	},2000);
	
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
            if(select){
            $.post(url,formdata,function(data) {
                $.each(data,function(key, value) {
                    select.append('<option value="' + key + '">' + value + '</option>');
                });
            });
            }
    });
</script>
@endsection