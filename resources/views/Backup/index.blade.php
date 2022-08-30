@extends('layouts.header')
@section('title', "All Backup's")
@section('style')
<style type="text/css">
  .col-lg-6{
  padding-right: 0px!important;
  padding-left: 0px!important;
}
.col-md-12{
  padding-right: 10px;
  padding-left: 10px;
}
</style>
@endsection
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>All Backup's</small>
               <a href="{{route('fullbackup')}}" class="btn btn-default" style="float:right;margin-right: 10px;">Full</a>
               <a href="{{route('databasebackup')}}" class="btn btn-default" style="float:right;margin-right: 10px;">Database</a>
               <a href="{{route('filebackup')}}" class="btn btn-default" style="float:right;margin-right: 10px;">Code</a>
               <a href="#" class="btn btn-default" style="float:right;margin-right: 10px;" id="photo_backup">Photos</a>
            </h1>

            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li>
                  <i class="fa fa-bell"></i>Settings                        
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> All Backup's
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
                     <tr>
                        <th style="text-align:center;">#</th>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Extenstion</th>
                        <th>Date/Time</th>
                        <th>Created</th>
                        <th style="text-align:center;">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($files as $key => $val)
                       <tr>
                       
                         <td style="text-align:center;">{{$key+1}}</td>
                         <td>{{$val['name']}}</td>
                         <td>{{$val['size']}}</td>
                         <td>{{$val['extension']}}</td>
                          <td>{{$val['time']}}</td>
                         <td>{{$val['create']}}</td>

                         <td style="text-align:center;">
                           <a href="{{route('downlaodbackup',$val['name'])}}" title="Download"><i class="fa fa-download"></i></a>
                           <a href="" data-toggle="modal" data-target="#{{$val['name']}}deleteModal" title="Delete"><i class="fa fa-trash"></i></a>
                           <div id="{{$val['name']}}deleteModal" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">Are You Sure ?</h4>
                            <p>Do you really want to delete these records? This process cannot be undone.</p>
                          </div>
                          <div class="modal-footer">
                            {!! Form::open(['method' => 'DELETE', 'action' => ['MakeBackup@deletebackup', $val['name']]]) !!}
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
<div id="photo_backup_model" class="delete-modal modal fade" role="dialog">
   <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <form method="post" action="{{route('image_backup')}}">
        @csrf
         <div class="modal-content">
            <div class="modal-body text-center">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group" style="overflow: hidden;">
                        {!! Form::label('Form Date', 'Form Date*',['class' => 'col-md-12']) !!}
                        <div class="col-md-12">
                           <input type="text" id="form_date"
                              class="form-control pickadate"
                              name="form_date" 
                              placeholder="Form Date" data-validation-required-message="Please enter Form Date" maxlength="12" required>
                           <div class="error-message"> </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group" style="overflow: hidden;">
                        {!! Form::label('To Date', 'To Date*',['class' => 'col-md-12']) !!}
                        <div class="col-md-12">
                           <input type="text" id="to_date"
                              class="form-control pickadate"
                              name="to_date" 
                              placeholder="To Date" data-validation-required-message="Please enter to date" maxlength="12" required>
                           <div class="error-message"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
               <button type="submit" class="btn btn-danger">Yes</button>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  
 var table=$('table').DataTable({
      "order": [[ 1, "desc" ]]
 });
 $(".pickadate").datepicker({
        dateFormat: 'dd-mm-yy',
        
   });
  $( ".pickadate" ).prop('autocomplete','off');
 $('#form_date').on('change',function(){
          endDate = $('#form_date').datepicker('getDate'); 
        $("#to_date").datepicker("option", "minDate", endDate); 
   })
 $('#photo_backup').click(function(){
    $('#photo_backup_model').modal('show');
 }) 
</script>
@endsection