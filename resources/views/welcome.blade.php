@extends('layouts.header')
@section('title', 'Home')
@section('content')
<div id="page-wrapper">
         <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
               <div class="col-lg-12">
                  <h1 class="page-header">
                     Dashboard <small>Statistics Overview</small>
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
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                              <div class="huge">70</div>
                              <div>Total Employees!</div>
                           </div>
                        </div>
                     </div>
                     <a href="#">
                        <div class="panel-footer">
                           <span class="pull-left">
                     <a href="/users/alluser">View Details</a></span> 
                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                     <div class="clearfix"></div>
                     </div>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                              <div class="huge">9</div>
                              <div>Admins!</div>
                           </div>
                        </div>
                     </div>
                     <a href="#">
                        <div class="panel-footer">
                           <span class="pull-left">
                     <a href="/users/alluser/Active/Administrator">View Details</a></span> 
                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                     <div class="clearfix"></div>
                     </div>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                              <div class="huge">61</div>
                              <div>Mobile Executives!</div>
                           </div>
                        </div>
                     </div>
                     <a href="#">
                        <div class="panel-footer">
                           <span class="pull-left">
                     <a href="/users/alluser/Active/Employe">View Details</a></span> 
                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                     <div class="clearfix"></div>
                     </div>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6">
                  <div class="panel panel-red">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-3">
                              <i class="fa fa-tasks fa-5x"></i>
                           </div>
                           <div class="col-xs-9 text-right">
                              <div class="huge">0</div>
                              <div>Today's Reports!</div>
                           </div>
                        </div>
                     </div>
                     <a href="#">
                        <div class="panel-footer">
                           <span class="pull-left">
                     <a href="/finances">View Details</a></span> 
                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                     <div class="clearfix"></div>
                     </div>
                     </a>
                  </div>
               </div>
               <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
         </div>
         <script>
            $('body').attr('id','');
            $('body').attr('style','');
         </script>    
      </div>
@endsection      