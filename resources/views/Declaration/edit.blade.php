@extends('layouts.header')
@section('title', 'Edit Declaration')
@section('content')
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading --> 
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           <small>Edit Declaration</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                               <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            </li>
                             <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>  
                            <li class="active">
                                <i class="fa fa-edit"></i> Edit Declaration
                            </li>
                            <span style="float:right;"><a href="{{route('declaration.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
                        </ol>
                    </div>
                </div>
                <section class="content container-fluid">
                  @include('layouts.alert');
    </section>
                  {!! Form::model($declaration, ['method' => 'PATCH', 'action' => ['DeclarationController@update', $declaration->id]]) !!}      
      <div class="row">
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('note', 'Declaration*',['class' => 'col-md-2']) !!}
               <div class="col-md-8">
                  {!! Form::textarea('note', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('note') }}</div>
               </div>
            </div>
         </div>
         <!-- <div class="input submit">
            <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" value="Submit"></div>
         </div> -->
		   <div class="input submit">
            <div class="col-md-offset-2 col-md-6 submit" style="padding: 0 0 0 24px;">
				<input class="btn btn-success" type="submit" value="Submit">
			 </div>
         </div>
      </div>
       {!! Form::close() !!}
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
@endsection