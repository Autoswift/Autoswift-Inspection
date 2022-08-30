@extends('layouts.header')
@section('title', 'All Notification')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>All Notification</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="/"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> All Notification
               </li>
               <span style="float:right;"><a href="{{ route('user_notification.create')}}"><i class="fa fa-plus"></i> Add Notification</a></span>
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
                     <tr>
                        <th style="text-align:center;">#</th>
                        <th>Date</th>
                        <th>Company Name</th>
                        <th>Executive Name</th>
                        <th>Area</th>
                        <th>Registration No</th>
                        <th>Make&Model</th>
                        <th>Party Name</th>
                        <th>Mobile No</th>
                        <th>Place</th>
                        <th>Payment</th>
                        <th style="text-align:center;">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                    @php $i=0; @endphp
                      @foreach($notification as $val)
                        @php $i++; @endphp
                       <tr>
                         <td style="text-align:center;">{{$i}}</td>
                         <td>@php echo date('d-m-Y',strtotime($val->created_at)) @endphp</td>
                         <td>{{$val->valuation?$val->valuation->name:'N/A'}}</td>
                         <td>{{isset($val->user->name)?$val->user->name:'N/A'}}</td>
                         <td>{{isset($val->area->name)?$val->area->name:'N/A'}}</td>
                         <td>{{$val->registration_no}}</td>
                         <td>{{$val->make_model}}</td>
                         <td>{{$val->party_name}}</td>
                         <td>{{$val->mobile_no}}</td>
                         <td>{{$val->place}}</td>
                         <td>{{$val->payment}}</td>
                         <td style="text-align:center;">
                           <a href="{{ route('user_notification.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
                           <a href="" data-toggle="modal" data-target="#{{$val->id}}deleteModal" title="Delete"><i class="fa fa-trash"></i></a>
                           <div id="{{$val->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">Are You Sure ?</h4>
                            <p>Do you really want to delete these records? This process cannot be undone.</p>
                          </div>
                          <div class="modal-footer">
                            {!! Form::open(['method' => 'DELETE', 'action' => ['UserNotificationController@destroy', $val->id]]) !!}
                                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
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
@section('script')
<script type="text/javascript">
  $('table').DataTable();
</script>
@endsection