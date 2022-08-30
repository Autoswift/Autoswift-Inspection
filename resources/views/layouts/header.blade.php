<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta name="google" content="notranslate">
      <title>@yield('title') : AutoSwift</title>
      <link rel="icon" href="{{asset('admin_js_css/images/logo_auto.png')}}">
      <link href="{{asset('/css/jquery-ui.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <link href="{{asset('/css/sb-admin.css') }}" rel="stylesheet"/>
      <link href="{{asset('/css/font-awesome.min.css') }}" rel="stylesheet"/>
      <link href="{{asset('/css/font-awesome.css') }}" rel="stylesheet"/>
      <link href="{{asset('/css/jquery-ui-timepicker-addon.css') }}" rel="stylesheet"/>
      <link href="{{asset('/css/colorbox.css') }}" rel="stylesheet"/>
      <link href="{{asset('/css/morris.css') }}" rel="stylesheet"/>
      <link href="{{asset('/css/MonthPicker.css') }}" rel="stylesheet"/>
      <link href="{{asset('/css/bootstrap-select.css')}}" rel="stylesheet"/>
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/css/toastr.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script type="text/javascript" src="{{asset('/js/jquery-ui.js')}}"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="{{asset('/js/jquery-ui-timepicker-addon.js')}}"></script>
      <script type="text/javascript" src="{{asset('/js/ckeditor/ckeditor.js')}}"></script>
      <script type="text/javascript" src="{{asset('/js/jquery.colorbox-min.js')}}"></script>
      <script type="text/javascript" src="{{asset('/js/jquery.colorbox.js')}}"></script>
      <script type="text/javascript" src="{{asset('/js/plugins/morris/raphael.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('/js/plugins/morris/morris.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('/js/MonthPicker.js')}}"></script>
      <script type="text/javascript" src="{{asset('/js/bootstrap-select.js')}}"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <!--    <script type="text/javascript" src="{{asset('/js/component.js')}}"></script> -->
      <script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
      <!-- <link rel="stylesheet" type="text/css" href="http://www.spiceforms.com/blog/demo/jquery-php-image-crop/crop/css/imgareaselect-default.css" /> -->
      <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
      <script type="text/javascript" src="http://www.spiceforms.com/blog/demo/jquery-php-image-crop/crop/js/jquery.imgareaselect.pack.js"></script>
      <style>
         .switch {
         position: relative;
         display: inline-block;
         width: 60px;
         height: 34px;
         }
         .switch input { 
         opacity: 0;
         width: 0;
         height: 0;
         }
         .slider {
         position: absolute;
         cursor: pointer;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: #ccc;
         -webkit-transition: .4s;
         transition: .4s;
         }
         .slider:before {
         position: absolute;
         content: "";
         height: 26px;
         width: 26px;
         left: 4px;
         bottom: 4px;
         background-color: white;
         -webkit-transition: .4s;
         transition: .4s;
         }
         .navbar-nav > li > a {
         padding: 2px!important;
         }
         input:checked + .slider {
         background-color: #2196F3;
         }
         input:focus + .slider {
         box-shadow: 0 0 1px #2196F3;
         }
         input:checked + .slider:before {
         -webkit-transform: translateX(26px);
         -ms-transform: translateX(26px);
         transform: translateX(26px);
         }
         .pactive{
         color:white!important;
         }
         /* Rounded sliders */
         .slider.round {
         border-radius: 34px;
         }
         .slider.round:before {
         border-radius: 50%;
         }
         .filter-block{
           border: 1px solid rgb(204, 204, 204); padding: 0 0 0 0;
         }
         .sub-header{
           font-size: 50%;
           font-weight: 550;
      	 }
        .page-header small{
          font-size: 85%;
          font-weight: 550;
        }
      </style>
      <style>
         .error{
         	color:red;
         }
         .navbar-inverse .navbar-nav>li>a:focus, .navbar-inverse .navbar-nav>li>a:hover {
           color: white;
           background-color: black;
         }
         .help-block{
         	color:red;
         }
         ul{
         	list-style-type: none;
         }
         table{
            /* font-weight: bold; */
            border-collapse: inherit !important;
         }
		 th{
			text-align: center;
		 }
        .header-titles>th {
            vertical-align: top !important;
         	text-align: left;
         }
        table.dataTable thead th, table.dataTable thead td {
          padding: 10px 10px !important;
      }
		 
      </style>
      @yield('style')
   </head>
   <body>
      <input type="hidden" id="site_baseurl" value='http://arvindam.in' >
      <input type="hidden" id="site_controller" value='users/' >
      <input type="hidden" id="site_base" value='/' >
      <input type="hidden" id="site_pulgin" value='/' >
      <input type="hidden" id="site_prefix" value='/' >
      <div id="">
      <style type="text/css">
         .navbar-nav > li { padding: 1px;}
         .navbar-nav > li > a { padding: 5px;}
         .navbar-inverse .navbar-nav > li > a { color:#000;}
         .navbar-inverse .navbar-nav > li > a:hover { color:#ccc;}
         .navbar-nav { width: 100%; background: #fff; }
         .navbar { 
           background: #384859;
           height: 50px;
         }
         .navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.open>a, .navbar-inverse .navbar-nav>.open>a:focus, .navbar-inverse .navbar-nav>.active>a:focus {
            background-color: #31708F;
         }
         .navbar-inverse .navbar-nav>li>a:hover, .navbar-inverse .navbar-nav>.active>a:hover{
           background-color: #F3F3F3;
           color: #000;
         }
         .user-name {
           	color: #fff;
           	padding: 0 2.5px;
         }
        .dropdown-menu {
    		min-width: 166px;
        }

      </style>
      <div><img src="{{asset('images/tenor.gif')}}" style="
         position: fixed;left: 40%;top: 40%;z-index: 9999; display: none" id="loading-image"></div>
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
         <!-- Brand and toggle get grouped for better mobile display -->
         <div class="navbar-header" style="width: 52%;">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a href="{{route('home')}}" class="navbar-brand" style="float : right;"><img src="{{asset('images/as-logo.png')}}" style="max-width: 89px;max-height: 65px;margin-top: -7px;">
            @php
            preg_match('/([a-z]*)@/i',Route::currentRouteAction(), $matches);
            $controllerName = $matches[1];
            $role=Request::segment(2);
            @endphp
            </a>            
         </div>
         <!-- Top Menu Items -->
         <ul class="nav navbar-right top-nav">
            <li>
               <a href="#" class="dropdown-toggle {{Route::is('profile')?'pactive':''}}{{Route::is('changepassword')?'pactive':''}}" data-toggle="dropdown">
               @php
               $photo=Auth()->user()->photo?Auth()->user()->photo:'img_avatar.png';
               @endphp
               <img src="{{asset('images/users/'.$photo)}}" height="37" width="37" style="border-radius: 60px; border-radius: 50px">  
               <span class='user-name'>{{Auth()->user()->name}}</span>  
               <b class="caret"></b></a>
               <ul class="dropdown-menu">
                  <li class="{{Route::is('profile')?'active':''}}">
                     <a href="{{route('profile')}}"><i class="fa fa-fw fa-user"></i> Profile</a>                        
                  </li>
                  <li>
                  </li>
                  <!-- <li class="{{Route::is('changepassword')?'active':''}}">
                     <a href="{{route('changepassword')}}"><i class="fa fa-fw fa-lock"></i> Change Password</a>                        
                     </li> -->
                  <li class="divider"></li>
                  <li>
                     <a href="{{route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit()"><i class="fa fa-fw fa-sign-out"></i> Log Out</a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                  </li>
               </ul>
            </li>
         </ul>
         <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
         <div class="collapse navbar-collapse navbar-ex1-collapse" style="border-bottom: 2px solid">
            <ul class="nav navbar-nav">
               @can('isSuper')
               <li class="{{Route::is('header.index') || Route::is('declaration.index') || Route::is('valuation.index') || Route::is('duplicate.index')|| Route::is('area.index') || Route::is('grid.index') ?'active':''}}">
                  <a href="#" class="dropdown-toggle {{ $controllerName=='HeaderController'? 'active' : '' }}" data-toggle="dropdown"><i class="fa fa-fw fa-tasks"></i> Addition <i class="fa fa-fw fa-caret-down"></i></a>
                  <ul class="dropdown-menu">
                     <li class="{{ $controllerName=='HeaderController'? 'active' : '' }}">
                        <a href="{{route('header.index')}}">{{_('Header')}}</a>                                
                     </li>
                     <li class="{{ $controllerName=='DeclarationController'? 'active' : '' }}">
                        <a href="{{route('declaration.index')}}">{{_('Declarations')}}</a>                                                                    
                     </li>
                     <li class="{{ $controllerName=='ValuationController'? 'active' : '' }}">
                        <a href="{{route('valuation.index')}}">{{_('Valuations Initiated By')}}</a>                             
                     </li>
                     <li class="{{ $controllerName=='DuplicateController'? 'active' : '' }}">
                        <a href="{{route('duplicate.index')}}">{{_('Duplicate Reasons')}}</a>                                    
                     </li>
                     <li class="{{ $controllerName=='AreaController'? 'active' : '' }}{{ $controllerName=='StateController'? 'active' : '' }}">
                        <a href="{{route('area.index')}}">{{_('States-Cities')}}</a>                                    
                     </li>
                     <li class="{{ $controllerName=='GridController'? 'active' : '' }}">
                        <a href="{{route('grid.index')}}">{{_('Autoswift Grid')}}</a>                                    
                     </li>
                  </ul>
               </li>
               @endcan  
               <!-- <li class="">
                  </li> -->
               <li class="{{ $controllerName=='HomeController'? 'active' : ''  }}">
                  <a href="{{route('home')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>                                     
               </li>
               <li class="{{ $controllerName=='UserController' || $controllerName=='StaffController' ?'active':'' }}">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-users"></i> Employees <i class="fa fa-fw fa-caret-down"></i></a>   
                  <ul class="dropdown-menu">
                     @can('isSuper')
                     <li class="{{ !$role && $controllerName=='UserController' ? 'active' : '' }}">
                        <a href="{{route('users.index')}}">Total Employees</a>                            
                     </li>
                     <li  class="{{ $role=='web_admin'? 'active' : '' }}">
                        <a href="{{route('users.index')}}/web_admin/all">Web Admins (P)</a>                            
                     </li>
                     @endcan
                     <li class="{{ $role=='mobile_executive'? 'active' : '' }}">
                        <a href="{{route('users.index')}}/mobile_executive/all">Mobile Executives (A)</a>                           
                     </li>
                     @can('isSuper')
                     <li class="{{ $role=='mobile_admin'? 'active' : '' }}">
                        <a href="{{route('users.index')}}/mobile_admin/all">Company Admins (P)</a>                            
                     </li>
                     @endcan
                     @can('isSuper')
                     <li class="{{ $role=='company_user'? 'active' : '' }}">
                        <a href="{{route('users.index')}}/company_user/all">Company Executives (P)</a>                           
                     </li>
                     @endcan
                     <li class="{{  $controllerName=='StaffController'? 'active' : '' }}">
                        <a href="{{route('staff.index')}}">Staff</a>                          
                     </li>
                  </ul>
               </li>
               <li class="{{ Route::is('user_notification.index') || Route::is('company_notification.index') ?'active':'' }}">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Notification <i class="fa fa-fw fa-caret-down"></i></a>
                  <ul class="dropdown-menu">
                     <li class="{{ $controllerName=='UserNotificationController'? 'active' : '' }}">
                        <a href="{{route('user_notification.index')}}">User Notification</a>                           
                     </li>
                     <li class="{{ $controllerName=='CompanyNotificationController'? 'active' : '' }}">
                        <a href="{{route('company_notification.index')}}">Company Notification</a>                          
                     </li>
                  </ul>
               </li>
               @can('isSuper')
               <li class="{{Route::is('report.index')?'active':''}}" >
                  <a href="{{route('report.index')}}"><i class="fa fa-fw fa-files-o"></i> Generate Bill</a>                            
               </li>
               @endcan
               <li class="{{Route::is('today_report')?'active':''}}">
                  <a href="{{route('today_report')}}"><i class='fa fa-fw fa-calendar'></i> Today's Reports</a>                    
               </li>
               <li class="{{Route::is('duplicate_report')?'active':''}}">
                  <a href="{{route('duplicate_report')}}"><i class="fa fa-fw fa-tasks"> </i>Duplicate Reports</a>                           
               </li>
               <li class="{{Route::is('mobile_report')?'active':''}}">
                  <a href="{{route('mobile_report')}}"><i class="fa fa-fw fa-mobile"> 
					  
					  </i>Mobile Reports <span class="badge badge-light not_count" style="
    position: absolute;
    margin: -11px -14px;
    background-color: #c81c1c;
">0</span></a>                        
               </li>
               <li class="{{Route::is('old_reports')?'active':''}}">
                  <a href="{{route('old_reports')}}"><i class="fa fa-fw fa-history"> </i>Old Reports</a>                    
               </li>
               <li class="{{Route::is('reject_reports')?'active':''}}">
                  <a href="{{route('reject_reports')}}"><i class="fa fa-fw fa-ban"> </i>Rejected</a>                    
               </li>
               <li class="{{Route::is('report.create')?'active':''}} {{Route::is('report.edit')?'active':''}}">
                  <a href="{{route('report.create')}}"><i class="fa fa-fw fa-plus"></i> Add New Report</a>                      
               </li>
               @can('isSuper')
               <li class="{{Route::is('logs') || Route::is('backup_data') || Route::is('deleted_report') ?'active':''}}">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Settings <i class="fa fa-fw fa-caret-down"></i></a>
                  <ul class="dropdown-menu">
                     <li class="{{Route::is('logs')?'active':''}}">
                        <a href="{{route('logs')}}"><i class="fa fa-fw fa-history"></i>&nbsp;Logs</a>                           
                     </li>
                     <li class="{{Route::is('backup_data')?'active':''}}">
                        <a href="{{route('backup_data')}}"><i class="fa fa-archive" aria-hidden="true"></i>&nbsp;Backup</a>                         
                     </li>
                     <li class="{{Route::is('deleted_report')?'active':''}}">
                        <a href="{{route('deleted_report')}}"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Recycle Bin</a>                         
                     </li>
                  </ul>
               </li>
               @endcan
            </ul>
         </div>
         <!-- /.navbar-collapse -->
      </nav>
      @yield('content')
   </body>
</html>
@yield('script')
<script type="text/javascript" src="{{asset('js/forms/validation/jqBootstrapValidation.js') }}"></script>
<script type="text/javascript" src="{{asset('/js/validation/form-validation.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function(){
     $( ".datepicker" ).datepicker({
       dateFormat: 'dd-mm-yy', 
     });
      $( ".datepicker" ).prop('autocomplete','off');
       $( document ).ajaxSend(function() {
           $('#loading-image').show()
           $('#page-wrapper').css('opacity',0.5)
           setTimeout(function(){
             $('#loading-image').hide()
             $('#page-wrapper').css('opacity','')
           },8000) 
       });
       $( document ).ajaxComplete(function() {
           $('#loading-image').hide()
           $('#page-wrapper').css('opacity','')
       });
   })
   
</script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
<script>
    
     // Initialize Firebase
     // TODO: Replace with your project's customized code snippet
     var config = {
         'messagingSenderId': '788937427635',
         'apiKey': 'AIzaSyCkInVj4z7SCEzXBhukYD4TdcMKpC8sDJg',
         'projectId': 'autoswift-v5',
         'appId': '1:788937427635:web:5da96bd05c18eb7c3e7ec6',
     };
     firebase.initializeApp(config);

     const messaging = firebase.messaging();
     messaging
         .requestPermission()
         .then(function () {
            
             //console.log("Notification permission granted.");
             
             // get the token in the form of promise
             return messaging.getToken()
         })
         .then(function(token) {
             console.log(token)
             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
              if(token!="{{Auth()->user()->firebase_id}}"){
                $.post("{{route('save-token')}}",{token:token},function(result){
                    //console.log(result)
                })
               }
             //TokenElem.innerHTML = "token is : " + token
         })
         .catch(function (err) {
            
             //console.log("Unable to get permission to notify.", err);
         });

     let enableForegroundNotification = true;
     messaging.onMessage(function(payload) {
		 $('.not_count').text(parseInt($('.not_count').text())+1)
   toastr.info(payload.notification.body,payload.notification.title);
      const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
     });
</script>
