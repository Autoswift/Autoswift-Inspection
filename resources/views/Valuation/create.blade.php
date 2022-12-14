@extends('layouts.header')
@section('title', 'Add Valuation')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Add Valuation Initiated by</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
                <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Add Valuation Initiated by
               </li>
               <span style="float:right;"><a href="{{route('valuation.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
       @include('layouts.alert')
       </section>
      {!!Form::open(['method' => 'POST', 'action' => 'ValuationController@store','files' => true]) !!}      
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
               {!! Form::label('short_name', 'Initials*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('short_name', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('short_name') }}</div>
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
               <div class="col-md-6">
                  {!! Form::file('gridpdf[]',array('accept'=>'application/pdf','multiple'=>'multiple'), ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('gridpdf') }}</div>
               </div>
            </div>
         </div>
         <!-- <div class="input submit">
            <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" ></div>
         </div> -->
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