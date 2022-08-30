<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login : AutoSwift</title>
	   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <link rel="icon" href="{{asset('admin_js_css/images/logo_auto.png')}}">
      <link rel="stylesheet" type="text/css" href="https://brandio.io/envato/iofrm/html/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="https://brandio.io/envato/iofrm/html/fontawesome-all.min.css">
      <link rel="stylesheet" type="text/css" href="https://brandio.io/envato/iofrm/html/css/iofrm-style.css">
      <link rel="stylesheet" type="text/css" href="https://brandio.io/envato/iofrm/html/css/iofrm-theme6.css">
	   
	   <style>
		   .field-icon {
            float: right;
            margin-top: -41px;
            position: relative;
            z-index: 2;
            padding: 0 10px 0 0;
            cursor: pointer;
         }

	   </style>
   </head>
   <body style="background-color: #27343e;">
      <div class="form-body">
         
         <div class="row">
            <div class="img-holder">
               <div class="bg"></div>
               <div class="info-holder">
				   <a href="" style="display: inline-block;background-color: white;border-radius: 15px;">
					   <!-- <img class="logo-size" src="{{asset('images/logo_auto.png')}}" alt="scd" style="width: 150px !important;"> -->
						<img class="logo-size" src="{{asset('images/newlogoauto.png')}}" alt="scd" style="width: 150px !important;">
				   </a>
                  <img src="https://brandio.io/envato/iofrm/html/images/graphic2.svg" alt="">
               </div>
            </div>
            <div class="form-holder">
               <div class="form-content">
                  <div class="form-items">
                     <h3>Finance Management</h3>
                     <p>Access to the most powerfull tool in the entire design and web industry.</p>
                     @error('username')
                     <span class="text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror  
                     <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input class="form-control @error('username') is-invalid @enderror" type="text" name="login" placeholder="Username" {{ old('username') }} required>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Password" required>
							<i class="fa fa-eye field-icon open" id="toggle-password" aria-hidden="true"></i>
						 	
                        @error('password')
                        <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror       
                        <div class="form-button">
                           <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                           <label class="form-check-label" for="remember">
                           {{ __('Remember Me') }}
                           </label>
                           &nbsp; &nbsp; &nbsp; &nbsp;<button id="submit" type="submit" class="ibtn">Login</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="https://brandio.io/envato/iofrm/html/js/jquery.min.js"></script>
      <script src="https://brandio.io/envato/iofrm/html/js/popper.min.js"></script>
      <script src="https://brandio.io/envato/iofrm/html/js/bootstrap.min.js"></script>
      <script src="https://brandio.io/envato/iofrm/html/js/main.js"></script>
	 <script>
	   $(document).ready(function(){

		   	$("#toggle-password").click(function(){
				var input = $('#password').attr('type');
				if (input == "password") {
					$('#password').attr("type", "text");
				  } else {
					$('#password').attr("type", "password");
				  }
		  	});

	   });
	   </script>
	   
   </body>
</html>