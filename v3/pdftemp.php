<?php
ini_set('display_errors',1);
echo dirname("v3/pdftemp.php");
$connect = mysqli_connect("localhost", "admin_arvindam", "Kchl84?9", "admin_arvindam");
 $query="select finances.*,valuations.name AS valuationsname,declerations.name AS declerations  From finances left join valuations on finances.valuatation_by=valuations.id LEFT JOIN declerations  ON declerations.id= finances.notice where finances.id=30017";
 $result = mysqli_query($connect, $query);
 $result=mysqli_fetch_all($result,MYSQLI_ASSOC);
 $FinanceData['Finance']=$result[0];
require_once('tcpdf/tcpdf.php');
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
$pdf->Image('../uploads/image/logo_auto.png',15, 10, 40, 29, 'PNG');
$html = '<table>
						<tr>							
							<td colspan="6" style="text-align:center;"> 
								<span style="font-size:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>ARVIND KUMAR MITTAL</strong></span><sub>(B.E. MECH.)</sub><br>
							<span style="text-align:center;padding-right: 20%; font-size:12px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALUER SURVEYOR & LOSS ASSESSOR </span>
							<br><br><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALUATION REPORT </strong>
							</td>
							<td colspan="2" style="font-size:12px;"> 
								<br> MOBILE NO : +91-9828089362;
								<br> LICENCE NO :  SLA30513
								<br> VALIDITY : 18-11-2020
								<br> EMAIL:slaarvindmittal@yahoo.com <br>&nbsp; gehlot.manoj31@gmail.com								
							</td>
						</tr>
					</table><br>
					<br>
					
					<table cellspacing="0" cellpadding="2" border="1" style="font-size:14px;">
  						
						<tr>
							<td colspan="2"> Ref. No </td>
							<td colspan="1"> '.$FinanceData['Finance']['refenence_no'].' </td>
							<td colspan="1"> Application No</td>
							<td colspan="1"> '.$FinanceData['Finance']['refenence_no'].' </td>
							<td colspan="1"> Staff </td>
							<td colspan="1"> '.$FinanceData['Finance']['refenence_no'].' </td>
						</tr>
						<tr>
							<td colspan="2"> Valuation Initiated By </td>
							<td colspan="6"><strong> jxkzsjXKL </strong> </td>
						</tr>
						<tr>
							<td colspan="2"> Financer Representative </td>
							<td colspan="6"> '.ucfirst($FinanceData['Finance']['financer_representative']).'</td>
						</tr>
						<tr>
							<td colspan="2"> Place of Valuation </td>
							<td colspan="6"> '.ucfirst($FinanceData['Finance']['place_of_valuation']).'</td>
						</tr>
						<tr >
							<td colspan="2"><strong> Registration No.</strong> </td> 
							<th colspan="6" style="top:15px; height:25px; font-size:16px;"><strong > '.$FinanceData['Finance']['registration_no'].'</strong></th>
							
						</tr>
					</table>
						<br>
						<br>
						<table cellspacing="0" cellpadding="2" border="1">
						<tr >
							<td colspan="2"><strong style="font-size:14px;"> Make & Model</strong> </td> 
							<th colspan="3" style="font-size:14px;"> <strong>'.$FinanceData['Finance']['make_model'].'</strong></th>
							<td colspan="2"> <strong style="font-size:14px;">Date of Report </strong> </td>
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
							<th colspan="3"> '.$FinanceData['Finance']['policy_no'].'</th>
							<td colspan="2"><strong> Fuel Used</strong> </td>
							<td colspan="1" style="font-size:13px;"> '.ucfirst($FinanceData['Finance']['fule_used']).'</td>
						</tr>
						<tr>
							<td colspan="2"><strong> Validity</strong> </td> 
							<th colspan="3"> '.$FinanceData['Finance']['validity'].'</th>					
							<td colspan="2"><strong> Owner Serial No.</strong> </td> 
							<th colspan="1"> '.$FinanceData['Finance']['owner_serial_number'].'</th>
						</tr>
						<tr>
							<td colspan="2"><strong> Policy Type</strong> </td> 
							<th colspan="3"> '.$FinanceData['Finance']['policy_type'].'</th>
							<td colspan="2"><strong> Cubic Capacity (CC/Bhp)</strong> </td> 
							<th colspan="1"> '.$FinanceData['Finance']['cube_capacity'].'</th>
						</tr>
						
						<tr >
							<td colspan="2"><strong> SUM Insured(IDV)</strong> </td> 
							<th colspan="3"> '.$FinanceData['Finance']['sum_insured'].'</th>
							<td colspan="2"><strong> MM Reading (Km/Hour)</strong> </td>
							<th colspan="1"> '.$FinanceData['Finance']['mm_reading'].'</th>
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
						<table border="1" cellpadding="7">
						<tr>
							<td colspan="3" ><strong> General Comment</strong></td>
							<td colspan="8" style="font-size:10px;"> '.$FinanceData['Finance']['general_comment'].'</td>
						</tr>
                           </table>
                    	';
                    	    $a = "";
                    if(!empty($FinanceData["Finance"]["fair_amount"])){
						$FinanceData["Finance"]["fair_amount"] .= " (xjKXJklklkl)";
					}
					$html .= '
					<br>
					<br>
					<strong style="font-size:13px;"> CHASSIS IMPRESSION:- </strong>
						<div style="border:1px solid black; height:1000%;">
							'; 
							if($FinanceData["Finance"]["stamp_show"] == 1){
					$html .='
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  src="../uploads/image/st.jpg" width="80" height="80" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
							&nbsp;&nbsp;&nbsp;<img src="../uploads/finance/'.$FinanceData["Finance"]["chachees_number_photo"].'" width="350" height="90" style="margin:2px" />
							<br>
						</div>	
					
					<table border="1" cellpadding="3">
						<tr> 
							<td width="22%;"> Fair Market Price(Rs.)  </td>
							<td width="78%" >
							<strong> ' .$FinanceData["Finance"]["fair_amount"].' </strong>
							</td>
						</tr>
					</table>
					<div style="padding-top:2px; font-size:10px;">
					I hereby declare that the above mentioned information is filled by Photos & R. C. provided by your Executives/Sales Persons via Mail & without prejudice, to the best of my knowledge & understanding. 
					</div>
					<br>
					<table>	
						<tr>
							<td>
								<strong> Arvind Kumar Mittal</strong>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp;Valuer, Surveyor & Loss Assessor 
							</td>
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
		//pr($FinanceData["Finance"]['approve_photo']);die;
		if(!empty($FinanceData["Finance"]['approve_photo'])){
			$thirdKey = 0;
			$lastPhoto = count(json_decode($FinanceData["Finance"]['approve_photo']));
			foreach( json_decode($FinanceData["Finance"]['approve_photo']) as $key => $data ){

				$image = "../uploads/finance/".$data;
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

				$pdf->Image($image, $x, $y, 130, 90, '', '', '', false, 300, '', false, false, 0);
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
$pdf->WriteHTML($htmll, true, false, false, false, '');
$filename = strtotime('now').'.pdf';
$pdf->Output(' /var/www/vhosts/arvindampro.in/httpdocs/uploads/finance/pdf'.'/'.$filename, 'F');
ob_end_flush();
ob_end_clean();
?>