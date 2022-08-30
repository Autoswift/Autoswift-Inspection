var employe_id=0;
var token;
$(document).ready(function(){
      token=localStorage.getItem("atad");
      if(token){
         auth();
        setInterval(function(){
           auth();
        },60000);
      }else{
          window.location='signin.html';
      }
  });
function auth(){
   token=localStorage.getItem("atad");
  $.ajax({
          type:"POST",
          url:"../v3/auth.php",
          headers: {'x-api-key':  token },
          success: function(response){
            if(response.code==408){
                localStorage.removeItem("atad");
                window.location='signin.html';
            }else{
              $('#user_log').text(response.name);
			  $('#comp_name').text(response.company_name);
			  $('#comp_name').css('font-size','x-large');
				
			 if(response.photo){
                $('.prfil-img img').attr('src','../uploads/image/'+response.photo);
              }
               employe_id=response.employe_id;
            }
          },
          error: function(jqXHR) {
             if(jqXHR.status){
                localStorage.removeItem("atad");
                window.location='signin.html';
             }
            }
        });
  }
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
					   url: '../v3/profile.php',
					   type: 'POST',
					   headers: {'x-api-key': token },
					   dataType: "json",
					   contentType: false,
					   processData: false,
					   data: UploadImg,
					   success: function(response){
						  if(response.status==true){
							 toastr.success(response.message,"success");
						   }else{
							toastr.error(response.message,"Error");
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