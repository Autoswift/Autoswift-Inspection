   
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fianance :: Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/css/sb-admin.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!--End Bootstrap Core CSS -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 

</head>
<body>
<div id="page-wrapper">
    <div class="container-fluid">
     <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-4 col-md-offset-4">
                        <h1 class="page-header">
                            Finance Management</small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->
         <div class="row">
            
            <div class="col-lg-4 col-md-offset-4" style="padding:50px 0px">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-sign-in fa-fw"></i> Login</h3>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <form method="POST" action="{{ route('login') }}">
                                 @csrf
                                <div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>                                                             <div class="form-group">
                                    
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('UserName') }}</label>
                                    <div class="input text"><input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="login" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    </div>  
                                    @error('username')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                               
                                </div>
                                  <div class="form-group">
                                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    <div class="input password"><input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    </div>
                                    @error('password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                                 </div>
                                <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                                <div class="form-group" style="float:left;">
                                    <div class="input submit"><div class="submit"><button type="submit" class="btn btn-default" style="width:100px;font-weight:bold;">
                                    {{ __('Login') }}
                                </button>

                                </div></div>                                </div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="float:right;padding:8px">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                                          </form>                        </div>
                       
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>       
   
</body>
</html>
