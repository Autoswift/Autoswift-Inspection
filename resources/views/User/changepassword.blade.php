@extends('layouts.header')
@section('title', 'Home')
@section('content')
<style type="text/css">
   input[type=file] {
   display:none;
   }
</style>
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Change Password</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Change Password
               </li>
               <span style="float:right;"><a href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
         @include('layouts.alert')
       
      </section>
      <div class="card">
         <div class="card-content">
            <div class="card-body">
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                     <div class="row">
                       
                        <form id="settingupdate" method="POST" action="{{route('changepassword')}}">
                           @csrf
                           <div class="col-6 col-md-4">
                              <div class="form-group">
                                 <div class="controls">
                                    <label for="account-name">OLD Password</label>
                                    <input type="password" class="form-control" placeholder=""  name="old_password" required data-validation-required-message="This Old Password field is required" id="old_password">
                                    @error('old_password  ')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                                 </div>
                              </div>
                           </div>
                           <div class="col-6 col-md-4">
                              <div class="form-group">
                                 <div class="controls">
                                    <label for="account-username">New Password</label>
                                    <input type="password" class="form-control"   name="new_password" required data-validation-required-message="This New Password field is required" id="new_password" >
                                    @error('new_password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                                 </div>
                              </div>
                           </div>
                           <div class="col-6 col-md-4">
                              <div class="form-group">
                                 <div class="controls">
                                    <label for="account-e-mail">Confirm  Password</label>
                                    <input type="password" class="form-control"  name="password_confirmation" id="password_confirmation" required data-validation-required-message="This Confirm Password field is required" >
                                    @error('confirmed')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror   
                                  </div>    
                              </div>
                           </div>
                          
                           <div class="col-6 d-flex flex-sm-row flex-column justify-content-end">
                              <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                              changes</button>
                              <button type="reset" class="btn btn-outline-warning">Cancel</button>
                           </div>
                        </form>
                    
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<script type="text/javascript">
   function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#user-img').attr('src', e.target.result);
              $('.change-button').removeAttr('for');
              $('.change-button').text('Update');
              $('.change-button').attr('onclick','uplodeimg()');
              $('.remove-reset').text('Reset');
          }
          reader.readAsDataURL(input.files[0]);
      }
   }
   $("#account-upload").change(function() {
      readURL(this);
   });
    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
   });
   $('.remove-reset').click(function(){
        uplodeimg();
        $('#user-img').attr('src','{{asset("images/users/img_avatar.png")}}') 
   }) 
   function uplodeimg(){
        var file = $("input[name='profile_pic']")[0].files[0];
        var UploadImg = new FormData();
        UploadImg.append("profile_pic", file);
         $.ajax({
           url: '{{route("updateimage")}}',
           type: 'POST',
           dataType: "json",
           contentType: false,
           processData: false,
           data: UploadImg,
           success: function(response){
              if(response.status==true){
                 toastr.success(response.msg,"success");
               }else{
                toastr.error(response.msg,"Error");
               }
           $('.change-button').attr('for',"account-upload");
           $('.change-button').text('Upload new photo');
           $('.change-button').removeAttr('onclick');
           $('.remove-reset').text('Remove'); 
           }
        });
      }   
</script>
@endsection