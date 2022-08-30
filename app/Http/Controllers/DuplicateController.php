<?php

namespace App\Http\Controllers;

use App\Duplicate;
use Illuminate\Http\Request;

class DuplicateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $duplicate = Duplicate::orderBy('position', 'ASC')->get();
        return view('Duplicate.index',compact('duplicate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Duplicate.create');
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
            'reason' => 'required'
        ]);
        $input = $request->all();
      
      	$reasons = Duplicate::orderBy('position')->get();
      	foreach($reasons as $reason){
        	$record = Duplicate::findOrFail($reason->id);
          	$newPosition = $reason->position + 1;
        	$record->update(array('position' => $newPosition));
        }
      	
      	$input['position'] = '1';
        $data = Duplicate::create($input);
        $data->save();
      	
        return redirect()->route('duplicate.index')
                        ->with('added','Duplicate Reasons created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Duplicate  $Duplicate
     * @return \Illuminate\Http\Response
     */
    public function show(Duplicate $duplicate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Duplicate  $Duplicate
     * @return \Illuminate\Http\Response
     */
    public function edit(Duplicate $duplicate)
    {
        //
        return view('Duplicate.edit',compact('duplicate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Duplicate  $Duplicate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Duplicate $duplicate)
    {
      $request->validate([
            'reason' => 'required'
        ]);
       
        $input = $request->all();   
        $data = Duplicate::findOrFail($duplicate->id);
        $data->update($input);
        return redirect('duplicate')->with('updated','Duplicate Reasons updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Duplicate  $Duplicate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Duplicate $duplicate)
    {
        $duplicate->delete();
        return back()->with('deleted', 'Duplicate Reasons has been deleted!');
    }
    public function duplicate_position(Request $request){
        if($request->ajax()){
             $data=$request->all();
            foreach ($data as $key => $value) {
                $input['position']=$value;
                $data = Duplicate::findOrFail($key);
                $data->update($input);
            }
            return $arr = array('status' => true,'action'=>'update','msg'=>'Reorder Successfully');
        }
    }
    public function getreason(){
        $data = Duplicate::orderBy('position')->pluck('id','reason');
        return $data;
    }
}
