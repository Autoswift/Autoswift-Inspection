<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{ 
  $url = constant("url");
  $data = json_decode(file_get_contents('php://input'), true);
  if(!empty($data['user_id']))
  { 
      $limit='';
      if(!empty($data['limit'])){
          $limit= 'LIMIT '.$data['limit']; 
      }
       $where="";
      $sql="Select position,employe_id from users where id=".$data['user_id'];
      $res=$exe->getsinglequery($sql);
      if(!empty($res['position']) && $res['position']=='Employe'){
          $where="and refenence_no LIKE '".$res['employe_id']."%'";
      }else if(!empty($res['position']) && $res['position']=='Admin'){
         $sql="SELECT valuations.id AS valuatation_by from valuations,users WHERE users.company_name=valuations.name AND users.id=".$data['user_id'];
          $res1=$exe->getsinglequery($sql);
          if(!empty($res1['valuatation_by'])){
            $where="and valuatation_by=".$res1['valuatation_by']; 
          }else{
             $where="and refenence_no LIKE '".$res['employe_id']."%'"; 
          }
      }
	  $query= "SELECT finances.id,finances.user_id,finances.created,finances.registration_no,finances.make_model,finances.financed_by,finances.refenence_no,finances.pdf_file,finances.form_pdf,valuations.name as companyname,users.name,users.position from finances 
left JOIN valuations ON valuations.id = finances.valuatation_by 
left JOIN users ON users.id = finances.user_id where mobile_data=1 $where ORDER BY id desc $limit";
	$result=$exe->getallquerydata($query);
	if(isset($result)){
	    $temp=$result;
	   foreach ($result as $key => $value) {
	        $temp[$key]['date']=date('d-m-Y',strtotime($value['created']));
	        unset($temp[$key]['created']);
	         if($result[$key]['position']=='Employe'){
                $temp[$key]['position']='Mobile Executive'; 
              }
              if($result[$key]['position']=='Admin'){
                 $temp[$key]['position']='Mobile Admin'; 
              }
            if(!empty($result[$key]['form_pdf'])){
               $temp[$key]['form_pdf']=$url.'uploads/finance/form_pdf/'.$result[$key]['form_pdf'];   
            }
             if(!empty($result[$key]['pdf_file'])){
               $temp[$key]['pdf_file']=$url.'uploads/finance/pdf/'.$result[$key]['pdf_file'];   
            }
	    }
	    
		$error= "Sucssfully";
        $status = true;
        $code   = "200";
	}else{
		$error= "No Data Found";
	}
  }    	
	echo json_encode(array("data" => $temp, "method" =>"Report data","success" => $status, "message" => $msg));	
}
?>