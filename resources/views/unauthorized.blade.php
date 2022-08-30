
     
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   <title>
        Fianance :: Login   </title
    <link href="/favicon.ico" type="image/x-icon" rel="icon" /><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" /><link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" /><link rel="stylesheet" type="text/css" href="/css/sb-admin.css" /><link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css" /><link rel="stylesheet" type="text/css" href="/css/font-awesome.css" /><script type="text/javascript" src="/js/jquery.js"></script><script type="text/javascript" src="/js/bootstrap.min.js"></script></head>
<body>
    
        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="/users/login" style="float: left; font-size:18px; height: 50px; line-height: 20px; padding: 15px; color:#9d9d9d;">Finance</a>    </div>
    
</nav>
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
                            <form action="/users/login" role="form" id="UserLoginForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>                                                             <div class="form-group">
                                    <label>Username</label>
                                    <div class="input text"><input name="data[User][username]" class="form-control" placeHolder="Username" type="text" id="UserUsername"/></div>                                 </div>
                                  <div class="form-group">
                                  <label>Password</label>
                                    <div class="input password"><input name="data[User][password]" class="form-control" placeHolder="Password" type="password" id="UserPassword"/></div>                                 </div>
                                <div class="form-group" style="float:left;">
                                    <div class="input submit"><div class="submit"><input  class="btn btn-default" style="width:100px;font-weight:bold;" type="submit" value="Login"/></div></div>                                </div>
                                <a href="/users/forgot" class="" style="float:right;padding:8px">Forgot Password ?</a>                           </form>                        </div>
                       
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
