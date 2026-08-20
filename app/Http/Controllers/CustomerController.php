<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\MdCustomers;

class CustomerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $customers=MdCustomers::orderBy('created_dt','desc')->get();
        // $customers=DB::table('md_customers')->paginate(15);
        return view('customers',['customers'=>$customers]);
    }

    public function ShowAdd ()
    {
        return view('customers_add_edit');
    }

    public function Add(Request $request)
    {
        // return $request;
        MdCustomers::create(array(
            'cust_name'=>$request->name,
            'cust_addr'=>$request->address,
            'cust_ph_no'=>$request->phone_no,
            'cust_email'=>$request->email,
            'created_by'=>auth()->user()->user_name,
            'created_dt'=>date('Y-m-d H:i:s'),
        ));
        return redirect()->route('customer')->with('success','success');
    }

    public function ShowEdit($id)
    {
        // return $id;
        $customer=MdCustomers::find($id);
        return view('customers_add_edit',['customer'=>$customer]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        $customer=MdCustomers::find($id);
        $customer->cust_name=$request->name;
        $customer->cust_ph_no=$request->phone_no;
        $customer->cust_email=$request->email;
        $customer->cust_addr=$request->address;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }
}
