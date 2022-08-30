@extends('layouts.header')
@section('title', 'Headers')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Header</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
              <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>   
               <li class="active">
                  <i class="fa fa-edit"></i>Header
               </li>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped">
                  <thead>
                     <tr class="header-titles">
                        <th>S.No.</th>
                        <th>Mobile No</th>
                        <th>Licence No</th>
                        <th>Validity</th>
                        <th>IIISLA No</th>
                        <th>Email-1</th>
                        <th>Email-2</th>
                        <th>Authorizer  Name</th>
                        <th>Authorizer Education</th>
                        <th>Authorizer Designation</th>
                        <th>Report Heading</th>
                        <th>Logo</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($header as $val)
                       <tr>
                         <td style="text-align:center;">{{$val->id}}</td>
                         <td>{{$val->mobile_number}}</td>
                         <td>{{$val->licence_no}}</td>
                         <td>{{$val->expire}}</td>
                         <td>{{$val->iisla_no}}</td>
                         <td>{{$val->email1}}</td>
                         <td>{{$val->email2}}</td>
                         <td>{{$val->authorizer_name}}</td>
                         <td>{{$val->authorizer_education}}</td>
                         <td>{{$val->authorizer_designation }}</td>
                         <td>{{$val->report_heading}}</td>
                         <td><img src="{{asset('image')}}/{{$val->logo}}" width="100px" height="50px"></td>
                         <td style="text-align:center;">
                           <a href="{{ route('header.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
                    </div>
                        </td>
                     </tr>
                  @endforeach   
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
</div>
@endsection