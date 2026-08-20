<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\MdCustomers;
use App\Models\TdDeviceTrans;
use App\Models\MdServiceCentre;
use App\Models\TdOpening;
use App\Models\MdVersion;

class CustomerWiseSaleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show(Request $request)
    {
        $customers=MdCustomers::get();
        $sale_in='S';
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $cust_cd=$request->cust_cd;
        if ( $from_date!='' && $to_date!='' && $cust_cd!='') {
            $cust_name=MdCustomers::where('cust_cd',$cust_cd)->value('cust_name');
            $datas=DB::table('td_device_trans')->where('cust_cd',$cust_cd)->get();
            // $datas=DB::table('td_device_trans')->where('cust_cd',$cust_cd)->groupBy('mc_type')->get();
            $alldatas=[];
            foreach ($datas as $key => $value) {
                // $valll=TdDeviceTrans::where('mc_type',$value->mc_type)
                //         ->where('trans_type',$sale_in)
                //         ->whereDate('arrival_dt','>=',date('Y-m-d',strtotime($from_date)))
                //         ->whereDate('arrival_dt','<=',date('Y-m-d',strtotime($to_date)))
                //         ->get();
                //     // return $valll;
                //     $total_qty=0;
                //     foreach ($valll as $value1) {
                //         $total_qty += ABS($value1->mc_qty);
                //     }
                // $value->total_qty=$total_qty;
                $value->mc_version_name=MdVersion::where('sl_no',$value->mc_version)->value('version_name');
                $value->mc_qty=ABS($value->mc_qty);
                array_push($alldatas,$value);
            }
            // return $alldatas;
        }else{
            $from_date='';
            $to_date='';
            $cust_name='';
            $alldatas=[];
        }
        return view('reports.customer_wise_sale',['sale_in'=>$sale_in,'customers'=>$customers,'from_date'=>$from_date,'to_date'=>$to_date,
        'cust_name'=>$cust_name,'cust_cd'=>$cust_cd,'alldatas'=>$alldatas]);
    }
}
