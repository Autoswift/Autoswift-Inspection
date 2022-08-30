@extends('layouts.header')
@section('title', 'States-Cities')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>States-Cities</small>
        <a href="{{route('state.index')}}" class="btn btn-default" style="float:right;">States</a>                    
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
             
              <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>
                <li class="active">
                  <i class="fa fa-edit"></i> States-Cities
               </li>
               <span style="float:right;"><a href="{{ route('area.create')}}"><i class="fa fa-plus"></i> Add City Or Area</a></span>
               <span style="float:right;"><a href="{{ route('area_excel')}}" style="color: #28c76f;margin-right: 30px;font-weight: 600;"><i class="fa fa-file-excel-o"></i>Export Excel</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="filter-block">
      <form id="stateFilter">
         <div class="row" style="margin:20px 0;">
            <div class="col-sm-3 data-field-col">
               <label for="data-category">States
                  <button type="button" class="edit_grid_setting" data="area_state" style="border: none;border-radius: 5px;background-color: #8c8c8c;color: #fff;font-size: 14px;">
                    <i class="fa fa-pencil"></i>
                 </button>
               </label>
               <select class="form-control" id="area_state" name="area_state">
                  <option value="">Select State</option>
                  @foreach($state as $item)
                  <option value="{{$item}}">{{$item}}</option>
                  @endforeach;
               </select>
            </div>            
            <div class="col-sm-3 data-field-col">
               <label for="data-category">City
                  <button type="button" class="edit_grid_setting" data="city" style="border: none;border-radius: 5px;background-color: #8c8c8c;color: #fff;font-size: 14px;">
                    <i class="fa fa-pencil"></i>
                 </button>
               </label>
               <select name="name" class="form-control" id="name1" required="">
                  <option value="">Select City</option>
               </select>
            </div>
         </div>
      </form>
      </div>
     <br>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped" style="width:99.9%">
                  <thead>
                     <tr class="header-titles">
                        <th style="width:25px;">S.No.</th>
                        <th>State Name</th>
                        <th>City Name</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($area as $key => $val)
                       <tr>
                         <td>{{$key+1}}</td>
                         <td>{{$val->state_name}}</td>
                         <td>{{$val->name}}</td>
                         <td>
                           <a href="{{ route('area.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['AreaController@destroy', $val->id]]) !!}
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
<div class="modal fade text-left" id="area_setting_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
<div class="modal-content">
  <form method="POST" id="change_area"> 
  <div class="modal-body">
      <div class="row">
         <div class="col-md-12 col-12">
            <h4 class="modal-title" id="myModalLabel18">STATES</h4>
          <br>
            <div class="form-label-group form-group">
              <input type="text" class="form-control" name="editlslsl" required="" id="area_edit_input">
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
    $("#change_area").submit(function(){
      event.preventDefault()
      item = {}
      item[$('#area_edit_input').attr("name")] = $('#area_edit_input').val();
      item['old_value'] = value;
      var url = '{{route("area.update","8")}}'
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
          $('#myModalLabel18').text(($(this).attr('data')).replace('_',' ').toUpperCase());
          $('#area_edit_input').attr('name',$(this).attr('data'))
          $('#area_edit_input').val(value);
          $('#area_setting_model').modal('show');
        }else{
          toastr.error("Please Select "+$(this).attr('data'),"Error");
        }
      });
      $('#stateFilter select').change(function() {
        var select
        table.search($(this).val()).draw();
        if($(this).attr('name')=='area_state'){
          var select = $('form select[name=name]');
          select.html('<option value="0">Select City</option>');
        }
        
        var url = '{{route("area.create")}}'
        formdata=$("#stateFilter select").serialize()
        if(select){
          $.get(url,formdata,function(data) {
            $.each(data,function(key, value) {
              select.append('<option value="' + key + '">' + value + '</option>');
            });
          });
        }
      });
    });
</script>
@endsection