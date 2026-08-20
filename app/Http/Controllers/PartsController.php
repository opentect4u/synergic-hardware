<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\MdParts;

class PartsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $parts=MdParts::orderBy('created_dt','desc')->get();
        // $parts=DB::table('md_parts')->paginate(15);
        return view('parts',['parts'=>$parts]);
    }

    public function ShowAdd ()
    {
        return view('parts_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdParts::create(array(
            'parts_desc'=>$request->parts_desc,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('part')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdParts::find($id);
        return view('parts_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        $customer=MdParts::find($id);
        $customer->parts_desc=$request->parts_desc;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }

}
