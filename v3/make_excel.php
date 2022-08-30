<?php
include_once("src/defalt.php");
/*ini_set('display_errors', 0);*/
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $data['filterdata']=$_POST;
    $data['filterdata']['status']=1;
   if(isset($data['filterdata'])){
        $error=$valid->check_empty($data['filterdata'],array('s_date','e_date','valuatation_by'));
        if(!$error){
            $filterdata=array_filter($data['filterdata']);
            $d1 = date_create($filterdata['s_date']);
            $d2= date_create($filterdata['e_date']);
            $interval= date_diff($d1,$d2);
            $month=$interval->format('%m');
            if($month<=3){
                $d1 = $filterdata['s_date'];
                $d2= $filterdata['e_date'];
                $valuatation_by=$filterdata['valuatation_by'];
                if(!empty($filterdata['mobile_data'])){
                        $ismobile='and report_date IS NULL';
                        $asds='ORDER BY id desc';
                    }else{
                        $ismobile='and report_date IS NOT NULL';
                        $asds='ORDER BY id desc';
                    }
                $amount='';
                    if(!empty($filterdata['amount_from']) AND !empty($filterdata['amount_to']))
                    {
                       $amount="AND total_amount BETWEEN '".$filterdata['amount_from']."' AND '".$filterdata['amount_to']."'";

                    }
                    $created='';
                    if(!empty($filterdata['create_date']) AND !empty($filterdata['create_end']))
                    {   
                        $created="AND DATE(created) BETWEEN '".date("Y-m-d",strtotime($filterdata['create_date']))."' AND '".date("Y-m-d",strtotime($filterdata['create_end']))."'";
                        $asds='ORDER BY report_date asc';
                    }
                    $report_date="";
                    if(!empty($filterdata['s_date']) AND !empty($filterdata['e_date']))
                    {   
                        $s_date= strtotime($filterdata['s_date']);
                        $e_date= strtotime($filterdata['e_date']);
                        $report_date="AND report_date BETWEEN '".$s_date."' AND '".$e_date."'";
                        $asds='ORDER BY report_date asc';
                    }
					$valuation='';
					if(!empty($filterdata['valuatation_by'])){
							$valuation="And valuatation_by=".$filterdata['valuatation_by'];
							unset($filterdata['valuatation_by']);	
					}
                    $user='';
                    if(!empty($filterdata['user']) && $tokendata['position']!='SuperAdmin'){
                            $user='And user_id='.$tokendata['id'];
                    }
                    $search_on='';
                    if(!empty($filterdata['search_on'])){
                        switch ($filterdata['search_on']) {
                            case "1":
                                $search_on='And remaining_amount>=1';
                                break;
                            case "2":
                               $search_on='And remaining_amount=0';
                                break;
                            case "3":
                                $search_on='And amount > 0';
                                break;
                            case "4":
                                $search_on="AND (finances.amount IS NULL OR finances.amount='')";
                                break;
							case "5":
                                $search_on="And finances.fair_amount=0";
                                break;	
                        }
                    }
                    unset($filterdata['search_on']);    
                    unset($filterdata['user']); 
                    unset($filterdata['amount_from']);
                    unset($filterdata['amount_to']);
                    unset($filterdata['create_date']);
                    unset($filterdata['create_end']);
                    unset($filterdata['s_date']);
                    unset($filterdata['e_date']);
                    $whereArr=[];
                    foreach ($filterdata as $key => $value)
                    {
                         $whereArr[] =$key.' Like "%'.$value.'%"';
                    }
                    $whereStr = implode(" AND ", $whereArr);
                     $query = "SELECT fn.*,valuations.name FROM (Select * from finances WHERE $whereStr $search_on $valuation $user $ismobile $amount $created $report_date $asds) as fn left JOIN valuations ON valuations.id = fn.valuatation_by";
                $result=$exe->getallquerydata($query);
                if($result){
                    $query = "Select * from headers";
                    $header=$exe->getsinglequery($query);
                    $query = "Select name from valuations where id='$valuatation_by'";
                    $val=$exe->getsinglequery($query);
                    $valuatation_by=$val['name'];
                    $res=excel($result,$d1,$d2,$valuatation_by,$header);
                    if($res){
                        $temp=$res;
                        $error="Successfully";
                        $status=true;
                        $code=200;
                    }else{
                        $error="Somthing Went Wrong";  
                    }
                }else{
                   $error="No date Found to Export Excel";  
                }
            }else{
               $error="Allow only 3 Month"; 
            }
        } 
    }
    echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
