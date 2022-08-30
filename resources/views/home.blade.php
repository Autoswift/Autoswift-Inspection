@extends('layouts.header')
@section('title', 'Dashboard')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               Dashboard <small class="sub-header">Statistics Overview</small>
            </h1>
            <ol class="breadcrumb">
               <li class="active">
                  <i class="fa fa-dashboard"></i> Dashboard
               </li>
            </ol>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
         </div>
      </div>
      <div class="row">
         @can('isSuper')
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary" style="border-color: #aeaeaf;">
               <div class="panel-heading" style="background-color: #74568e;border-color: #a0a0a0;">
                  <div class="row">
                     <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                     </div>
                     <div class="col-xs-9 text-right">
                        <div class="huge">{{$dashboard[0]->admin}}</div>
                        <div>Web Admins!</div>
                     </div>
                  </div>
               </div>
               <a href="#">
                  <div class="panel-footer">
                     <span class="pull-left">
               <a href="{{route('users.index')}}/web_admin/all">View Details</a></span> 
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
               </div>
               </a>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary" style="border-color: #aeaeaf;">
               <div class="panel-heading" style="background-color: #c5835e;border-color: #a0a0a0;">
                  <div class="row">
                     <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                     </div>
                     <div class="col-xs-9 text-right">
                        <div class="huge">{{$dashboard[0]->mobile_admin}}</div>
                        <div>Mobile-Company Admins!</div>
                     </div>
                  </div>
               </div>
               <a href="#">
                  <div class="panel-footer">
                     <span class="pull-left">
               <a href="{{route('users.index')}}/mobile_admin/all">View Details</a></span> 
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
               </div>
               </a>
            </div>
         </div>
         @endcan
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-xs-3">
                        <i class="fa fa-mobile fa-5x"></i>
                     </div>
                     <div class="col-xs-9 text-right">
                        <div class="huge">{{$dashboard[0]->employe}}</div>
                        <div>Mobile Executives!</div>
                     </div>
                  </div>
               </div>
               <a href="#">
                  <div class="panel-footer">
                     <span class="pull-left">
               <a href="{{route('users.index')}}/mobile_executive/all">View Details</a></span> 
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
               </div>
               </a>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                     </div>
                     <div class="col-xs-9 text-right">
                        <div class="huge">{{$today}}</div>
                        <div>Today's Reports!</div>
                     </div>
                  </div>
               </div>
               <a href="#">
                  <div class="panel-footer">
                     <span class="pull-left">
               <a href="{{route('today_report')}}">View Details</a></span> 
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
               </div>
               </a>
            </div>
         </div>
         <!-- /.row -->
      </div>
     <!--  <div id="token"></div>
    <div id="msg"></div>
    <div id="notis"></div>
    <div id="err"></div> -->
      <!-- /.container-fluid -->
      <div class="container" style="float: left;background-color: #e4e4e3;">
         <div class="row justify-content-center">
            <div class="col-md-12">
               <div class="card">
                  <!-- <div class="card-header">Dashboard</div> -->
                  <div class="card-body">
                     <!--  <h1>{{ $chart1->options['chart_title'] }}</h1> -->
                     {!! $chart1->renderHtml() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script>
      $('body').attr('id','');
      $('body').attr('style','');
   </script>    
</div>

{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
@endsection