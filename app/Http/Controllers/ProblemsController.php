<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MdProblem;
use DB;

class ProblemsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $problems=MdProblem::orderBy('created_dt','desc')->get();
        // $problems=DB::table('md_problems')->paginate(15);
        return view('problems',['problems'=>$problems]);
    }

    public function ShowAdd ()
    {
        return view('problems_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdProblem::create(array(
            'problem_desc'=>$request->problem_desc,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('problems')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdProblem::find($id);
        return view('problems_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        $customer=MdProblem::find($id);
        $customer->problem_desc=$request->problem_desc;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }
}
