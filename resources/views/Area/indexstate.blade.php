@extends('layouts.header')
@section('title', 'States')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>States</small>
               <a href="{{route('area.index')}}" class="btn btn-default" style="float:right;">Cities</a>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
              <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>
               <li>
                States-Cities
              </li>
               <li class="active">
                  <i class="fa fa-edit"></i>States
               </li>
               <span style="float:right;"><a href="{{ route('state.create')}}"><i class="fa fa-plus"></i> Add State</a></span>
            </ol>
         </div>
      </div>
     
        
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped"  style="width: 99.9%">
                  <thead>
                     <tr class="header-titles">
                        <th style="width:25px;">S.No.</th>
                        <th>State Name</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($state as $key => $val)
                       <tr>
                         <td>{{$key+1}}</td>
                         <td>{{$val->name}}</td>
                         <td>
                           <a href="{{ route('state.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['StateController@destroy', $val->id]]) !!}
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
  $('table').DataTable({
    pageLength: 50,
    lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
  });
</script>
@endsection