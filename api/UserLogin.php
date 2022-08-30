<?php
   include_once("src/defalt.php");
   
   if($_SERVER['REQUEST_METHOD']=="POST")
   {    
        $data = $_POST;
        $fields=array("username",'password','device_id','firebase_id','location');
        $error = $valid->check_extrafields($data,$fields);
    if(!$error){
        $error = $valid->check_empty($data, array("username",'password'));
        if(!$error){
            $data=$exe->escape_stringdata($data);
            $sql="SELECT users.*,valuations.id AS valuation_by FROM users  LEFT JOIN valuations ON users.company_name=valuations.name WHERE username='".$data['username']."'";
            $result=$exe->getsinglequery($sql);
             if($result){
                if($result['position']!='SuperAdmin'){
                       if(!empty($result['device_id'])){
                           if($result['device_id']==$data['device_id']){
                               if($result['pass1']==$data['password']){
								    	  unset($data['password']);
                                          $res=$exe->update('users',$data,'id',$result['id']);
                                          $temp['id']=$result['id'];
                                          $temp['profile_name']=$result['profile_name'];
                                          $temp['name']=$result['name'];
                                          $temp['employe_id']=$result['employe_id'];
                                          $temp['position']=$result['position'];
                                          $temp['firebase_id']=$result['firebase_id'];
                                          $temp['ref_start']=$result['ref_start'];
                                          $temp['comp_id']=$result['valuation_by'];
                                              if($result['position']=='Employe'){
                                                  $temp['is_user']=0;
                                              }
                                              if($result['position']=='SuperAdmin'){
                                                  $temp['is_user']=1;
                                              }
                                              if($result['position']=='Admin'){
                                                 $temp['is_user']=2;
                                              }
                                          $error= "Sucssfully";
                                          $status = true;
                                          $code   = "200";
                                    }else{
                                       $error= "Invalid Credentials";
                                    }   
                           }else{
                               $error="User registerd in another device";
                           }
                       }else{
                           if($result['pass1']==$data['password']){
							   			  unset($data['password']);
                                          $res=$exe->update('users',$data,'id',$result['id']);
                                          
                                          $temp['id']=$result['id'];
                                          $temp['profile_name']=$result['profile_name'];
                                          $temp['name']=$result['name'];
                                          $temp['employe_id']=$result['employe_id'];
                                          $temp['position']=$result['position'];
                                          $temp['firebase_id']=$result['firebase_id'];
                                          $temp['ref_start']=$result['ref_start'];
                                          $temp['comp_id']=$result['valuation_by'];
                                              if($result['position']=='Employe'){
                                                  $temp['is_user']=0;
                                              }
                                              if($result['position']=='SuperAdmin'){
                                                  $temp['is_user']=1;
                                              }
                                              if($result['position']=='Admin'){
                                                 $temp['is_user']=2;
                                              }
                                          $error= "Sucssfully";
                                          $status = true;
                                          $code   = "200";
                                    }else{
                                       $error= "Invalid Credentials";
                                    }
                       }                
                  }      
               }
        }   if($result['position']=='SuperAdmin'){
             if($result['pass1']==$data['password']){
                                          unset($data['password']);
				 						  unset($data['device_id']);
				 						  $res=$exe->update('users',$data,'id',$result['id']);	
                                          $temp['id']=$result['id'];
                                          $temp['profile_name']=$result['profile_name'];
                                          $temp['name']=$result['name'];
                                          $temp['employe_id']=$result['employe_id'];
                                          $temp['position']=$result['position'];
                                          $temp['firebase_id']=$result['firebase_id'];
                                          $temp['ref_start']=$result['ref_start'];
                                          $temp['comp_id']=$result['valuation_by'];
                                              if($result['position']=='Employe'){
                                                  $temp['is_user']=0;
                                              }
                                              if($result['position']=='SuperAdmin'){
                                                  $temp['is_user']=1;
                                              }
                                              if($result['position']=='Admin'){
                                                 $temp['is_user']=2;
                                              }
                                          $error= "Sucssfully";
                                          $status = true;
                                          $code   = "200";
                                    }else{
                                       $error= "Invalid Credentials";
                                    }
        }
    }
    echo json_encode(array("data"=>$temp,"message" => $error,"success" => $status,"code" => $code)); 
   }
   
   ?>