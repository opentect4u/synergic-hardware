<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\MdCustomers;
use App\Models\TdDeviceTrans;
use App\Models\MdServiceCentre;
use App\Models\TdOpening;

class ItemWiseTransferController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show(Request $request)
    {
        $sale_in='T';
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        if ( $from_date!='' && $to_date!='') {
            $datas=DB::table('td_device_trans')->groupBy('mc_type')->get();
            $alldatas=[];
            foreach ($datas as $key => $value) {
                $valll=TdDeviceTrans::where('mc_type',$value->mc_type)
                        ->where('trans_type',$sale_in)
                        ->whereDate('arrival_dt','>=',date('Y-m-d',strtotime($from_date)))
                        ->whereDate('arrival_dt','<=',date('Y-m-d',strtotime($to_date)))
                        ->get();
                    // return $valll;
                    $total_qty=0;
                    foreach ($valll as $value1) {
                        $total_qty += ABS($value1->mc_qty);
                    }
                // $value->total_qty=$total_qty;
                $value->total_qty=$total_qty;
                array_push($alldatas,$value);
            }
            // return $alldatas;
        }else{
            $from_date='';
            $to_date='';
            $alldatas=[];
        }
        return view('reports.item_wise_sale',['sale_in'=>$sale_in,'from_date'=>$from_date,'to_date'=>$to_date,'alldatas'=>$alldatas]);
    }
}
