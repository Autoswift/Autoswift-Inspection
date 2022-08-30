@extends('layouts.header')
@section('title', 'Edit Valuation')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading --> 
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Edit Valuation Initiated by</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li>
                  <i class="fa fa-fw fa-tasks"></i>Addition
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i>Edit Valuation Initiated by
               </li>
               <span style="float:right;"><a href="{{route('valuation.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
         @include('layouts.alert')
      </section>
      {!! Form::model($valuation, ['method' => 'PATCH', 'action' => ['ValuationController@update', $valuation->id],'files' => true]) !!}      
      <div class="row">
         <div class="col-lg-12">
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('name', 'Valuation Initiated By*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('name', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('name') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('address', 'Address',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('address', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('address') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('file', 'File',['class' => 'col-md-2']) !!}
               <div class="col-md-2">
                  {!! Form::file('gridpdf[]',array('accept'=>'application/pdf','multiple'=>'multiple'), ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('gridpdf') }}</div>
               </div>
				         </div>
               <!-- <div class="input submit">
                  <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" value="Submit"></div>
               </div> -->
               <div class="row" style="padding-left: 10px;">
                  @php
                  $file=json_decode($valuation->grid_pdf)
                  @endphp
                  @if($file)
                  @foreach($file as $key => $item)
				   @if($key == 0)
					  <div class="col-md-offset-2 col-md-2" id="vl_pdf_{{$key}}">
						 <embed width="100%" height="100%" name="plugin" src="{{asset('com_pdf').'/'.$item}}" type="application/pdf">
						 <a href="#" onclick="remove('{{$key}}')"style="font-weight: bold;text-decoration:none;padding-left: 10px;">Remove</a>
						 <a href="{{asset('com_pdf').'/'.$item}}" target="_blank" style="font-weight: bold;text-decoration:none;padding-left: 70px;">Open</a>
					  </div>
					@endif
				   	@if($key != 0)
						<div class="col-md-2" id="vl_pdf_{{$key}}">
						 <embed width="100%" height="100%" name="plugin" src="{{asset('com_pdf').'/'.$item}}" type="application/pdf">
						 <a href="#" onclick="remove('{{$key}}')"style="font-weight: bold;text-decoration:none;padding-left: 10px;">Remove</a>
						 <a href="{{asset('com_pdf').'/'.$item}}" target="_blank" style="font-weight: bold;text-decoration:none;padding-left: 70px;">Open</a>
					  </div>
					@endif
                  @endforeach
                  @endif
               </div>
				<div class="input submit" style="margin: 15px 0;">
            		<div class="col-md-offset-2 col-md-6 submit" style="padding: 0px 0 0 12px;">
                    	<input class="btn btn-success" type="submit" value="Submit">
                    </div>
         		</div>
			</div>
         </div>
      </div>
      {!! Form::close() !!}
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
@endsection
@section('script')
<script type="text/javascript">
  var valuation='{{$valuation->id}}';
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
   function remove(id){
    event.preventDefault();
     $.post("{{route('pdf_remove')}}",{pdf_id:id,valuation:valuation},function(result){
        if(result.status==true){
              toastr.success(result.msg,"Success");
              $('#vl_pdf_'+id).empty(); 
          } else{
            toastr.error(result.msg,"Error");
        }
     });  
   }  
</script>
@endsection