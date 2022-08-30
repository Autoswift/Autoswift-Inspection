var token;
var pos;
$(document).ready(function(){
      token=localStorage.getItem("avdtoken");
      if(token){
         $.ajax({
          type:"POST",
          url:"v3/auth.php",
          headers: {'x-api-key':  token },
          success: function(response){
            if(response.code==408){
                localStorage.removeItem("avdtoken");
                window.location='auth-login.html';
            }else{
                pos=response.position;
              $('.user-name').text(response.name);
                  if(response.position!='SuperAdmin'){
                    $('.webadmin').remove();
            		$('.mobileadmin').remove();
            		$('.hideadmin').empty();
					  myarray=['headers.html','decleration.html','valuation.html','area.html','duplicate_reason.html','users.html','admin_users.html','mobile_admin.html','reports.html','comp_user.html','grid.html'];
					 if(myarray.indexOf(location.pathname.split('/').slice(-1)[0])!= -1){
					 	window.location='auth-login.html';
					 } 
                  }
                $(".loading_op").removeClass("loading_op")
    	        $(".loding").hide();
              if(response.photo){
                $('.round').attr('src','uploads/image/'+response.photo);
              }
            }
          },
          error: function(jqXHR) {
             if(jqXHR.status){
                localStorage.removeItem("avdtoken");
                window.location='auth-login.html';
             }
            }
        });
      }else{
          window.location='auth-login.html';
      }
      setInterval(function(){
         auth();
      },60000);
 });  
function auth(){
   token=localStorage.getItem("avdtoken");
  $.ajax({
          type:"POST",
          url:"v3/auth.php",
          headers: {'x-api-key':  token },
          success: function(response){
            if(response.code==408){
                localStorage.removeItem("avdtoken");
                window.location='auth-login.html';
            }
          },
          error: function(jqXHR) {
             if(jqXHR.status){
                localStorage.removeItem("avdtoken");
                window.location='auth-login.html';
             }
            }
        });
	
  }