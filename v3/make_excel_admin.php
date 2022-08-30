<?php
include_once("src/defalt.php");

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $data['filterdata']=$_POST;
    $data['filterdata']['status']=1;
   if(isset($data['filterdata'])){
	  
        $error=$valid->check_empty($data['filterdata'],array('s_date','e_date'));
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
                $report_date="";
                if(!empty($filterdata['s_date']) AND !empty($filterdata['e_date']))
                {   
                    $s_date= strtotime($filterdata['s_date']);
                    $e_date= strtotime($filterdata['e_date']);
                    $report_date="finances.report_date BETWEEN '".$s_date."' AND '".$e_date."'";
                }
                $query = "SELECT finances.*,valuations.name,cities.city_name,cities.city_state,users.name as uname,users.username,users.pass1 FROM finances left JOIN valuations ON valuations.id = finances.valuatation_by LEFT JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') LEFT JOIN cities ON users.area=cities.city_name WHERE $report_date and finances.report_date IS NOT NULL and finances.mobile_data='1'and users.position='Employe'and  users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") ORDER BY finances.report_date asc";
                $result=$exe->getallquerydata($query);
                if($result){
					$valuatation_by=$result[0]['valuatation_by'];
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

        $sheet->setTitle('Valuation Record');
        
        
        $sheet->mergeCells('A1:O1');
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A1','"'.$valuatation_by.'"');
        $sheet->getStyle('A1')->applyFromArray($styleArray);
        $sheet->mergeCells('A2:O2');
        $styleArray = array(
            'font'  => array(
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A2', '('.$d1.' To '.$d2.')');
        $sheet->getStyle('A2')->applyFromArray($styleArray);

        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));

       
        // OUTPUT
        

        $styleArray = array(
            'font'  => array(
                'size'  => 11,
                'name'  => 'Calibri',
            ),'alignment' => array(
                    'vertical' => PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ));
		$sheet->getStyle('A4:O4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);
		$sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
		$sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(15);
		$sheet->getColumnDimension('N')->setWidth(12);
        $sheet->getColumnDimension('O')->setWidth(12);



        $sheet->setCellValue('A4', 'S.No.');
        $sheet->setCellValue('B4', 'State');
		$sheet->setCellValue('C4', 'City');
		$sheet->setCellValue('D4', 'Inspection  Date');
		$sheet->setCellValue('E4', 'Completed Date');
        $sheet->setCellValue('F4', 'Application No.');
        $sheet->setCellValue('G4', 'Financer Rep');
        $sheet->setCellValue('H4', 'Registration No.');
        $sheet->setCellValue('I4', 'Make & Model');
        $sheet->setCellValue('J4', 'Finance Taken By');
        $sheet->setCellValue('K4', 'Place');
        $sheet->setCellValue('L4', 'Link');
		$sheet->setCellValue('M4', 'Executive Name');
        $sheet->setCellValue('N4', 'Employee ID');
        $sheet->setCellValue('O4', 'Mobile No.');
        $i=5;
        $j=1;
        $total=0;
        foreach ($rows  as $key => $value) {

            $sheet->getRowDimension($i)->setRowHeight(50);
            $sheet->setCellValue('A'.$i,$j);
			$sheet->setCellValue('B'.$i, $value['city_state']);
			$sheet->setCellValue('C'.$i, $value['city_name']);
			$sheet->setCellValue('D'.$i, $value['inspection_date']);
            $sheet->setCellValue('E'.$i, date('d-m-Y', (int)$value['report_date']));
            $sheet->setCellValue('F'.$i, $value['appliction_no']);
            $sheet->setCellValue('G'.$i, $value['financer_representative']);
            $sheet->setCellValue('H'.$i, $value['registration_no']);
            $sheet->setCellValue('I'.$i, $value['make_model']);
            $sheet->setCellValue('J'.$i, $value['financed_by']);
            $sheet->setCellValue('K'.$i, $value['place_of_valuation']);
            $sheet->setCellValue('L'.$i, 'https://www.arvindampro.in/uploads/finance/pdf/'.$value['pdf_file']);
			$sheet->setCellValue('M'.$i, $value['uname']);
            $sheet->setCellValue('N'.$i, $value['username']);
			$sheet->setCellValue('O'.$i, $value['pass1']);
            $i++;
            $j++;
        }
            $objs    = new toWords();
            $obj=$objs->toWord($total);
        $spreadsheet->getActiveSheet()->getStyle('A4:O'.$i)
            ->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:O'.$i)->applyFromArray($styleArray);
       

        $sheet->getStyle('A'.$i)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,)));
        $sheet->getStyle('O'.$i)->applyFromArray(array('font'  => array('bold'  => true)));

        
        $il=$i-1;
        $ilx=$i+3;
        
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
        for ($i=4; $i <= $il; $i++) { 
            $sheet->getStyle('A'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('B'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('C'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('E'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('F'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('G'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('I'.$i)->applyFromArray($styleArray);
			$sheet->getStyle('J'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('K'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('L'.$i)->applyFromArray($styleArray);
			$sheet->getStyle('M'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('N'.$i)->applyFromArray($styleArray);
            $sheet->getStyle('O'.$i)->applyFromArray($styleArray);
        }
        
        $writer = new Xlsx($spreadsheet);
		$name='Valuation Record_'.$d1.'_to_'.$d2.'.xlsx';
        $writer->save('../uploads/tmp/'.$name);
        return $name;
}    

?>