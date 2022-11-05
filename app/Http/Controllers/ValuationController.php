<?php

namespace App\Http\Controllers;

use App\Valuation;
use Illuminate\Http\Request;
use File;
use App\Finance;

class ValuationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $valuation = Valuation::orderBy('position')->latest()->get();
        return view('Valuation.index',compact('valuation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Valuation.create');
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
            'short_name' => 'required|string|max:6|unique:valuations,short_name'
        ]);
        $input = $request->all();
        if($request->file('gridpdf')){
            foreach($request->file('gridpdf') as $file){
                $fileName = time().$file->getClientOriginalName().'.'.$file->extension();  
                $file->move(public_path('/com_pdf/'), $fileName);
                $com_pdf[]= $fileName;
            }
            $input['grid_pdf']=json_encode($com_pdf); 
        }
        $data = Valuation::create($input);
        $data->save();
        return redirect('valuation')->with('added','Valuation Initiated By Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function show(Valuation $valuation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function edit(Valuation $valuation)
    {
        //
        return view('Valuation.edit',compact('valuation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valuation $valuation)
    {
        $request->validate([
            'name' => 'required',
			'short_name' => 'required|string|max:6|unique:valuations,short_name,'.$valuation->id
        ]);
        $input = $request->all(); 
        if($request->file('gridpdf')){
            foreach($request->file('gridpdf') as $file){
                $fileName = time().rand().'.'.$file->extension();  
                $file->move(public_path('/com_pdf/'), $fileName);
                $com_pdf=json_decode($valuation->grid_pdf); 
                $com_pdf[]= $fileName;
            }
             
            $input['grid_pdf']=json_encode($com_pdf); 
        }
        $data = Valuation::findOrFail($valuation->id);
        $data->update($input);
        return redirect('valuation')->with('updated','Valuation Initiated By Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valuation $valuation)
    {
      	$valuationReports = Finance::where('valuation_by', $valuation->id)->first();
      
      	if(empty($valuationReports)){
        	$valuation->delete();
          	$msg = 'Valuation Initiated By has been deleted';
          	$alertMode = 'updated';
        } else {
          	$msg = 'Valuation Initiated By cannot be deleted';
          	$alertMode = 'deleted';
        }
        
        return back()->with($alertMode, $msg);
    }
  
  	// Change Valuation Position
    public function valuation_position(Request $request){
        if($request->ajax()){
             $data=$request->all();
            foreach ($data as $key => $value) {
                $input['position']=$value;
                $data = Valuation::findOrFail($key);
                $data->update($input);
            }
            return $arr = array('status' => true,'action'=>'update','msg'=>'Reorder Successfully');
        }
    }
    public function get_grid_pdf(Request $request){
         if($request->ajax()){
            if($request->valu_id){
                $data = Valuation::select('grid_pdf')->whereId($request->valu_id)->first();
                if($data->grid_pdf){
                    return $arr = array('status' => true,'action'=>'get','data'=>$data,'msg'=>'Retrieve Successfully');
                }
            }
            return $arr = array('status' => false,'action'=>'get','msg'=>'There are No Grid to show');
         }
    }
    public function pdf_remove(Request $request){
         if($request->ajax()){
            $data = Valuation::findOrFail($request->valuation);
            $pdf=json_decode($data->grid_pdf); 
            if (File::exists(public_path('com_pdf').'/'.$pdf[$request->pdf_id])) {
                unlink(public_path('com_pdf').'/'.$pdf[$request->pdf_id]);
                unset($pdf[$request->pdf_id]);
                // $pdf=json_encode($pdf);
                $pdf=empty($pdf) ? NULL : json_encode($pdf);
              	$data->update(['grid_pdf'=>$pdf]);
                 return $arr = array('status' => true,'action'=>'post','msg'=>'Grid Pdf Deleted Successfully');
            }
             return $arr = array('status' => false,'action'=>'post','msg'=>'Somthing went Wrong');
         }
    }
	
	public function change_status(Request $request){
        if($request->ajax()){
            $data = Valuation::findOrFail($request->id);
            $data=$data->update(array('status'=>$request->status));
            if($data){
                $arr = array('status' => true,'action'=>'update','msg' => 'Status Change Successfully');
            }
            return Response()->json($arr);
        }
    }
}
