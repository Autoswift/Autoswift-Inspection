<!DOCTYPE HTML>
<html>
   <head>
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="keywords" content="Autoswift" />
      <title> Company Portal : AutoSwift</title>
      <link rel="icon" href="{{asset('admin_js_css/images/logo_auto.png')}}">
      <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
      <!-- Bootstrap Core CSS -->
      <link href="{{asset('admin_js_css/css/bootstrap.min.css')}}" rel='stylesheet' type='text/css' />
      <!-- Custom CSS -->
      <link href="{{asset('admin_js_css/css/style.css')}}" rel='stylesheet' type='text/css' />
      <link rel="stylesheet" href="css/morris.css" type="text/css"/>
      <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
      <!-- Graph CSS -->
      <link href="{{asset('admin_js_css/css/font-awesome.css')}}" rel="stylesheet">
      <!-- jQuery -->
      <script src="{{asset('admin_js_css/js/jquery-2.1.4.min.js')}}"></script>
      <!-- //jQuery -->
      <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
      <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
      <!-- lined-icons -->
      <link rel="stylesheet" href="{{asset('admin_js_css/css/icon-font.min.css')}}" type='text/css' />
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/css/toastr.css">
      <!-- //lined-icons -->
      <style type="text/css">
         .profile_details{
         width: 30.25%;
         float: right;
         }
         ul.dropdown-menu.drp-mnu i.fa{
         margin-top: -6px;
         }
         table th {
         color: black;
         }         
      </style>
   </head>
   <body>
      <div class="page-container">
         <!--/content-inner-->
         <div class="left-content" style="width:100%">
            <div class="mother-grid-inner">
               <!--header start here-->
               <div class="header-main">
                  <a href="{{route('company_home')}}">
                     <div class="logo-w3-agile" style="widht:11.25%">
                        <img src="{{asset('images/logo_auto.png')}}" style="width: 70px;height: 38px;">
                     </div>
                  </a>
                  <div class="w3layouts-right" style="width: 55%;height: 70px;">
                     <div class="user-name">
                        <p id="comp_name" style="font-size: x-large;">{{\App\Valuation::find(Auth()->user()->comp_id)->value('name')}}</p>
                     </div>
                  </div>
                  <div class="profile_details w3l" style="float:left;width: 7.48%;height: 70px;">
                     <label class="btn btn-sm upload-img ml-50 mb-50 mb-sm-0 cursor-pointer change-button" for="account-upload"><span class="prfil-img"><img src="{{asset('images/users/')}}/{{Auth()->user()->photo?Auth()->user()->photo:'img_avatar.png'}}" alt="" id="pf_image"> </span></label>
                     <input type="file" id="account-upload" hidden="" name="profile_pic" style="display:none">
                  </div>
                  <div class="profile_details w3l" style="width:23.25%; height:70px;">
                     <ul>
                        <li class="dropdown profile_details_drop">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <div class="profile_img">
                                 <div class="user-name">
                                    <p id="user_log">{{Auth()->user()->name}}</p>
                                    <span>Company User</span>
                                 </div>
                                 <i class="fa fa-angle-down"></i>
                                 <i class="fa fa-angle-up"></i>
                                 <div class="clearfix"></div>
                              </div>
                           </a>
                           <ul class="dropdown-menu drp-mnu">
                              <li> <a href="{{route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit()"><i class="fa fa-sign-out"></i> Logout</a> </li>
                           </ul>
                        </li>
                     </ul>
                  </div>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                  </form>
                  <div class="clearfix"> </div>
               </div>
               <!--heder end here-->
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('company_home')}}">Home</a><i class="fa fa-angle-right"></i>Dashboard</li>
               </ol>
               <div class="agile-grids">
                  <!-- tables -->
                  <div class="four-grids">
                     <div class="col-md-6 four-grid">
                        <div class="four-agileits">
                           <a href="#" data-toggle="modal" data-target="#myModal">
                              <div class="icon">
                                 <i class="glyphicon fa fa-plus" aria-hidden="true"></i>
                              </div>
                              <div class="four-text">
                                 <h3>Make New Notification</h3>
                              </div>
                           </a>
                        </div>
                     </div>
                     <div class="col-md-6 four-grid">
                        <div class="four-agileinfo">
                           <a href="{{route('company_notification')}}">
                              <div class="icon">
                                 <i class="glyphicon fa fa-bell" aria-hidden="true"></i>
                              </div>
                              <div class="four-text">
                                 <h3>All Notification</h3>
                              </div>
                           </a>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                     <!-- Modal content-->
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <h4 class="modal-title">Send New Notification</h4>
                        </div>
                        <div class="modal-body">
                           <form id="notification_form" method="post" action="{{route('company_notification_send')}}">
                              @csrf
                              <div class="vali-form">
                                 <div class="col-md-12 form-group2 group-mail"></div>
                                 <div class="clearfix"> </div>
                                 <div class="col-md-6 form-group1 form-last ">
                                    <label class="control-label">Registration Number</label>
                                    <input type="text" placeholder="Registration Number" name="registration_no" id="registration_no" required="">
                                 </div>
                                 <div class="col-md-6 form-group1 form-last">
                                    <label class="control-label">Make Model</label>
                                    <input type="text" placeholder="Make Model" name="make_model" id="make_model" required="">
                                 </div>
                                 <div class="col-md-12 form-group2 group-mail"></div>
                                 <div class="clearfix"> </div>
                                 <div class="col-md-6 form-group1">
                                    <label class="control-label">Party Name</label>
                                    <input type="text" placeholder="Party Name" name="party_name" id="party_name" required="">
                                 </div>
                                 <div class="col-md-6 form-group1 form-last">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" placeholder="Mobile Number" name="mobile_no" id="mobile_no" required="">
                                 </div>
                                 <div class="col-md-12 form-group2 group-mail"></div>
                                 <div class="clearfix"> </div>
                                 <div class="col-md-6 form-group1">
                                    <label class="control-label">Place</label>
                                    <input type="text" placeholder="Place" name="place" id="place" required="">
                                 </div>
                                 <div class="col-md-6 form-group1 form-last">
                                    <label class="control-label">Payment</label>
                                    <input type="text" placeholder="Payment" name="payment" id="payment" required="">
                                 </div>
                                 <div class="col-md-12 form-group2 group-mail"></div>
                                 <div class="clearfix"> </div>
                              </div>
                              <div class="clearfix"> </div>
                              <div class="col-md-12 form-group">
                                 <button type="submit" class="btn btn-primary">Submit</button>
                                 <button type="reset" class="btn btn-default">Reset</button>
                              </div>
                              <div class="clearfix"> </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <!--//w3-agileits-pane-->  
               <!-- script-for sticky-nav -->
               <script>
                  $(document).ready(function() {
                      var navoffeset=$(".header-main").offset().top;
                      $(window).scroll(function(){
                        var scrollpos=$(window).scrollTop(); 
                        if(scrollpos >=navoffeset){
                           $(".header-main").addClass("fixed");
                        }else{
                           $(".header-main").removeClass("fixed");
                        }
                      });
                      
                  });
               </script>
               <!-- /script-for sticky-nav -->
               <!--inner block start here-->
               <div class="inner-block">
               </div>
               <!--inner block end here-->
               <!--copy rights start here-->
               <!--COPY rights end here-->
            </div>
         </div>
         <!--//content-inner-->
         <!--/sidebar-menu-->
         <div class="clearfix"></div>
      </div>
      <script>
         var toggle = true;
                  
         $(".sidebar-icon").click(function() {                
           if (toggle)
           {
            $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
            $("#menu span").css({"position":"absolute"});
           }
           else
           {
            $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
            setTimeout(function() {
              $("#menu span").css({"position":"relative"});
            }, 400);
           }
                     
                     toggle = !toggle;
                  });
      </script>
      <!--js -->
      <script src="{{asset('admin_js_css/js/jquery.nicescroll.js')}}"></script>
      <script src="{{asset('admin_js_css/js/scripts.js')}}"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="{{asset('admin_js_css/js/bootstrap.min.js')}}"></script>
      <!-- /Bootstrap Core JavaScript -->    
      <!-- morris JavaScript --> 
      <script src="{{asset('admin_js_css/js/raphael-min.js')}}"></script>
      <script src="{{asset('admin_js_css/js/morris.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
      <script src="{{asset('admin_js_css/js/Chart.js')}}"></script>
   </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
<script type="text/javascript">
   $( ".pickadate" ).datepicker({
        dateFormat: 'dd-mm-yy', 
    });
    $( ".pickadate" ).prop('autocomplete','off');
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
     function readURL(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function(e) {
               $('#pf_image').attr('src', e.target.result);
            var file = $("input[name='profile_pic']")[0].files[0];
            var UploadImg = new FormData();
            UploadImg.append("profile_pic", file);
            UploadImg.append("profile", true);
             $.ajax({
                  url: "{{route('profile_image')}}",
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
                  }
            });
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   $("#account-upload").change(function() {
       readURL(this);
   });
</script>
@if(Session::has('success'))
<script type="text/javascript"> toastr.success("{{session('success')}}","Success");</script>
@elseif(Session::has('error'))
<script type="text/javascript"> toastr.error("{{session('error')}}","Error");</script>
@endif