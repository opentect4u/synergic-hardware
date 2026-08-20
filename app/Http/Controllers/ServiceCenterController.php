<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\MdServiceCentre;

class ServiceCenterController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $service_centre=MdServiceCentre::orderBy('created_dt','desc')->get();
        // $service_centre=DB::table('md_service_centre')->paginate(15);
        return view('service_centre',['service_centre'=>$service_centre]);
    }

    public function ShowAdd ()
    {
        return view('service_centre_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdServiceCentre::create(array(
            'center_name'=>$request->center_name,
            'address'=>$request->address,
            'in_charge'=>$request->in_charge,
            'cnct_no'=>$request->cnct_no,
            'email'=>$request->email,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('serviceCentre')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdServiceCentre::find($id);
        return view('service_centre_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        $customer=MdServiceCentre::find($id);
        $customer->center_name=$request->center_name;
        $customer->address=$request->address;
        $customer->cnct_no=$request->cnct_no;
        $customer->email=$request->email;
        $customer->in_charge=$request->in_charge;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }
}
