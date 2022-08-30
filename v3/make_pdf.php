<?php
include_once("src/defalt.php");
require_once('tcpdf/tcpdf.php');
include_once 'amount_to_word.php';
include "qrcode/qrlib.php";
if($_SERVER['REQUEST_METHOD']=="POST")
{	   
	$data=$_POST;
	$error=$valid->check_empty($data,array('report_id'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
		$id=$data['report_id'];
		 $query="select finances.*,valuations.name AS valuationsname,declerations.name AS declerations,staff.sort_name AS staff  From finances 
				left join valuations on finances.valuatation_by=valuations.id
				LEFT JOIN declerations  ON declerations.id= finances.notice 
				LEFT JOIN staff ON staff.name= finances.staff_name
				where finances.id=".$id;
        $FinanceData['Finance']=$exe->getsinglequery($query);
        $query2="select * From headers";
        $FinanceData['header']=$exe->getsinglequery($query2);
        if($FinanceData['Finance']){
        	$old=$FinanceData['Finance']['pdf_file'];
        	$objs    = new toWords();
			$obj=$objs->toWord((int) filter_var($FinanceData['Finance']['fair_amount'], FILTER_SANITIZE_NUMBER_INT));
        	$filename=generatepdf($FinanceData,$obj);
        	if($filename){
        		$data1['pdf_file']=$filename;
        		$result=$exe->update('finances',$data1,'id',$data['report_id']);
        		if($result=="true"){
					unlink('../uploads/finance/pdf/'.$old);
					$arr = explode("-", $FinanceData['Finance']['refenence_no']);
					 if(!empty($arr[0])&& !empty($arr[1])){
 						 $first = $arr[0];
						  $sql1="SELECT firebase_id FROM users WHERE employe_id Like '$first%'";
						  $fire=$exe->getsinglequery($sql1);
						   if(!empty($fire['firebase_id'])){
							 fcmnotification($fire['firebase_id'],$FinanceData['Finance']['registration_no']);   
						   }
					    }
					$temp['ref_id']=$data['report_id'];
					$temp['fileurl']='uploads/finance/pdf/'.$filename;
					$error= "Sucssfully Updated";
					$status = true;
					$code   = "200";	
				}else{
					$error=$result;
				}
        	}else{
        		$error="Somthin Went Wrong";
        	}
        }else{
        	$error="Nodata Found";
        }
	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
function generatepdf($FinanceData,$obj){
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrcode/temp'.DIRECTORY_SEPARATOR;
	$PNG_WEB_DIR = 'qrcode/temp/';
	include "qrlib.php";   
	$filename1 = $PNG_TEMP_DIR.'test5.png';
	$filename = strtotime('now').'.pdf';
	QRcode::png('https://www.arvindampro.in/uploads/finance/pdf/'.$filename, $filename1,'L',3,0);
	$videos=null;
	$video1 = $PNG_TEMP_DIR.'video1.png';
	$video2 = $PNG_TEMP_DIR.'video2.png';
	if(!empty($FinanceData['Finance']['videos'])){
		$videos=json_decode($FinanceData['Finance']['videos'],true);
		QRcode::png('https://www.arvindampro.in/uploads/videos/'.$videos[0], $video1,'L',4,0);
		QRcode::png('https://www.arvindampro.in/uploads/videos/'.$videos[1], $video2,'L',4,0);	
	}
	
	
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,array(400, 300), true, 'UTF-8', false);
$pdf->SetTitle('Finance book');
		$pdf->SetAuthor('cjcj');
		$lg = Array();
		$l['a_meta_charset'] = 'UTF-8';
		$l['a_meta_dir'] = 'ltr';
		$l['a_meta_language'] = 'en';
		$lg['w_page'] = 'page';
		// set some language-dependent strings (optional)
		$pdf->setLanguageArray($lg);
		//$pdf->setPrintHeader('Accept-Ranges: bytes');
		$pdf->setPrintHeader(false);
		$pdf->SetFont('freesans', '', 15,'false');
		// --------------------------------------------------------
		// set font
		$pdf->AddPage();
		ob_start();
		$html = "";
		$x = 115;
$y = 35;
$w = 25;
$h = 50;
$pdf->Image('../uploads/image/'.$FinanceData['header']["logo"],15, 10, 40, 29, 'PNG');
$html = '<table>
						<tr>							
							<td colspan="6" style="text-align:center;"> 
								<span style="font-size:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>'.$FinanceData["header"]["authorizer_name"].'</strong></span><sub>'.$FinanceData["header"]["authorizer_education"].'</sub><br>
							<span style="text-align:center;padding-right: 20%; font-size:12px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$FinanceData["header"]["authorizer_designation"].' </span>
							<br><br><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$FinanceData["header"]["report_heading"].' REPORT </strong>
							</td>
							<td colspan="2" style="font-size:12px;"> 
								<br> MOBILE NO : '.$FinanceData["header"]["mobile_number"].'
								<br> LICENCE NO : '.$FinanceData["header"]["licence_no"].'
								<br> VALIDITY : '.$FinanceData["header"]["expire"].'
								<br> EMAIL:'.$FinanceData["header"]["email1"].'
								<br>&nbsp;'.$FinanceData["header"]["email2"].'
							</td>
						</tr>
					</table>
					<br>
					<br>
					
					<table cellspacing="0" cellpadding="2" border="1" style="font-size:14px!important;">
						<tr>
							<td style="width:22%;"> Ref. No </td>
							<td style="width:62%; font-size:14px!important;"> '.$FinanceData['Finance']['refenence_no'].' </td>
							<td style="width:8%;"> Staff </td>
							<td style="width:8%;"> '.$FinanceData['Finance']['staff'].' </td>
						</tr>
						<tr>
							<td> Valuation Initiated By </td>
							<td colspan="5"><strong> '.$FinanceData['Finance']['valuationsname'].'</strong> </td>
						</tr>
						<tr>
							<td> Financer Representative </td>
							<td colspan="5"> '.ucfirst($FinanceData['Finance']['financer_representative']).'</td>
						</tr>
						<tr>
							<td> Place of Valuation </td>
							<td colspan="5"> '.ucfirst($FinanceData['Finance']['place_of_valuation']).'</td>
						</tr>
						<tr >
							<td><strong> Registration No.</strong> </td> 
							<th style="width:37.5%; top:15px; height:25px; font-size:16px;"><strong > '.$FinanceData['Finance']['registration_no'].'</strong></th>
							<td style="width:20%;"> Application No</td>
							<td style="width:20.5%;"> '.$FinanceData['Finance']['appliction_no'].' </td>
						</tr>
					</table>
						<br>
						<br>
						<table cellspacing="0" cellpadding="2" border="1" style="width:100%;">
						<tr >
							<td colspan="2" style="width:22%;"><strong style="font-size:14px;"> Make & Model</strong> </td> 
							<th colspan="3" style="font-size:14px;"> <strong>'.$FinanceData['Finance']['make_model'].'</strong></th>
							<td colspan="2" style="width:28%;"> <strong style="font-size:14px;">Date of Report </strong> </td>
							<td colspan="1" style="font-size:14px;"> '.date("d-m-Y" ,$FinanceData['Finance']['report_date']). '</td>
						</tr>
						<tr >
							<td colspan="2"><strong style="font-size:14px;"> Chassis Number</strong> </td> 
							<th colspan="3"><strong style="font-size:14px;"> '.$FinanceData['Finance']['chachees_number'].'</strong></th>
							<td colspan="2"> <strong style="font-size:14px;">Date of Inspection</strong> </td>
							<td colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['inspection_date']. '</td>
						</tr>
						<tr >
							<td colspan="2"><strong style="font-size:14px;"> Engine No.</strong> </td> 
							<th colspan="3"><strong style="font-size:14px;"> '.$FinanceData['Finance']['engine_number'].'</strong></th>
							<td colspan="2"> <strong style="font-size:14px;">Registration Date </strong> </td>
							<td colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['registration_date']. '</td>
						</tr>
						
						<tr >
							<td colspan="2"><strong style="font-size:14px;"> Registered Owner</strong> </td> 
							<th colspan="3"><strong style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['registerd_owner']).'</strong></th>
							<td colspan="2"><strong style="font-size:14px;"> Colour</strong> </td>
							<th colspan="1" style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['color']).'</th>
							
						</tr>
						<tr >
							<td colspan="2"><strong style="font-size:14px;"> Finance Taken By</strong> </td> 
							<th colspan="3"><strong style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['financed_by']).'</strong></th>
							<td colspan="2"><strong style="font-size:14px;"> Seating Capacity</strong> </td>
							<th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['seating_capacity'].'</th>
						</tr>
						<tr >
							<td colspan="2"> <strong style="font-size:14px;">Tax Paid Upto </strong> </td>
							<td colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['tax_paid']. '</td>
							<td colspan="2"><strong style="font-size:14px;"> Regd. Laden Wt.(Kg)</strong> </td>
							<th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['laden_wt'].'</th>
							
						</tr>
					
						<tr >
							<td colspan="2"><strong style="font-size:14px;"> Hypothecation</strong> </td> 
							<th colspan="3" style="font-size:14px;"> <strong>'.$FinanceData['Finance']['hypothecation'].'</strong></th>
							<td colspan="2"><strong style="font-size:14px;"> Regd. Unladen Wt.(Kg)</strong> </td>
							<td colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['unladen_wt'].'</td>
						</tr>
						
						<tr>
							<td colspan="2"><strong> Policy No.</strong> </td> 
							<th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['policy_no'].'</th>
							<td colspan="2"><strong> Fuel Used</strong> </td>
							<td colspan="1" style="font-size:14px;"> '.ucfirst($FinanceData['Finance']['fule_used']).'</td>
						</tr>
						<tr>
							<td colspan="2"><strong> Validity</strong> </td> 
							<th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['validity'].'</th>					
							<td colspan="2"><strong> Owner Serial No.</strong> </td> 
							<th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['owner_serial_number'].'</th>
						</tr>
						<tr>
							<td colspan="2"><strong> Policy Type</strong> </td> 
							<th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['policy_type'].'</th>
							<td colspan="2"><strong> Cubic Capacity (CC/Bhp)</strong> </td> 
							<th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['cube_capacity'].'</th>
						</tr>
						
						<tr >
							<td colspan="2"><strong> SUM Insured(IDV)</strong> </td> 
							<th colspan="3" style="font-size:14px;"> '.$FinanceData['Finance']['sum_insured'].'</th>
							<td colspan="2"><strong> MM Reading (Km/Hour)</strong> </td>
							<th colspan="1" style="font-size:14px;"> '.$FinanceData['Finance']['mm_reading'].'</th>
						</tr>
						
						<tr>
							<td colspan="5" rowspan="7">
						';
						if(!empty($FinanceData["Finance"]['approve_photo'])){
							$pdf->SetHeaderData('', 1,$FinanceData['Finance']['registration_no'], '');
							$pdf->setPrintHeader(true);
						}
						$html .='		<table border="1" cellpadding="1" cellspacing="3">
									<tr>
										<td colspan="3"> Right Tyres </td>
										<td colspan="3"> Left Tyres </td>
									</tr>
									<tr>
										<td style="font-size:10px; text-align:center;"> Quantity </td>
										<td style="font-size:10px; text-align:center;"> Company </td>
										<td style="font-size:10px; text-align:center;"> Percentage </td>
										<td style="font-size:10px; text-align:center;"> Quantity </td>
										<td style="font-size:10px; text-align:center;"> Company </td>
										<td style="font-size:10px; text-align:center;"> Percentage </td>
									</tr>
									';
						if(!empty($FinanceData["Finance"]["left_tyer_quantity"])){
                            		$rowSpan = count(array_filter(json_decode($FinanceData["Finance"]["left_tyer_quantity"])));
                            		
                            		$left_tyer_company = json_decode($FinanceData["Finance"]["left_tyer_company"]);
                                    $left_quality = json_decode($FinanceData["Finance"]["left_quality"]);
                                    $right_tyer_quantity = json_decode($FinanceData["Finance"]["right_tyer_quantity"]);
                                    $right_tyer_company = json_decode($FinanceData["Finance"]["right_tyer_company"]);
                                    $right_quality = json_decode($FinanceData["Finance"]["right_quality"]);
                                    $a = array_filter(json_decode($FinanceData["Finance"]["left_tyer_quantity"])); 
                                    $html2 = "";
                                foreach($a as  $key => $tyerData){
                                    //$html .= "<th> </th>";
                                    $html2 .= "<tr>";
                            
                                    
                                    if(!empty($right_tyer_quantity[$key])){
                                    	$html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$right_tyer_quantity[$key].'</th>';
                                    }
                                    if(!empty($right_tyer_company[$key])){
                                    	$html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$right_tyer_company[$key].'</th>';
                                    }

                                    if(!empty($right_quality[$key])){
                                    	$html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$right_quality[$key].'</th>';
                                    }
                                     
                                     if(!empty($tyerData)){
                                    	$html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$tyerData.'</th>';
                                	}
                                	if(!empty($left_tyer_company[$key])){
                                    	$html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$left_tyer_company[$key].'</th>';
                                	}
                                	if(!empty($left_quality[$key])){
                                    	$html2 .= '<th style="text-align:center;font-size:10px;" class="tg-us36">'.$left_quality[$key].'</th>';
                                    }
                                    //if($key > $rowSpan){
                                    	//$html .= 'dfs';
                                    //}
                                	$html2 .= '</tr>';
                                }
                                 $html .= $html2;
                            }
						$html .= '
								</table>
							</td>
							<td colspan="2"><strong> Battery</strong> </td>
							<th colspan="1" style="font-size:13px;"> '.$FinanceData['Finance']['battery'].'</th>
						</tr>
						<tr>
							<td colspan="2"><strong> Radiator</strong> </td>
							<th colspan="1" style="font-size:13px;"> '.$FinanceData['Finance']['radiator'].'</th>
						</tr>
						<tr>
							
							<td colspan="2"> <strong>AC </strong> </td>
							<td colspan="1"> '.ucfirst($FinanceData['Finance']['ac']).' </td>
						</tr>
						
						<tr>
							
							<td colspan="2"> <strong>Power Steering </strong> </td>
							<td colspan="1"> '.ucfirst($FinanceData['Finance']['power_steering']).' </td>
						</tr>
						<tr>
							<td colspan="2"><strong> Power Window</strong> </td>
							<th colspan="1"> '.ucfirst($FinanceData['Finance']['power_window']).'</th>							
						</tr>
						<tr>
							<td colspan="2"> <strong>Air Bag </strong> </td>
							<td colspan="1"> '.ucfirst($FinanceData['Finance']['air_bag']).' </td>
							
						</tr>
						</table>';
						 $html .= '<br><br><table cellpadding="2" border="1" >
                           	<tr>
							<td ><strong style="font-size:11px; text-align:center;"> Engine <br>Condition</strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Cooling <br> System </strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Suspension <br> System </strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Electrical <br> System </strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Wheel & <br> Tyres </strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Chassis </strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Cabin & Body Ext. </strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Condition of  Interiors </strong></td>
							<td ><strong style="font-size:11px; text-align:center;"> Glasses </strong></td>							
							<td ><strong style="font-size:11px; text-align:center;"> Paint </strong></td>							
							
						</tr> 

						<tr>
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_engine_condition']).'</td>
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_cooling_system']).'</td>
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_suspension_system']).'</td>	
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_electrical_system']).'</td>
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_wheel']).'</td>
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_chassis']).'</td>
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_cabin']).'</td>
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_condition_of_interiors']).'</td>							
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_glass']).'</td>							
							<td style="text-align:center;"> '.ucfirst($FinanceData['Finance']['c_paint']).'</td>							
							
						</tr>
						</table>
						<br>
						<br>
						<table border="1" cellpadding="7" style="width:100%;">
						<tr>
							<td style="width:20%;"><strong> General Comment</strong></td>
							<td style="font-size:10px; width:80%;">'.$FinanceData['Finance']['general_comment'].'</td>
						</tr>
                           </table>
                    	';
                    	    $a = "";
                  
					$html .= '
					<br>
					<br>
					<strong style="font-size:13px;"> CHASSIS IMPRESSION:- </strong>
						<div style="border:1px solid black;">
							'; 
							if($FinanceData["Finance"]["stamp_show"] == 1){
					$html .='
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  src="../uploads/image/st.jpg" width="80" height="60" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					';
						}else{
							if(!empty( $FinanceData["Finance"]["chachees_number_photo"])){
								$html .='
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								';			
							}else{
								$html .='
									<br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								';
							}	
						}
					$html .= '
							&nbsp;&nbsp;&nbsp;<img src="../uploads/finance/'.$FinanceData["Finance"]["chachees_number_photo"].'" width="350" height="70" style="margin:2px" />
							<br>
						</div>	
					
					<table border="1" cellpadding="3">
						<tr> 
							<td width="22%;"> Fair Market Price(Rs.)  </td>
							<td width="78%" >
							<strong> ' .$FinanceData["Finance"]['fair_amount'].' ( '.$obj.') </strong>
							</td>
						</tr>
					</table>
					<div style="padding-top:2px; font-size:10px;">
					' .$FinanceData["Finance"]["declerations"].'
					</div>
					<br>		
					<table>
					<tr>
						<td width="85%"><strong>&nbsp;&nbsp;Arvind Kumar Mittal</strong></td>
						<td rowspan="2"><img src="'.$PNG_WEB_DIR.basename($filename1).'" width="50" height="50"/></td>
					</tr>
					<tr>
						<td width="85%">&nbsp;&nbsp;Valuer, Surveyor & Loss Assessor </td>
					</tr>
				
					</table>';		
					if((!empty($FinanceData["Finance"]['approve_photo']))  ){
						$html .= '<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						';
					}
