<?php

namespace App\Http\Controllers;
use App\Staff;
use Image;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Staff::orderBy('position')->get();
        return view('Staff.index',compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Staff.create');
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
            'mobile_number' => 'required',
            'address' => 'required',
            'sort_name' => 'required',
        ]);
         $input = $request->all();
         $input['status']=$request->status?1:0;
        if($request->file('photo')!=null){
            $file = $request->file('photo');
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/document/';
            $name = time().'.'.$file->getClientOriginalExtension();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['photo'] = $name;
        }
        $data = Staff::create($input);
        $data->save();
        return redirect()->route('staff.index')
                        ->with('added','Staff Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
         $this->authorize('isSuper');
        return view('Staff.edit',compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
         $this->authorize('isSuper');
         $request->validate([
            'name' => 'required',
            'mobile_number' => 'required',
            'address' => 'required',
            'sort_name' => 'required',
        ]);
         $input = $request->all();
         $input['status']=$request->status?1:0;
        if($request->file('photo')!=null){
            $file = $request->file('photo');
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/document/';
            $name = time().'.'.$file->getClientOriginalExtension();
            $optimizeImage->save($optimizePath.$name, 72);
            $input['photo'] = $name;
        }
        $data = Staff::findOrFail($staff->id);
        $data->update($input);
        return redirect()->route('staff.index')->with('updated','Staff Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $this->authorize('isSuper');
        if ($staff->photo != null) {
            $image_file = @file_get_contents(public_path().'/images/user/'.$staff->photo);
                if($image_file){        
                    unlink(public_path().'/images/user/'.$staff->photo);
                }
        }
        $staff->delete();
        return back()->with('deleted', 'Duplicate has been deleted');
    }
    public function staff_status(Request $request){
        if($request->ajax()){
            $staff = Staff::findOrFail($request->id); 
            $status=$staff->status?0:1;
            $data=$staff->update(array('status'=>$status));
            $arr = array('status' => false,'action'=>'Submited','msg' => 'Somthing Went Wrong');
            if($data){
                $arr = array('status' => true,'action'=>'Submited','msg' => 'Status Change Successfully');
            }
            return Response()->json($arr);   
        }
       
    }
     public function staff_position(Request $request){
        if($request->ajax()){
             $data=$request->all();
            foreach ($data as $key => $value) {
                $input['position']=$value;
                $data = Staff::findOrFail($key);
                $data->update($input);
            }
            return $arr = array('status' => true,'action'=>'update','msg'=>'Reorder Successfully');
        }
    }
}
