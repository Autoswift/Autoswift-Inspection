<?php
include_once("src/defalt.php");
ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=="POST")
{
    if($_POST['make_excel']==1){
		$query = "select * From grid ORDER by vehicle_make DESC,vehicle_model DESC,variant DESC,year DESC";
		$result=$exe->getallquerydata($query);
        if($result){
			$res=excel($result);
			if($res){
				$temp=$res;
				$error="Successfully";
				$status=true;
				$code=200;
				}else{
					$error="Somthing Went Wrong";  
				}
		}else{
			$error="No Data";
		}
	}
    echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
function excel($rows){
   
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
        
        
        $sheet->mergeCells('A1:H1');
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A1','');
        $sheet->getStyle('A1')->applyFromArray($styleArray);
        $sheet->mergeCells('A2:H2');
        $styleArray = array(
            'font'  => array(
                'size'  => 15,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A2', '');
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

        $sheet->getStyle('A4:H4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
$sheet->getStyle('H4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');

        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(30);
       



        $sheet->setCellValue('A4', 'S.No.');
        $sheet->setCellValue('B4', 'Vehicle Make');
        $sheet->setCellValue('C4', 'Vehicle Model.');
        $sheet->setCellValue('D4', 'Variant');
        $sheet->setCellValue('E4', 'Chassis No');
        $sheet->setCellValue('F4', 'Year');
        $sheet->setCellValue('G4', 'Cost');
        $sheet->setCellValue('H4', 'Note');
       
        $i=5;
        $j=1;
        $total=0;
        foreach ($rows  as $key => $value) {

            $sheet->getRowDimension($i)->setRowHeight(20);
            $sheet->setCellValue('A'.$i,$j);
            $sheet->setCellValue('B'.$i, $value['vehicle_make']);
            $sheet->setCellValue('C'.$i, $value['vehicle_model']);
            $sheet->setCellValue('D'.$i, $value['variant']);
            $sheet->setCellValue('E'.$i, $value['chassis_no']);
            $sheet->setCellValue('F'.$i, $value['year']);
            $sheet->setCellValue('G'.$i, $value['cost']);
            $sheet->setCellValue('H'.$i, $value['note']);
            
            $i++;
            $j++;
        }
            
        $spreadsheet->getActiveSheet()->getStyle('A4:H'.$i)
            ->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:H'.$i)->applyFromArray($styleArray);
       

        $sheet->getStyle('A'.$i)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,)));
        $sheet->getStyle('H'.$i)->applyFromArray(array('font'  => array('bold'  => true)));

        
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
           
        }
        
        $writer = new Xlsx($spreadsheet);
		$name='grid.xlsx';
        $writer->save('../uploads/tmp/'.$name);
        return $name;
}    

?>