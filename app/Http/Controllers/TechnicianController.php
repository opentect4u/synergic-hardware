<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MdTechnician;
use DB;

class TechnicianController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $technician=MdTechnician::orderBy('created_dt','desc')->get();
        // $technician=DB::table('md_technician')->paginate(15);
        return view('technician',['technician'=>$technician]);
    }

    public function ShowAdd ()
    {
        return view('technician_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdTechnician::create(array(
            'emp_code'=>$request->emp_code,
            'tech_name'=>$request->tech_name,
            'tech_ph'=>$request->tech_ph,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('technician')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdTechnician::find($id);
        return view('technician_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->emp_code;
        $customer=MdTechnician::find($id);
        $customer->tech_name=$request->tech_name;
        $customer->tech_ph=$request->tech_ph;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }
}
