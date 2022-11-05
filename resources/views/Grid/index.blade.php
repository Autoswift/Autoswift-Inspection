@extends('layouts.header')
@section('title', 'Autoswift Grid')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Autoswift Grid</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
              <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>
               <li class="active">
                  <i class="fa fa-edit"></i>Autoswift Grid
               </li>
                <span style="float:right;"><a target="_blank" href="{{ route('grid.create')}}"><i class="fa fa-plus"></i> Add Grid</a></span>
                <span style="float:right;"><a href="{{ route('grid_excel')}}" style="color: #28c76f;margin-right: 30px;font-weight: 600;"><i class="fa fa-file-excel-o"></i>Export Excel</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="filter-block">
      	<form id="gridform">
      		<div class="row" style="margin:20px 0;">
         		<div class="col-sm-3 data-field-col">
            		<label for="data-category">Vehicle Make
				  	<button type="button" class="edit_grid_setting" data="vehicle_make"
						  style="border: none;border-radius: 5px;background-color: #8c8c8c;color: #fff;font-size: 14px;"><i class="fa fa-pencil"></i></button>
					</label>
			 		<select class="form-control" id="vehicle_make1" name="vehicle_make">
						<option value="">Select Vehicle Make</option>
                         @foreach($vehicle_make as $item)
                            <option value="{{$item}}">{{$item}}</option>
                         @endforeach;
                    </select>
         		 </div>
                 <div class="col-sm-3 data-field-col">
                    <label for="data-status">Vehicle Model
                        <button type="button" class="edit_grid_setting" data="vehicle_model" 
                                style="border: none;border-radius: 5px;background-color: #8c8c8c;color: #fff;font-size: 14px;"><i class="fa fa-pencil"></i></button>
                    </label>
                    <select name="vehicle_model" class="form-control" id="vehicle_model1" required="">
                       <option value="">First Select Vehicle</option>
                    </select>
                 </div>
                 <div class="col-sm-3 data-field-col">
                    <label for="data-category">Variant
                        <button type="button" class="edit_grid_setting" data="variant"
                            style="border: none;border-radius: 5px;background-color: #8c8c8c;color: #fff;font-size: 14px;"><i class="fa fa-pencil"></i></button>
                    </label>
                    <select name="variant" class="form-control" id="variant1" required="">
                       <option value="">First Select Model</option>
                    </select>
                 </div>
                 <div class="col-sm-3 data-field-col">
                    <label for="data-status">Year</label>
                    <button type="button" class="edit_grid_setting" data="year"
                             style="border: none;border-radius: 5px;background-color: #8c8c8c;color: #fff;font-size: 14px;"><i class="fa fa-pencil"></i></button>
                    <select name="year" class="form-control" id="year1" required="">
                       <option value="">First Select Variant</option>
                    </select>
                 </div>
          	</div>
      	</form>
     </div>    
<br>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped" style="width: 99.9%">
                  <thead>
                     <tr class="header-titles">
                        <th style="width:25px;">S.No.</th>
                        <th>Vehicle Make</th>
                        <th>Vehicle Model</th>
                        <th>Variant</th>
                        <th>Chassis No</th>
                        <th>Year</th>
                        <th>Cost</th>
                        <th>Note</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($grid as $key =>$val)
                       <tr>
                         <td>{{$key+1}}</td>
                         <td>{{$val->vehicle_make  }}</td>
                         <td>{{$val->vehicle_model }}</td>
                         <td>{{$val->variant}}</td>
                         <td>{{$val->chassis_no}}</td>
                         <td>{{$val->year}}</td>
                         <td>{{$val->cost}}</td>
                         <td>{{$val->note}}</td>
                         <td>{{date('d-m-Y',strtotime($val->updated_at))}}</td>
                         <td style="text-align:left;">
                           <a target="_blank" href="{{ route('grid.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['GridController@destroy', $val->id]]) !!}
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
<div class="modal fade text-left" id="grid_setting_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
<div class="modal-content">
  <form method="POST" id="change_grid"> 
  <div class="modal-body">
      <div class="row">
         <div class="col-md-12 col-12">
            <h4 class="modal-title" id="myModalLabel17">GRID</h4>
          <br>
            <div class="form-label-group form-group">
              <input type="text" class="form-control" name="editlslsl" required="" id="grid_edit_input">
               <div class="help-block"></div>
            </div>
         </div>
      </div>   
   </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-defalt waves-effect waves-light" data-dismiss="modal" aria-label="Close">Close
    </button>
   <button type="submit" class="btn btn-info waves-effect waves-light">Change</button>
</div>
  </form> 
</div>
<div>
  @endsection
@section('script')
<script type="text/javascript">
  var table=$('table').DataTable({
    pageLength: 50,
    lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
  });
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
  $(function() {
    $("#change_grid").submit(function(){
      event.preventDefault()
      item = {}
      item[$('#grid_edit_input').attr("name")] = $('#grid_edit_input').val();
      item['old_value'] = value;
      var url = '{{route("grid.update","8")}}'
       $.ajax({
        url:url,
        type:'patch',
        data:item,
        success:function($result){
           if($result.status==true){
              toastr.success($result.msg,"Success");
              setTimeout(function () {
               location.reload();
              },1000)
           }else{
             toastr.error($result.msg,"Error");
           }
        }
       })
    });
      $('.edit_grid_setting').click(function(){
      value =$('#'+$(this).attr('data')+'1').val()
      if(value)
        { 
          $('#myModalLabel17').text(($(this).attr('data')).replace('_',' ').toUpperCase());
          $('#grid_edit_input').attr('name',$(this).attr('data'))
          $('#grid_edit_input').val(value);
          $('#grid_setting_model').modal('show');
        }else{
          toastr.error("Please Select "+$(this).attr('data'),"Error");
        }
      })
        $('#gridform select').change(function() {
            var select
             table.search($(this).val()).draw();
            if($(this).attr('name')=='vehicle_make'){
               var select = $('form select[name=vehicle_model]');
               select.html('<option value="0">Select Vehicle Make</option>');
               $('form select[name=variant]').html('<option value="0">First Select Vehicle Model</option>');
               $('form select[name=year]').html('<option value="0">First Select Variant</option>');

            }
            if($(this).attr('name')=='vehicle_model'){
               var select = $('form select[name=variant]');
                select.html('<option value="0">Select Vehicle Model</option>');
               $('form select[name=year]').html('<option value="0">First Select Variant</option>');
            }
            if($(this).attr('name')=='variant'){
               var select = $('form select[name=year]');
                select.html('<option value="0">Select Variant</option>');
            }
            var url = '{{route("grid.create")}}'
            formdata=$("#gridform select").serialize()
            if(select){
               $.get(url,formdata,function(data) {
                 console.log(data);
                $.each(data,function(key, value) {
                    select.append('<option value="' + key + '">' + value + '</option>');
                });
              });
            }
        });
    });
</script>
@endsection