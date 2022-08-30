<?php

namespace App\Http\Controllers;

use App\Header;
use Illuminate\Http\Request;
use Image;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $header = Header::all();
        return view('Header.index',compact('header'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Header  $header
     * @return \Illuminate\Http\Response
     */
    public function show(Header $header)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Header  $header
     * @return \Illuminate\Http\Response
     */
    public function edit(Header $header)
    {
        return view('Header.edit',compact('header'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Header  $header
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Header $header)
    {
       $request->validate([
            'licence_no' => 'required',
            'email1' => 'required',
            'email2' => 'required',
            'mobile_number' => 'required',
            'authorizer_name' => 'required',
            'authorizer_education' => 'required',
            'authorizer_designation' => 'required',
            'report_heading' => 'required',
            'logo' => 'nullable|image|mimes:jpg,png,gif,jpeg'
        ]);
        if($request->ex_validity=='validity'){
           $request->validate([
            'expire' => 'required',
           ]);  
        }else{
            $request->validate([
            'iisla_no' => 'required',
           ]);
        }
        $input = $request->all();
        if($request->ex_validity=='validity'){
           $input['iisla_no'] = Null;  
        }else{
           $input['expire']=Null;
        }
        if($request->file('logo')!=null){
            $file = $request->file('logo');
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/image/';
            $name = 'logo_auto.'.$file->getClientOriginalExtension();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['logo'] = $name;
        }
        $header = Header::findOrFail($header->id);
        $header->update($input);
        return redirect('header')->with('updated', 'Header Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Header  $header
     * @return \Illuminate\Http\Response
     */
    public function destroy(Header $header)
    {
        //
    }
}
