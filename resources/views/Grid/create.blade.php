@extends('layouts.header')
@section('title', 'Add Grid')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Add Grid</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
              <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Add Grid
               </li>
               <span style="float:right;"><a href="{{route('grid.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
       @include('layouts.alert')
       </section>
      {!!Form::open(['method' => 'POST', 'action' => 'GridController@store','id'=>'gridform']) !!}      
      <div class="row">
        
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('vehicle_make', 'Vehicle Make*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  <select class="form-control col-md-6" id="vehicle_make" name="vehicle_make">
                     <option value="">Select Vehicle Make</option>
                     @foreach($vehicle_make as $item)
                        <option value="{{$item}}">{{$item}}</option>
                     @endforeach;
                     <option value="other">Other</option>
                  </select> 
                  <div class="error-message"> {{ $errors->first('vehicle_make') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('vehicle_model', 'Vehicle Model*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('vehicle_model',array(), null, ['class' => 'form-control col-md-6','placeholder'=>'First Select Vehicle Make']) !!}
                  <div class="error-message"> {{ $errors->first('vehicle_model') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('variant', 'Variant*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('variant',array(),null, ['class' => 'form-control col-md-6','placeholder'=>'First Select Vehicle Model']) !!}
                  <div class="error-message"> {{ $errors->first('variant') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('year', 'Year*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('year',array(), null, ['class' => 'form-control col-md-6','placeholder'=>'First Select Variant']) !!}
                  <div class="error-message"> {{ $errors->first('year') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('chassis_no', 'Chassis No',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('chassis_no', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('chassis_no') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('cost', 'Cost',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('cost', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('cost') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('note', 'Note',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('note', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('note') }}</div>
               </div>
            </div>
         </div>

        <!-- <div class="input submit">
            <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" ></div>
         </div>-->
		  <div class="input submit">
			  <div class="col-md-offset-2 col-md-6 submit" style="padding: 0 0 0 24px;">
				  <input class="btn btn-success" type="submit" value="Submit">
			  </div>
         </div>
      </div>
       {!! Form::close() !!}
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
@endsection
@section('script')
<script type="text/javascript">
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
   $(function() {
        $('#gridform select').change(function() {
            var select
            if($(this).val()=="other"){
               action=$(this).attr("name");
               $(this).parent().html('<input type="text" class="form-control" id="'+action+'" name="'+action+'" required="">')
            }
            if($(this).attr('name')=='vehicle_make'){
               var select = $('form select[name=vehicle_model]');
               if($(this).val()=="other"){
                  select.parent().html('<input type="text" class="form-control" id="vehicle_model" name="vehicle_model" required="">')
                  $('form select[name=variant]').parent().html('<input type="text" class="form-control" id="variant" name="variant" required="">')
                  $('form select[name=year]').parent().html('<input type="text" class="form-control" id="year" name="year" required="">')
                   return false;
               }
               select.html('<option value="0">Select Vehicle Make</option>');
               select.append('<option value="other">Other</option>');
               $('form select[name=variant]').html('<option value="0">First Select Vehicle Model</option>');
               $('form select[name=year]').html('<option value="0">First Select Variant</option>');

            }
            if($(this).attr('name')=='vehicle_model'){
               var select = $('form select[name=variant]');
                if($(this).val()=="other"){
                  $('form select[name=variant]').parent().html('<input type="text" class="form-control" id="variant" name="variant" required="">')
                  $('form select[name=year]').parent().html('<input type="text" class="form-control" id="year" name="year" required="">')
                   return false;
                }
                select.html('<option value="0">Select Vehicle Model</option>');
                select.append('<option value="other">Other</option>');
               $('form select[name=year]').html('<option value="0">First Select Variant</option>');
            }
            if($(this).attr('name')=='variant'){
               var select = $('form select[name=year]');
               if($(this).val()=="other"){
                  select.parent().html('<input type="text" class="form-control" id="year" name="year" required="">')
                   return false;
                }
                select.html('<option value="0">Select Variant</option>');
                select.append('<option value="other">Other</option>');
            }
            var url = '{{route("grid.create")}}'
            formdata=$("#gridform select").serialize()
            $.get(url,formdata,function(data) {
                $.each(data,function(key, value) {
                    select.append('<option value="' + key + '">' + value + '</option>');
                });
            });
        });
    });
</script>
@endsection