@extends('layouts.header')
@section('title', 'All Received Notification')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>All Received Notification</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> All Received Notification
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
                        <th>Date</th>
                        <th>Company Name</th>
                        <th>Name</th>
                       
                        <th>Registration No</th>
                        <th>Make&Model</th>
                        <th>Party Name</th>
                        <th>Mobile No</th>
                        <th>Place</th>
                        <th>Payment</th>
                        <th>File</th>
                        <th>Note</th>
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
                         <td>{{isset($val->user->valuation->name)?$val->user->valuation->name:'N/A'}}</td>
                         <td>{{$val->user?$val->user->name:'N/A'}}</td>
                         <td>{{$val->registration_no}}</td>
                         <td>{{$val->make_model}}</td>
                         <td>{{$val->party_name}}</td>
                         <td>{{$val->mobile_no}}</td>
                         <td>{{$val->place}}</td>
                         <td>{{$val->payment}}</td>
                         <td>@if($val->file)
                          <a href="{{$val->file}}" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                          @else
                          N/A
                          @endif
                          </td>
                         <td>{{$val->note}}</td>
                         <td style="text-align:center;">
                           <a href="{{ route('company_notification.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;
                           <a href="#" onclick="return false;" class="sharenote" id="{{$val->id}}" title="share"><i class="fa fa-share-alt" aria-hidden="true"></i></a>&nbsp;
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['CompanyNotificationController@destroy', $val->id]]) !!}
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
   <div class="modal fade text-left" id="sharenote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
     <div class="modal-content">
        <div class="modal-header bg-info white">
           <h2 class="modal-title" id="myModalLabel130">Share</h2>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button>
        </div>
        <form method="POST" id="shareform">
           <div class="modal-body">
              <div class="row">
                 <div class="col-sm-12 data-field-col">
                    <label for="data-name">Company Name</label>
                   
                    <select name="valuations_by" class="form-control" id="valuations_by"  required>
                     <option value="">Select Company</option>
                     @foreach($company as $key => $item)
                      <option value="{{$key}}">{{$item}}</option> 
                     @endforeach  
                    </select>
                 </div>
                 <div class="col-sm-12 data-field-col">
                    <label for="data-name">State</label>
                    <select name="state" class="form-control" id="state">
                       <option value="">First Select Company Name </option>
                    </select>
                 </div>
                 <div class="col-sm-12 data-field-col">
                    <label for="data-name">Area</label>
                    <select name="area_id" class="form-control" id="area_id" required>
                       <option value="">First Select State </option>
                    </select>
                 </div>
                 <div class="col-sm-12 data-field-col">
                    <label for="data-name">Mobile Executive</label>
                    <select name="user_id" class="form-control" id="user_id" required>
                       <option value="">First Select Area </option>
                    </select>
                 </div>
              </div>
              <div class="modal-footer">
                 <button type="submit" class="btn btn-info">Accept</button>
              </div>
           </div>
        </form>
     </div>
  </div>
   <!-- /.container-fluid -->
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  $('table').DataTable();
  $(document).on('click','.sharenote',function(){
    $("#shareform").trigger('reset');
    $('#sharenote').modal('show');
    $('<input>').attr({type: 'hidden',id: 'note_id',name: 'note_id',value:$(this).attr('id')}).appendTo('#shareform');
  })
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
  $(function() {
        $('#shareform').submit(function(event){
          event.preventDefault();
          var url = '{{ route("sharenote") }}';
          formdata=$("#shareform").serialize()
          $.post(url,formdata,function(response) {
              if(response.status==true){
                toastr.success(response.msg,"Success");
              } else{
                toastr.error(response.msg,"Error");
              }
              $("#shareform").trigger('reset');
              $('#sharenote').modal('hide');
          });
        })
        $('select').change(function() {
            var select
            if($(this).attr('name')=='valuations_by'){
               var select = $('form select[name=state]');
               select.html('<option value="0">Select State</option>');
               $('form select[name=user_id]').html('<option value="0">Please First Select Area</option>');
               $('form select[name=area_id]').html('<option value="0">Please First Select State</option>');
            }
            if($(this).attr('name')=='state'){
               var select = $('form select[name=area_id]');
                select.html('<option value="0">Select Area</option>');
               $('form select[name=user_id]').html('<option value="0">Please First Select Area</option>');
            }
            if($(this).attr('name')=='area_id'){
               var select = $('form select[name=user_id]');
                select.html('<option value="0">Select Executive</option>');
            }
            if($(this).attr('name')=='user_id'){
              return false;
            }
            url = '{{ route("getcomparea") }}';
            formdata=$("#shareform").serialize()
            $.post(url,formdata,function(data) {
                $.each(data,function(key, value) {
                    select.append('<option value=' + key + '>' + value + '</option>');
                });
            });
        });
    });
  
</script>
@endsection