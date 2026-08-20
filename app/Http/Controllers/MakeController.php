<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MdMake;
use DB;

class MakeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $make=MdMake::orderBy('created_dt','desc')->get();
        // $make=DB::table('md_make')->paginate(15);
        return view('make',['make'=>$make]);
    }

    public function ShowAdd ()
    {
        return view('make_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdMake::create(array(
            'name'=>$request->name,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('make')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdMake::find($id);
        return view('make_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        $customer=MdMake::find($id);
        $customer->name=$request->name;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }
}
