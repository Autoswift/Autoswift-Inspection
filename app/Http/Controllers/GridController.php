<?php

namespace App\Http\Controllers;

use App\Grid;
use Illuminate\Http\Request;
use Datatable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
class GridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid=Grid::orderBy('vehicle_make','asc')->orderBy('vehicle_model','asc')->orderBy('variant','asc')->orderBy('year','asc')->get();
        $vehicle_make=Grid::select('vehicle_make')->groupBy('vehicle_make')->orderBy('vehicle_make')->pluck('vehicle_make','vehicle_make');
        return view('Grid.index',compact('grid','vehicle_make'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $vehicle_make=Grid::select('vehicle_make')->groupBy('vehicle_make')->orderBy('vehicle_make')->pluck('vehicle_make','vehicle_make');
        if($request->ajax()){
            if($request->vehicle_model && $request->vehicle_make && $request->variant){
                $year=Grid::select('year')->groupBy('year')->orderBy('year')->where('vehicle_model','=',$request->vehicle_model)->where('vehicle_make','=',$request->vehicle_make)->where('variant','=',$request->variant)->pluck('year','year');
                return $year;
            }
            if($request->vehicle_make && $request->vehicle_model){
                $variant=Grid::select('variant')->groupBy('variant')->orderBy('variant')->where('vehicle_make','=',$request->vehicle_make)->where('vehicle_model','=',$request->vehicle_model)->pluck('variant','variant');
                return $variant;
            }
            if($request->vehicle_make){
                $vehicle_model=Grid::select('vehicle_model')->groupBy('vehicle_model')->orderBy('vehicle_model')->where('vehicle_make','=',$request->vehicle_make)->pluck('vehicle_model','vehicle_model');
               return $vehicle_model;
            }
        }
       
        return view('Grid.create',compact('vehicle_make'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_make'=>'required',
            'vehicle_model'=>'required',
            'variant'=>'required',
            'year'=>'required',
        ]);
        $input=$request->all();
        $data=Grid::create($input);
        $data->save();
        return redirect()->route('grid.index')
                        ->with('added','Grid Has been Submited.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gird  $gird
     * @return \Illuminate\Http\Response
     */
    public function show(Grid $grid)
    {
       /* return 'x';*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gird  $gird
     * @return \Illuminate\Http\Response
     */
    public function edit(Grid $grid)
    {
         $vehicle_make=Grid::select('vehicle_make')->groupBy('vehicle_make')->orderBy('vehicle_make')->pluck('vehicle_make','vehicle_make');
        return view('Grid.edit',compact('vehicle_make','grid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gird  $gird
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grid $grid)
    {
        if($request->ajax()){
            $in=($request->all());
            $key=array_key_first($in);
            $val=$in[$key];
            $data=Grid::where($key,'=',$request->old_value);
            $input[$key]=$val;
            $data=$data->update($input);
            if($data){
                return array('status' =>true,'msg'=>'Successfully Updated');      
            }
            return array('status' =>false,'msg'=>'Somthing went wrong');
          
        }
        $request->validate([
            'vehicle_make'=>'required',
            'vehicle_model'=>'required',
            'variant'=>'required',
            'year'=>'required',
        ]);
        $input=$request->all();
        $data=Grid::findOrFail($grid->id);
        $data->update($input);
        return redirect()->route('grid.index')->with('updated','Grid Has been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gird  $gird
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grid $grid)
    {
        $grid->delete();
        return back()->with('deleted', 'Grid has been deleted');   
    }
    public function make_excel(){

         $data=Grid::orderBy('vehicle_make','asc')->orderBy('vehicle_model','asc')->orderBy('variant','asc')->orderBy('year','asc')->get();;
         if($data)
         {
           $result=$this->excel($data);
           if($result==true){
             return back()->with('add', 'Grid Excel has been Generated');
           }else{
             return back()->with('deleted', 'Somthing went wrong');
           }    
         }else{
            return back()->with('updated', 'There are No data to Export');
         }    

    }
    protected function excel($rows){
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
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
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
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ));
        $sheet->setCellValue('A2', '');
        $sheet->getStyle('A2')->applyFromArray($styleArray);

        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
         'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ));

        $styleArray = array(
            'font'  => array(
                'size'  => 11,
                'name'  => 'Calibri',
            ),'alignment' => array(
                    'vertical' => Alignment::VERTICAL_TOP,
                ));

        $sheet->getStyle('A4:H4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
$sheet->getStyle('H4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');

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
        $sheet->getStyle('A'.$i)->applyFromArray(array('font'  => array('bold'  => true),'alignment' => array('horizontal' => Alignment::HORIZONTAL_CENTER,)));
        $sheet->getStyle('H'.$i)->applyFromArray(array('font'  => array('bold'  => true)));
        $il=$i-1;
        $ilx=$i+3;
        $styleArray = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' =>Border::BORDER_THIN
                ),
                 'bottom' => array(
                    'borderStyle' =>Border::BORDER_THIN
                ),
                  'left' => array(
                    'borderStyle' =>Border::BORDER_THIN
                ),
                   'right' => array(
                    'borderStyle' =>Border::BORDER_THIN
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
       
		try{
          $writer = new Xlsx($spreadsheet);
          $name='autoswift_grid.xlsx';
          
          $writer->save($name);
          $content = file_get_contents($name);
        } catch(\Exception $e) {
            exit($e->getMessage());
        }

      header("Content-Disposition: attachment; filename=".$name);

      unlink($name);
      exit($content);
      
      return true;
    }
    public function get_grid(Request $request){
        $vehicle_make=Grid::select('vehicle_make')->groupBy('vehicle_make')->orderBy('vehicle_make')->pluck('vehicle_make','vehicle_make');
        if($request->ajax()){
            if($request->vehicle_model && $request->vehicle_make && $request->variant){
                $year=Grid::select('year')->groupBy('year')->orderBy('year')->where('vehicle_model','=',$request->vehicle_model)->where('vehicle_make','=',$request->vehicle_make)->where('variant','=',$request->variant)->pluck('year','year');
                return $year;
            }
            if($request->vehicle_make && $request->vehicle_model){
                $variant=Grid::select('variant')->groupBy('variant')->orderBy('variant')->where('vehicle_make','=',$request->vehicle_make)->where('vehicle_model','=',$request->vehicle_model)->pluck('variant','variant');
                return $variant;
            }
            if($request->vehicle_make){
                $vehicle_model=Grid::select('vehicle_model')->groupBy('vehicle_model')->orderBy('vehicle_model')->where('vehicle_make','=',$request->vehicle_make)->pluck('vehicle_model','vehicle_model');
               return $vehicle_model;
            }
        }
    } 
}
