<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\MdMachineType;

class DeviceTypeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $device_type=MdMachineType::orderBy('mc_id','ASC')->get();
        // $device_type=DB::table('md_device_type')->paginate(15);
        return view('device_type',['device_type'=>$device_type]);
    }

    public function ShowAdd ()
    {
        return view('device_type_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdMachineType::create(array(
            'dev_type'=>$request->dev_type,
            'mc_type'=>$request->mc_type,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('deviceType')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdMachineType::find($id);
        return view('device_type_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        $customer=MdMachineType::find($id);
        $customer->dev_type=$request->dev_type;
        $customer->mc_type=$request->mc_type;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }
}