$pdf->WriteHTML($html, true, false, false, false, '');
$htmlregistration = "<div>".
			$FinanceData['Finance']['registration_no']."
		</div>";
		$k = 1;
		$pdf->SetAlpha(0.5);
		
		$pdf->SetAlpha(1);
		//$htmll .= "";
		$anotherKey = 2; 
		$key1 = 0;
		$a = 0;
		$x = 0;
		$y = 0;
		$w = 0;
		$d = 0;
		$htmll = "";
		$ll=array(4,5,6,7,12,13,14,15,21,22,23,24);
		$imgtem=[];
		//pr($FinanceData["Finance"]['approve_photo']);die;
		if(!empty($FinanceData["Finance"]['approve_photo'])){
			$thirdKey = 0;
			$lastPhoto = count(json_decode($FinanceData["Finance"]['approve_photo']));
			foreach( json_decode($FinanceData["Finance"]['approve_photo']) as $key => $data ){
				$source_img = "../uploads/finance/".$data;
				$destination_img = '../uploads/tmp/'.$key.$FinanceData['Finance']['id'].'destination.jpg';
				$imgtem[]=$key;
				$comimg = compress($source_img, $destination_img,20);
				$image = $destination_img;
				if($key == 0){
					$x = 20;
					$y = 10;
				}else{
					if($key == 2){
						$x = 20;
						$y = 100;
					}else if($key == 3){
						$x = 150;
						$y = 100;	
					}else if($key == 4){
						$x = 20;
						$y = 190;	
					}else if($key == 5){
						$x = 150;
						$y = 190;	
					}else if($key == 6){
						$x = 20;
						$y = 280;	
					}else if($key == 7){
						$x = 150;
						$y = 280;	
					}else if($key == 8){
						$x = 20;
						$y = 300;	
					}else if($key == 9){
						$x = 150;
						$y = 10;	
					}else if($key == 10){
						$x = 20;
						$y = 100;	
					}else if($key == 11){
						$x = 150;
						$y = 100;	
					}else if($key == 12){
						$x = 20;
						$y = 190;	
					}else if($key == 13){
						$x = 150;
						$y = 190;	
					}else if($key == 14){
						$x = 20;
						$y = 280;	
					}else if($key == 15){
						$x = 150;
						$y = 280;	
					}else if($key == 16){
						$x = 20;
						$y = 300;	
					}else if($key == 17){
						$x = 150;
						$y = 10;		
					}else if($key == 18){
						$x = 20;
						$y = 100;	
					}else if($key == 19){
						$x = 150;
						$y = 100;	
					}else if($key == 20){
						$x = 20;
						$y = 190;	
					}else if($key == 21){
						$x = 150;
						$y = 190;	
					}else if($key == 22){
						$x = 20;
						$y = 280;	
					}else if($key == 23){
						$x = 150;
						$y = 280;	
					}else{
						$x = 150;
						$y = 10;
					}					
				}
							
				if($key == 3){
					$thirdKey = 3;
				}

				$pdf->Image($image,$x,$y, 130, 90, '', '', '', false, 300, '', false, false, 0);
             	
				if($FinanceData["Finance"]["stamp_show"] == 1){
					if( ($key == 2) && ($lastPhoto == 2) ){
						$lastPhoto = 3;
						$pdf->Image('../uploads/image/st.jpg', 40, 80, 40, 40, '', '', '', false, 300, 'C');
					}else if(($thirdKey == 3) ){
						$pdf->Image('../uploads/image/st.jpg', 40, 80, 40, 40, '', '', '', false, 300, 'C');
					}else if(($key == 1)){
						$pdf->Image('../uploads/image/st.jpg', 40, 80, 40, 40, '', '', '', false, 300, 'C');						
					}
					if(in_array($key,$ll)){
						$pdf->Image('../uploads/image/st.jpg', 140, 260, 40, 40, '', '', '', false, 300, 'C');						
					}
				}
			}
		}
			if($videos!=null){
					$htmll.='<br pagebreak="true" /><table>
					<tr>
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
					</tr>
					<tr>
						<td align="center"><a href="https://www.arvindampro.in/uploads/videos/'.$videos[0].'">Video 1</a></td>
						<td align="center"><a href="https://www.arvindampro.in/uploads/videos/'.$videos[1].'">Video 2</a></td>
					</tr>
					<tr>
						<td align="center"><img src="'.$PNG_WEB_DIR.basename($video1).'"/></td>
						<td align="center"><img src="'.$PNG_WEB_DIR.basename($video2).'"/></td>
					</tr>
					
					
					</table>';			  
			}
				
