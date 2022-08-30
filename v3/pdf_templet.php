<?php
include_once 'config/database.php';
class pdf extends DatabaseService
{
    public function getData($query,$query2)
    {
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows['data'] = $row;
        }
        $result = $this->conn->query($query2);
        if ($result == false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows['header'] = $row;
        }
        return $rows;
    }
}
$crud       = new pdf();
$query="select finances.* From finances left join valuations on finances.valuatation_by=valuations.id  where finances.id=1900";
$query2="select * From headers";
$result=$crud->getdata($query,$query2);
echo "<pre>";
print_r($result);
if($result){
   $data=$result['data'];
}else{
   header('Location: ' . $_SERVER['HTTP_REFERER']);
}
die();
/*if(!empty($_GET['report_id'])){
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, 'http://localhost/af/v3/view_report.php');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
   $data = array('id' => $_GET['report_id']);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
   $headers = [
       'x-api-key:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUSEVfSVNTVUVSIiwianRpIjoiTzlDaG1MNHVIa05tTEprdVpGQ0NwMlZjcUhDZ2trMkdSN0Z1ejJaS0Y3Zz0iLCJhdWQiOiJUSEVfQVVESUVOQ0UiLCJpYXQiOjE1ODI2MDI3ODAsIm5iZiI6MTU4MjYwMjc4MCwiZXhwIjoxNTgyNjA4NzgwLCJkYXRhIjp7ImlkIjoiNjUiLCJuYW1lIjoic3VwZXJhZG1pbiIsInBvc2l0aW9uIjoiU3VwZXJBZG1pbiIsImVtcGxveWVfaWQiOiJSSS1BTSIsInJlZl9zdGFydCI6IjUifX0.Pad5K9YG1bFcBBNNL7obsqsqi_TOSHWFEqizmLJfFdo'
   ];
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   $result = curl_exec($ch);
   if (curl_errno($ch)) {
       echo 'Error:' . curl_error($ch);
   }
   $result =json_decode($result,true);
   if($result['result']){
      $data=$result['result'][0];
   }
   curl_close($ch);
}*/

 ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Genrate Pdf</title>
      <style type="text/css">
         .name-list td{
         font-size: 10px!important;
         }
         .name-list-1 td{
         font-size: 8px!important;
         }
         .name-list th{
         font-size: 5px;
         }
         .name-list td strong{
         font-size: 9px!important;
         }
         .perent{
         position: relative;
         }
         .stamp{
         position: absolute;
         top: 100px;
         left: 43%;
         }
         .stamp-1{
         position: absolute;
         top: 430px;
         left: 43%;
         }
         .page{
         position: relative;
         }
         .stamp-2{
         position: absolute;
         top: 142px;
         left: 43%;
         z-index: 999;
         }
         .stamp-3{
         position: absolute;
         top: 490px;
         left: 43%;
         z-index: 999;
         }
         .rj{
            font-size: 10px;
         }
      </style>
   </head>
   <body>
   <div style="">
      <img src="../uploads/image/loading.gif" style="display: block;margin-left: auto;margin-right: auto;width: 100%;"> 
    </div>
      <page size="A4" id="xlrt">
         <main>
            <div style="padding: 0px 15px;margin-top: 30px;">
               <table cellspacing="0" cellpadding="0" style="width: 100%; margin-bottom:5px;">
                  <tr>
                     <td style="width: 25%;"><img src="../uploads/image/logo_auto.png" style="width: 60%;"></td>
                     <td style="width: 42.33%; text-align: center;">
                        <h2 style="font-size: 10px; margin: 0; margin-bottom: 5px;">ARVIND KUMAR MITTAL<sub style="font-size: 9px;">(B.E.MECH)</sub></h2>
                        <h5 style="margin:0; font-size: 11px;">VALUER SURVEYOR & LOSS ASSESSOR</h5>
                        <h3 style="margin: 20px 0;">VALUATION REPORT</h3>
                     </td>
                     <td style="width: 33.33%; padding-left: 46px; ">
                        <p style="padding: 0; margin: 0; margin-bottom: 3px; font-size: 10px;">MOBILE NO : +91-9828089362</p>
                        <p style="padding: 0; margin: 0; margin-bottom: 3px; font-size: 10px;">LICENCE NO : SLA30513</p>
                        <p style="padding: 0; margin: 0; margin-bottom: 3px; font-size: 10px;">VALIDITY : 18-11-2020</p>
                        <p style="padding: 0; margin: 0; margin-bottom: 3px; font-size: 10px;">EMAIL:slaarvindmittal@yahoo.com
                           gehlot.manoj31@gmail.com
                        </p>
                     </td>
                  </tr>
               </table>
               <table cellspacing="0" cellpadding="2" border="1" style="width: 100%; margin-bottom: 0px;;">
                  <tbody>
                     <tr class="name-list">
                        <td style="width: 23%;">Ref. No</td>
                        <td  style="width: 23%;"><?php echo $data['refenence_no'];?></td>
                        <td style="width: 23%;">Application No</td>
                        <td  style="width: 23%;"><?php echo $data['appliction_no'];?></td>
                        <td style="width: 23%;">Staff Init</td>
                        <td  style="width: 23%;"><?php echo $data['staff_name'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"> Valuation Initiated By </td>
                        <td colspan="10" style="top:15px; height:10px; font-size:16px;"><strong><?php echo $data['valuatation_by'];?></strong> </td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"> Financer Representative </td>
                        <td colspan="10" style="top:15px; height:10px; font-size:16px;"><?php echo $data['financer_representative'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"> Place of Valuation </td>
                        <td colspan="10" style="top:15px; height:10px; font-size:16px;"><?php echo $data['place_of_valuation'];?></td>
                     </tr>
                     <tr  class="name-list">
                        <td style="width: 23%;"><strong> Registration No.</strong> </td>
                        <td colspan="10" style="top:15px; height:10px; font-size:16px;"><strong><?php echo $data['registration_no'];?></strong></td>
                     </tr>
                  </tbody>
               </table>
               <table cellspacing="0" cellpadding="2" border="1" style="width: 100%; margin-bottom: 0px;;">
                  <tbody>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong> Make & Model</strong> </td>
                        <td style="font-size: 10px;"> <strong><?php echo $data['make_model'];?></strong></td>
                        <td> <strong style="font-size: 5px;">Date of Report </strong> </td>
                        <td  style="font-size: 5px;"><?php echo date('d-m-Y',(int)$data['report_date']);?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong style="font-size: 5px;">Chassis Number</strong> </td>
                        <td><strong style="font-size: 5px;"><?php echo $data['chachees_number'];?></strong></td>
                        <td> <strong style="font-size: 5px;">Date of Inspection</strong> </td>
                        <td style="font-size: 5px;"><?php echo $data['inspection_date'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong style="font-size: 5px;"> Engine No.</strong> </td>
                        <td><strong style="font-size: 5px;"><?php echo $data['engine_number'];?></strong></td>
                        <td> <strong style="font-size: 5px;">Registration Date </strong> </td>
                        <td style="font-size: 5px;"><?php echo $data['registration_date'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong style="font-size: 5px;"> Registered Owner</strong> </td>
                        <td><strong style="font-size: 5px;"><?php echo $data['registerd_owner'];?></strong></td>
                        <td><strong style="font-size: 5px;"> Colour</strong> </td>
                        <td style="font-size: 5px;"><?php echo $data['color'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong style="font-size: 5px;"> Finance Taken By</strong> </td>
                        <td><strong style="font-size: 5px;"><?php echo $data['financed_by'];?></strong></td>
                        <td><strong style="font-size: 5px;"> Seating Capacity</strong> </td>
                        <td style="font-size: 5px;"><?php echo $data['seating_capacity'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"> <strong style="font-size: 5px;">Tax Paid Upto </strong> </td>
                        <td style="font-size: 5px;"><?php echo $data['tax_paid'];?></td>
                        <td><strong style="font-size: 5px;"> Regd. Laden Wt.(Kg)</strong> </td>
                        <td style="font-size: 5px;"><?php echo $data['laden_wt'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong style="font-size: 5px;"> Hypothecation</strong> </td>
                        <td style="font-size: 5px;"> <strong><?php echo $data['hypothecation'];?></strong></td>
                        <td><strong style="font-size: 5px;"> Regd. Unladen Wt.(Kg)</strong> </td>
                        <td style="font-size: 5px;"><?php echo $data['unladen_wt'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong> Policy No.</strong> </td>
                        <td><?php echo $data['policy_no'];?></td>
                        <td><strong> Fuel Used</strong> </td>
                        <td style="font-size:5px;"><?php echo $data['fule_used'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong> Validity</strong> </td>
                        <td><?php echo $data['validity'];?></td>
                        <td><strong> Owner Serial No.</strong> </td>
                        <td><?php echo $data['owner_serial_number'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong> Policy Type</strong> </td>
                        <td><?php echo $data['policy_type'];?></td>
                        <td><strong> Cubic Capacity (CC/Bhp)</strong> </td>
                        <td><?php echo $data['cube_capacity'];?></td>
                     </tr>
                     <tr class="name-list">
                        <td style="width: 23%;"><strong> SUM Insured(IDV)</strong> </td>
                        <td><?php echo $data['sum_insured'];?></td>
                        <td><strong> MM Reading (Km/Hour)</strong> </td>
                        <td><?php echo $data['mm_reading'];?></td>
                     </tr>
                     <tr>
                        <td colspan="2" rowspan="7">
                           <table border="1" cellpadding="1" cellspacing="3" style="width: 100%;">
                              <tr class="name-list">
                                 <th colspan="3"> Right Tyres </th>
                                 <th colspan="3"> Left Tyres </th>
                              </tr>
                              <tr>
                                 <td style="font-size: 8px;"> Quantity </td>
                                 <td style="font-size: 8px;"> Company </td>
                                 <td style="font-size: 8px;"> Percentage </td>
                                 <td style="font-size: 8px;"> Quantity </td>
                                 <td style="font-size: 8px;"> Company </td>
                                 <td style="font-size: 8px;"> Percentage </td>
                              </tr>
                              <?php  
                                 $left_tyer_quantity =json_decode($data['left_tyer_quantity']);
                                 $left_tyer_company =json_decode($data['left_tyer_company']);
                                 $left_quality= json_decode($data['left_quality']);
                                 $right_tyer_quantity=json_decode($data['right_tyer_quantity']);
                                 $right_tyer_company= json_decode($data['right_tyer_company']);
                                 $right_quality= json_decode($data['right_quality']);
                              ?>                              
                                 <?php foreach ($left_tyer_quantity as $key => $value) {
                                   ?> 
                                   <tr class="name-list-1">
                                    <td><?php echo $left_tyer_quantity[$key] ;?></td>
                                    <td><?php echo $left_tyer_company[$key] ;?></td>
                                    <td><?php echo $left_quality[$key] ;?>%</td>
                                    <td><?php echo $right_tyer_quantity[$key] ;?></td>
                                    <td><?php echo $right_tyer_company[$key] ;?></td>
                                    <td><?php echo $right_quality[$key] ;?></td>  
                                    <tr> 
                                 <?php } ?>
                              </tr>
                           </table>
                        </td>
                     <tr class="name-list">
                        <td colsapn="2"><strong> Battery</strong> </td>
                        <td colsapn="3"><?php echo $data['battery'] ;?></td>
                     </tr>
                     <tr class="name-list">
                        <td colsapn="2"><strong> Radiator</strong> </td>
                        <td colsapn="3"><?php echo $data['radiator'] ;?></td>
                     </tr>
                     <tr class="name-list">
                        <td colsapn="2"> <strong>AC </strong> </td>
                        <td colsapn="3"><?php echo $data['ac'] ;?></td>
                     </tr>
                     <tr class="name-list">
                        <td colsapn="2"> <strong>Power Steering </strong> </td>
                        <td colsapn="3"><?php echo $data['power_steering'] ;?></td>
                     </tr>
                     <tr class="name-list">
                        <td colsapn="2"><strong> Power Window</strong> </td>
                        <td colsapn="3"><?php echo $data['power_window'] ;?></td>
                     </tr>
                     <tr class="name-list">
                        <td colsapn="2"> <strong>Air Bag </strong> </td>
                        <td colsapn="3"><?php echo $data['air_bag'] ;?></td>
                     </tr>
                  </tbody>
               </table>
               <table cellspacing="0" cellpadding="3" border="1" style="width: 100%; text-align: center; margin-bottom: 5px;;">
                  <tbody>
                     <tr class="name-list">
                        <td ><strong style="font-size:16px; text-align:center;"> Engine Condition</strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Cooling System </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Suspension System </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Electrical System </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Wheel & Tyres </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Chassis </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Cabin & Body Ext. </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Condition of  Interiors </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Glasses </strong></td>
                        <td ><strong style="font-size:16px; text-align:center;"> Paint </strong></td>
                     </tr>
                     <tr class="name-list">
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_engine_condition'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_cooling_system'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_suspension_system'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_electrical_system'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_wheel'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_chassis'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_cabin'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_condition_of_interiors'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_glass'] ;?></td>
                        <td style="text-align:center; font-size:16px;"><?php echo $data['c_paint'] ;?></td>
                     </tr>
                  </tbody>
               </table>
               <table border="1" cellpadding="4" id="editor" style="width: 100%; margin-bottom: 0px;;">
                  <tbody>
                     <tr class="name-list">
                        <td><strong>General Comment</strong></td>
                        <td> <?php echo $data['notice'] ;?> </td>
                     </tr>
                  </tbody>
               </table>
               <strong style="font-size:10px;"> CHASSIS IMPRESSION:- </strong>
               <table  cellspacing="0" cellpadding="0" border="1" style="width: 100%;">
                  <tr style="height: 50%;">
                     <td style="width: 20%;"><img class=""  src="../uploads/image/st.jpg" alt=""style="width: 80px;height: 80px; display: flex; margin: 0 auto;"></td>
                     <td >
                        <span style="width: 50%;"><img src="../uploads/finance/<?php echo $data['chachees_number_photo'] ;?>" style="margin:2px; display: flex; margin: 0 auto;   width: 300px;height: 80px; " /></span>
                     </td>
                  </tr>
               </table>
               <table  cellspacing="0" cellpadding="3" border="1" style="width:100%; margin-bottom: 0px;margin-top: -1px;">
                  <tbody>
                     <tr class="name-list">
                        <td width="21%;"> Fair Market Price(Rs.)  </td>
                        <td width="78%" >
                           <strong> <?php echo $data['fair_amount'] ;?></strong>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <div style="padding-top:2px; font-size: 10px;padding-bottom:0px;">
                  I hereby declare that the above mentioned information is authentic & without prejudice,to the best of my knowledge & understanding. Photographs also taken at the time of inspection
                  and enlosed with this report. 
               </div>
               <br>
               <table>
                  <tbody>
                     <tr>
                        <td>
                           <span style="font-size: 15px; font-weight: bold; color: #000;">Arvind Kumar Mittal</span>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <span style="font-size: 15px; color: #000;">Valuer, Surveyor & Loss Assessor</span>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <div class="perent">
                  <table style="width: 100%; margin-top: 50px;">
                     <tbody>
                        <tr>
                           <td colspan="2"><span class="rj">RJ-14-GD-4090</span>
                           <hr style="border: 1px solid #ccc;">
                            <img class="stamp-2"  src="img/st.jpg" alt=""style="width: 90px;height: 90px;">
                             <img class="stamp-3"  src="img/st.jpg" alt=""style="width: 90px;height: 90px;">  
                           </td>
                        </tr>
                        <tr style="height: 50%;">
                       <?php 
                       $photo =json_decode($data['photo']);
                       $i=0;
                       $j=0;
                        foreach ($photo as $key => $value) {
                           ?>
                              <td style="width: 50%;"><img class="" src="../uploads/finance/<?php echo $value ?>" alt=""style="width: 100%; height: 160px;" ></td>
                        <?php
                           $i++;
                           $j++;
                           if($i==2){
                              $i=0;
                              echo "</tr>";
                           }
                           if($j==8){
                              $j=0;
                             ?>
                             <tr class="page-header">
                           <td colspan="2"><span class="rj">RJ-14-GD-4090</span>
                           <hr style="border: 1px solid #ccc;"> <img class="stamp-2"  src="img/st.jpg" alt=""style="width: 90px;height: 90px;">
                             <img class="stamp-3"  src="img/st.jpg" alt=""style="width: 90px;height: 90px;"></td>
                        </tr>
                             <?php 
                           }
                        }
                        ;?>
                      
                        
                     </tbody>
                  </table>
               </div>
               
         </main>
         </div>
      </page>
   </body>
</html>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>
<script>
   $(document).ready(function(){
      let searchParams = new URLSearchParams(window.location.search)
    let param = searchParams.get('report_id')
     if(param){
       report_id=param;
    } 
      token=localStorage.getItem("avdtoken");
      
    $("html, body").animate({ scrollTop: 600 }, 100);
      kendo.drawing.drawDOM("#xlrt", {
        paperSize:"A4",
        multiPage: true,
       forcePageBreak: ".page-header",
      })
      .then(function(group) {
        return kendo.drawing.exportPDF(group);
      }).done(function (data) {
                      $.ajax({
                          type: "POST",
                          url: "uplode_pdf.php",
                          headers: {'x-api-key': token },
                          processData: false,  // tell jQuery not to process the data
                          contentType: false,  // tell jQuery not to set contentType
                          data: '{ "docData" : "' + data + '","id" : "' + report_id + '"}',
                          contentType: 'application/json; charset=utf-8',
                          success: function(response){
                           window.open(response.result.fileurl, '_blank');
                           console.log(response);
                              history.back(); 
                          }
                      })
                  });
      })
</script>   