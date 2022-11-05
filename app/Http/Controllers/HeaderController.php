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
        return view('Header.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationArr = [];
		$messages = [
			'expire.required' => 'The validity field is required.',
			'iisla_no.required' => 'The iiisla no field is required.',
		];
		$validationArr = [
            'licence_no' => 'required',
            'email1' => 'required',
            'email2' => 'required',
            'mobile_number' => 'required',
            'authorizer_name' => 'required',
            'authorizer_education' => 'required',
            'authorizer_designation' => 'required',
            'report_heading' => 'required',
            'logo' => 'nullable|image|mimes:jpg,png,gif,jpeg'
        ];
        if($request->ex_validity=='validity'){
			$validationArr['expire'] = 'required';		   
        }else{
			$validationArr['iisla_no'] = 'required';
        }
		$request->validate($validationArr, $messages);
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
            $name = 'logo_auto_'.time().'.'.$file->getClientOriginalExtension();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['logo'] = $name;
        }
		$header = Header::create($input);
        $header->save();
        return redirect('header')->with('added', 'Header Added Successfully.');
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
		$validationArr = [];
		$messages = [
			'expire.required' => 'The validity field is required.',
			'iisla_no.required' => 'The iiisla no field is required.',
		];
		$validationArr = [
            'licence_no' => 'required',
            'email1' => 'required',
            'email2' => 'required',
            'mobile_number' => 'required',
            'authorizer_name' => 'required',
            'authorizer_education' => 'required',
            'authorizer_designation' => 'required',
            'report_heading' => 'required',
            'logo' => 'nullable|image|mimes:jpg,png,gif,jpeg'
        ];
        if($request->ex_validity=='validity'){
			$validationArr['expire'] = 'required';		   
        }else{
			$validationArr['iisla_no'] = 'required';
        }
		$request->validate($validationArr, $messages);
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
			$name = 'logo_auto_'.time().'.'.$file->getClientOriginalExtension();
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
		if($header->id == 1) {
			return redirect('header')->with('deleted', 'This Header can not be deleted !');
		}
		$header->delete();
		return redirect('header')->with('deleted', 'Header has been deleted !');
    }
}
