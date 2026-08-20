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

class DateWiseInvoiceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show(Request $request)
    {
        $sale_in='I';
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        if ( $from_date!='' && $to_date!='') {
            // $datas=DB::table('td_device_trans')->groupBy('mc_type')->get();
            $alldatas=DB::table('td_device_trans')
                    ->leftJoin('md_customers','md_customers.cust_cd','=','td_device_trans.cust_cd')
                    // ->leftJoin('md_mc_type','md_mc_type.mc_id','=','td_device_trans.mc_type')
                    ->leftJoin('md_version','md_version.sl_no','=','td_device_trans.mc_version')
                    ->select('td_device_trans.*','md_customers.cust_name as cust_name','md_version.version_name as version_name')
                    ->where('td_device_trans.trans_type','S')
                    ->whereDate('td_device_trans.arrival_dt','>=',date('Y-m-d',strtotime($from_date)))
                    ->whereDate('td_device_trans.arrival_dt','<=',date('Y-m-d',strtotime($to_date)))
                    // ->groupBy('mc_type')
                    ->orderBy('td_device_trans.arrival_dt')
                    ->get();
            // return $datas;
            // $alldatas=[];
            // foreach ($datas as $key => $value) {
            //     $valll=TdDeviceTrans::where('mc_type',$value->mc_type)
            //             ->where('trans_type',$sale_in)
            //             ->whereDate('arrival_dt','>=',date('Y-m-d',strtotime($from_date)))
            //             ->whereDate('arrival_dt','<=',date('Y-m-d',strtotime($to_date)))
            //             ->get();
            //         // return $valll;
            //         $total_qty=0;
            //         foreach ($valll as $value1) {
            //             $total_qty += ABS($value1->mc_qty);
            //         }
            //     // $value->total_qty=$total_qty;
            //     $value->total_qty=$total_qty;
            //     array_push($alldatas,$value);
            // }
            // return $alldatas;
        }else{
            $from_date='';
            $to_date='';
            $alldatas=[];
        }
        return view('reports.date_wise_invoice',['sale_in'=>$sale_in,'from_date'=>$from_date,'to_date'=>$to_date,'alldatas'=>$alldatas]);
    }
}