function excel($rows,$d1,$d2,$valuatation_by,$header){
    require "amount_to_word.php";
        // CREATE A NEW SPREADSHEET + SET METADATA
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
        ->setCreator('YOUR NAME')
        ->setLastModifiedBy('YOUR NAME')
        ->setTitle('Demo Document')
        ->setSubject('Demo Document')
        ->setDescription('Demo Document')
        ->setKeywords('demo php spreadsheet')
        ->setCategory('demo php file');
         
        // NEW WORKSHEET
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Testing');
        $sheet->mergeCells('A1:I1');
        $objRichText = new PhpOffice\PhpSpreadsheet\RichText\RichText();
        $run1 = $objRichText->createTextRun($header['authorizer_name']);
        $run1->getFont()->applyFromArray(array( "bold" => true, "size" => 20, "name" => "Arial"));

        $run2 = $objRichText->createTextRun($header['authorizer_education']);
        $run2->getFont()->applyFromArray(array("size" => 10, "name" => "Arial",));

        $sheet->setCellValue("A1", $objRichText);

        $sheet->getStyle('A1')->applyFromArray(array('alignment'=>array('horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)));


        $sheet->mergeCells('A2:I2');
        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A2',$header['authorizer_designation']);
        $sheet->getStyle('A2')->applyFromArray($styleArray);
        $sheet->mergeCells('A3:I3');
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A3',$header['report_heading'].' BILL - "'.$valuatation_by.'"');
        $sheet->getStyle('A3')->applyFromArray($styleArray);
        $sheet->mergeCells('A4:I4');
        $styleArray = array(
            'font'  => array(
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A4', '('.$d1.' To '.$d2.')');
        $sheet->getStyle('A4')->applyFromArray($styleArray);

        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));

        $sheet->mergeCells('A5:I5');
        $sheet->setCellValue('A5', 'MOBILE NO : '.$header["mobile_number"].'        LICENCE NO : '.$header["licence_no"].'           VALIDITY : '.$header["expire"].'');
        $sheet->getStyle('A5')->applyFromArray($styleArray);
        $sheet->mergeCells('A6:I6');
        $sheet->setCellValue('A6', 'EMAIL:'.$header["email1"].'                                '.$header["email2"].'');
        $sheet->getStyle('A6')->applyFromArray($styleArray);
        // OUTPUT
        $drawing = new PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath('../uploads/image/'.$header["logo"]);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);
        $drawing->setRotation(0);
        $drawing->setWidthAndHeight(120,120);
        $drawing->getShadow()->setVisible(true);
        $drawing->getShadow()->setDirection(100);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $styleArray = array(
            'font'  => array(
                'size'  => 11,
                'name'  => 'Calibri',
            ),'alignment' => array(
                    'vertical' => PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ));

        $sheet->getStyle('A7:I7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');


        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(14);



        $sheet->setCellValue('A7', 'S.No.');
        $sheet->setCellValue('B7', 'Date');
        $sheet->setCellValue('C7', 'Application No.');
        $sheet->setCellValue('D7', 'Financer Rep');
        $sheet->setCellValue('E7', 'Registration No.');
        $sheet->setCellValue('F7', 'Make & Model');
        $sheet->setCellValue('G7', 'Finance Taken By');
        $sheet->setCellValue('H7', 'Place');
        $sheet->setCellValue('I7', 'Total Amount');
        $i=8;
        $j=1;
        $total=0;
        foreach ($rows  as $key => $value) {

            $sheet->getRowDimension($i)->setRowHeight(50);
            $sheet->setCellValue('A'.$i,$j);
            $sheet->setCellValue('B'.$i, date('d-m-Y', (int)$value['report_date']));
            $sheet->setCellValue('C'.$i, $value['appliction_no']);
            $sheet->setCellValue('D'.$i, $value['financer_representative']);
            $sheet->setCellValue('E'.$i, $value['registration_no']);
            $sheet->setCellValue('F'.$i, $value['make_model']);
            $sheet->setCellValue('G'.$i, $value['financed_by']);
            $sheet->setCellValue('H'.$i, $value['place_of_valuation']);
            $sheet->setCellValue('I'.$i, $value['total_amount']);
            $total=$total+$value['total_amount'];
            $i++;
            $j++;
        }
            $objs    = new toWords();
            $obj=$objs->toWord($total);
        $spreadsheet->getActiveSheet()->getStyle('A7:I'.$i)
            ->getAlignment()->setWrapText(true);
        $sheet->getStyle('A7:I'.$i)->applyFromArray($styleArray);
        $sheet->mergeCells('A'.$i.':H'.$i);

        $sheet->getStyle('A'.$i)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,)));
        $sheet->getStyle('I'.$i)->applyFromArray(array('font'  => array('bold'  => true)));

        $sheet->setCellValue('A'.$i, 'Total Amount ('.$obj.')');
        $sheet->setCellValue('I'.$i,$total);
        $il=$i+1;
        $ilx=$i+3;
        $sheet->mergeCells('A'.$il.':I'.$ilx);

        $sheet->getStyle('A'.$il)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,)));
        $sheet->setCellValue('A'.$il,'SEAL & SIGNATURE OF SURVEYOR');
        $styleArray = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' =>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ),
                 'bottom' => array(
                    'borderStyle' =>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ),
                  'left' => array(
                    'borderStyle' =>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ),
                   'right' => array(
                    'borderStyle' =>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ),
            ),
        );
        for ($i=7; $i <= $il; $i++) { 
            $sheet->getStyle('A'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('B'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('C'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('E'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('F'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('G'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('I'.$i)->applyFromArray($styleArray);
        }
        
        $writer = new Xlsx($spreadsheet);

        $date=date_create($d1);
        $name= date_format($date,"M Y").'.xlsx';

        $writer->save('../uploads/tmp/'.$name);
        return $name;
}    

?>