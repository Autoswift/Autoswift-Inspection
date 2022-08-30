@extends('layouts.header')
@section('title', 'Home')
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
                               <i class="fa fa-dashboard"></i><a href="/"> Dashboard</a>                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Add Valuation Initiated by
                            </li>
                            <span style="float:right;"><a href="{{route('duplicate.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
                        </ol>
                    </div>
                </div>
                <section class="content container-fluid">
                  @include('layouts.alert');
    </section>
                  {!! Form::model($duplicate, ['method' => 'PATCH', 'action' => ['DuplicateController@update', $duplicate->id]]) !!}      
      <div class="row">
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('reason', 'Duplicate Reason*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('reason', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('reason') }}</div>
               </div>
            </div>
         </div>
         <div class="input submit">
            <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" value="Submit"></div>
         </div>
      </div>
       {!! Form::close() !!}
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
@endsection