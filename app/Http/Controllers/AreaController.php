<?php

namespace App\Http\Controllers;

use App\Area;
use App\State;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $area = Area::select('areas.*','states.name as state_name')->join('states', 'areas.state_id', '=', 'states.id')->orderBy('states.name','asc')->orderBy('areas.name','asc')->get();
      	$state = State::orderBy('name', 'asc')->pluck('name','name');
        return view('Area.index',compact('area','state'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $all_state = State::pluck('name', 'id');
      	if($request->ajax()){
            if($request->name){
                $name=Area::select('name')->groupBy('name')->orderBy('name')->where('name','=',$request->name)->pluck('name','name');
               return $name;
            }
        }
        return view('Area.create',compact('all_state'));
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
            'name' => 'required',
            'state_id'=>'required'
        ]);
        $input = $request->all();
        $message = '';
        if(!$this->checkAreaExists($input)){
            $data = Area::create($input);
            $data->save();
            $mode = 'added';
            $message = 'Area Or City created Successfully.';
        } else {
            $mode = 'error';
            $message = 'Area Or City already exists.';
        }
        return redirect()->route('area.index')
                        ->with($mode ,$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
          $all_state = State::pluck('name', 'id');
        return view('Area.edit',compact('area',$area,'all_state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
      if($request->ajax()){
            $in=($request->all());
            $key=array_key_first($in);
            $val=$in[$key];
            $data=Area::where($key,'=',$request->old_value);
            $input[$key]=$val;
            $data=$data->update($input);
            if($data){
                return array('status' =>true,'msg'=>'Successfully Updated');      
            }
            return array('status' =>false,'msg'=>'Somthing went wrong');
          
        }
         
        $request->validate([
            'name' => 'required',
            'state_id'=>'required'
        ]);
        $input = $request->all();   
        $data = Area::findOrFail($area->id);
        $data->update($input);
        return redirect('area')->with('updated','Area Or City Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return back()->with('deleted', 'Area Or City has been deleted');
    }

    public function getstatearea(Request $request)
    {
         $data = Area::orderBy('name','asc')->where('state_id','=',$request->state)->pluck('id','name');
         return $data;
    }

    // Function to check if City already exists in selected Area
    public function checkAreaExists($data){
        $result = Area::where([
                        ['state_id', $data['state_id']],
                        ['name', $data['name']],
                    ])->first();
        if(!empty($result)){
            return true;
        } else {
            return false;
        }
    }

    // Function to create excel for State & cities
    public function make_excel()
    {
        $data = Area::select('areas.*', 'states.name as state_name')->join('states', 'areas.state_id', '=', 'states.id')->orderBy('states.name', 'asc')->orderBy('areas.name', 'asc')->get();
        if ($data) {
            $result = $this->excel($data);
            if ($result == true) {
                return back()->with('add', 'Area Excel has been Generated');
            } else {
                return back()->with('deleted', 'Something went wrong');
            }
        } else {
            return back()->with('updated', 'There are No data to Export');
        }
    }
    
    protected function excel($rows)
    {
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

        $sheet->setTitle('Area Record');
        $sheet->mergeCells('A1:C1');

        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 15,
                'name'  => 'Arial'
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            )
        );
        $sheet->setCellValue('A1', '');
        $sheet->getStyle('A1')->applyFromArray($styleArray);
        $sheet->mergeCells('A2:C2');
        $styleArray = array(
            'font'  => array(
                'size'  => 15,
                'name'  => 'Arial'
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            )
        );
        $sheet->setCellValue('A2', '');
        $sheet->getStyle('A2')->applyFromArray($styleArray);

        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            )
        );

        $styleArray = array(
            'font'  => array(
                'size'  => 11,
                'name'  => 'Calibri',
            ), 'alignment' => array(
                'vertical' => Alignment::VERTICAL_TOP,
            )
        );

        $sheet->getStyle('A4:C4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        // $sheet->getStyle('H4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');

        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);

        $sheet->setCellValue('A4', 'S.No.');
        $sheet->setCellValue('B4', 'State Name');
        $sheet->setCellValue('C4', 'City Name');

        $i = 5;
        $j = 1;
        $total = 0;
        foreach ($rows  as $key => $value) {

            $sheet->getRowDimension($i)->setRowHeight(20);
            $sheet->setCellValue('A' . $i, $j);
            $sheet->setCellValue('B' . $i, $value['state_name']);
            $sheet->setCellValue('C' . $i, $value['name']);
            
            $i++;
            $j++;
        }
        $spreadsheet->getActiveSheet()->getStyle('A4:C' . $i)
            ->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:C' . $i)->applyFromArray($styleArray);
        $sheet->getStyle('A' . $i)->applyFromArray(array('font'  => array('bold'  => true), 'alignment' => array('horizontal' => Alignment::HORIZONTAL_CENTER,)));
        $sheet->getStyle('C' . $i)->applyFromArray(array('font'  => array('bold'  => true)));
        $il = $i - 1;
        $ilx = $i + 3;
        $styleArray = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_THIN
                ),
            ),
        );
        for ($i = 4; $i <= $il; $i++) {
            $sheet->getStyle('A' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('B' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('C' . $i)->applyFromArray($styleArray);
        }
        try {
            $writer = new Xlsx($spreadsheet);
            $name = 'autoswift_area.xlsx';

            $writer->save($name);
            $content = file_get_contents($name);
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        header("Content-Disposition: attachment; filename=" . $name);

        unlink($name);
        exit($content);

        return true;
    }
}