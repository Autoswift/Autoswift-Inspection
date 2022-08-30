<?php

namespace App\Http\Controllers;

use App\Declaration;
use Illuminate\Http\Request;

class DeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $declaration = Declaration::orderBy('position')->get();
        return view('Declaration.index',compact('declaration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('Declaration.create');
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
            'note' => 'required'
        ]);
       
        $input = $request->all();  
      	$declarations = Declaration::orderBy('position')->get();
      	foreach($declarations as $declaration){
        	$record = Declaration::findOrFail($declaration->id);
          	$newPosition = $declaration->position + 1;
        	$record->update(array('position' => $newPosition));
        }
      	
      	$input['position'] = '1';
        $data=Declaration::create($input);
      
        return redirect()->route('declaration.index')
                        ->with('added','Declaration Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function show(Declaration $declaration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function edit(Declaration $declaration)
    {
         return view('Declaration.edit',compact('declaration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Declaration $declaration)
    {
        $request->validate([
            'note' => 'required'
        ]);
       
        $input = $request->all();   
        $data = Declaration::findOrFail($declaration->id);
        $data->update($input);
        return redirect('declaration')->with('updated','Declaration Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function declaration_position(Request $request){
        if($request->ajax()){
             $data=$request->all();
            foreach ($data as $key => $value) {
                $input['position']=$value;
                $data = Declaration::findOrFail($key);
                $data->update($input);
            }
            return $arr = array('status' => true,'action'=>'update','msg'=>'Reorder Successfully');
        }
    }
    public function destroy(Declaration $declaration)
    {
        $declaration->delete();
        return back()->with('deleted', 'Declaration has been deleted');
    }
}
