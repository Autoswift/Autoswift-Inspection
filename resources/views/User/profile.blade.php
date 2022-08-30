@extends('layouts.header')
@section('title', 'Profile')
@section('style')
<style type="text/css">
   input[type=file] {
   display:none;
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
               <small>Profile</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Profile
               </li>
               <span style="float:right;"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Back</a></span>
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
                        <div class="col-6 col-md-4">
                           <div class="media">
                              <a href="javascript: void(0);">
                                 @php
                                 if(Auth()->user()->photo){
                                    $photo=Auth()->user()->photo;
                                 }else{
                                    $photo='img_avatar.png';
                                 }
                                 @endphp
                              <img src="{{asset('images/users')}}/{{$photo}}" class="rounded mr-75" alt="profile image" height="100" width="100" id="user-img" style="border-radius: 50px;">
                              </a>
                              <div class="media-body mt-75" style="padding: 17px 0 0 0;">
                                 <h4 class="media-heading" id="fullname"></h4>
                                 <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                    <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer change-button" for="account-upload">Upload new photo</label>
                                    <input type="file" id="account-upload" hidden="" name="profile_pic">
                                    <button class="btn btn-sm btn-outline-warning ml-50 remove-reset">Remove</button>
                                 </div>
                                 <p class="text-muted ml-75 mt-50"><small>Allowed JPG,JPEG or PNG. Max
                                    size of
                                    800kB</small>
                                 </p>
                              </div>
                              <hr>
                           </div>
                        </div>
                        <div class="col-6 col-md-6">
                        <form id="settingupdate" method="POST" action="{{route('profile')}}">
                           @csrf
                           <div class="col-6">
                              <div class="form-group">
                                 <div class="controls">
                                    <label for="account-name">Name</label>
                                    <input type="text" class="form-control" placeholder="name : ex.angelole"  name="name" required data-validation-required-message="This name field is required" id="name" value="{{Auth()->user()->name}}">
                                    @error('name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror   
                                 </div>
                              </div>
                           </div>
                          <!--  <div class="col-6">
                              <div class="form-group">
                                 <div class="controls">
                                    <label for="account-username">User Name </label>
                                    <input type="text" class="form-control" placeholder="Username ex.adoptionism744"  name="username" required data-validation-required-message="This username field is required" id="username" value="{{Auth()->user()->username}}">
                                     @error('username')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror  
                                 </div>
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="form-group">
                                 <div class="controls">
                                    <label for="account-e-mail">Mobile Number</label>
                                    <input type="number" class="form-control" placeholder="mobile_number : +91 9898363790" name="mobile_number" id="mobile_number" required data-validation-required-message="This Mobile field is required" value="{{Auth()->user()->mobile_number}}">
                                    @error('mobile_number')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror 
                                  </div>    
                              </div>
                           </div>
                           <div class="col-12 hideadmin">
                              <div class="form-group">
                                 <label for="account-company">Reference Number</label>
                                 <input type="text" class="form-control" name="employee_id" placeholder="Employe id ex. XY-AM" id="employee_id" required data-validation-required-message="This Reference field is required" value="{{Auth()->user()->employee_id}}">
                                 @error('employe_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror   
                              </div> 
                           </div>
                           <div class="col-6 hideadmin">
                              <div class="form-group">
                                 <label for="account-company">Reference Start From</label>
                                 <input type="text" class="form-control" name="ref_start" placeholder="Employe id ex.1" id="ref_start" required data-validation-required-message="This Reference field is required" value="{{Auth()->user()->ref_start}}">
                                 @error('ref_start')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror   
                              </div>
                           </div> -->
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
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
@endsection
@section('script')
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