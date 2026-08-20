<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\MdVersion;

class DeviceVersionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $device_version=MdVersion::orderBy('created_dt','desc')->get();
        // $device_version=DB::table('md_device_version')->paginate(15);
        return view('device_version',['device_version'=>$device_version]);
    }

    public function ShowAdd ()
    {
        return view('device_version_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdVersion::create(array(
            'mc_type'=>$request->mc_type,
            'version_name'=>$request->version_name,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('deviceVersion')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdVersion::find($id);
        return view('device_version_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        $customer=MdVersion::find($id);
        $customer->mc_type=$request->mc_type;
        $customer->version_name=$request->version_name;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }
}