$pdf->WriteHTML($htmll, true, false, false, false, '');	

$pdf_string = $pdf->Output('pseudo.pdf', 'S');
file_put_contents('../uploads/finance/pdf/'.$filename, $pdf_string);
ob_end_flush();
ob_end_clean();
foreach ($imgtem as $key => $value) {
	unlink( '../uploads/tmp/'.$value.$FinanceData['Finance']['id'].'destination.jpg');	
}
return $filename;
}
function compress($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}
function fcmnotification($token,$msg){
$title = "AutoSwift";
$body = 'Report has been Generated for Registration No "'.$msg.'"';
$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
$data = json_encode($arrayToSend);
$url = 'https://fcm.googleapis.com/fcm/send';
$server_key = 'AAAAt7BVyrM:APA91bEsKXBsy0l7FNDs8t073Qfk2pxGvUBAHbdx7dy2erdXjeLgnywxLUqt2Yt1UshoY6WAgon05Yz3xSPfj2fv4K7syBuhjfiAymmUFQ3xw_erN0vwpLStlVEgNroVVe9o09jwaEO0';
$headers = array(
    'Content-Type:application/json',
    'Authorization:key='.$server_key
);
//CURL request to route notification to FCM connection server (provided by Google)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
if ($result === FALSE) {
}
curl_close($ch);
return $result;
}
?>