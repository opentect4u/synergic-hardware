<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\MdMachineType;
use App\Models\MdCustomers;
use App\Models\TdDeviceTrans;
use App\Models\MdServiceCentre;
use App\Models\TdOpening;

class DeviceLedgerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
	public function getFinancialStartDate()
    {
        if ( date('m') > 3 ) {
            $startDate = date('Y').'-04-01';
        } else {
            $year = date('Y') - 1;
            $startDate = $year.'-04-01';
        }
        return $startDate;
    }

    public function Show(Request $request)
    {
        $from_dt=$request->from_dt;
        $to_dt=$request->to_dt;
        $device_desc=$request->device_desc;
        // return $device_desc;
        if ($from_dt!='' && $to_dt!='' && $device_desc!='') {
            //$year = ( date('m') > 12) ? date('Y') + 1 : date('Y');
            //$finalcial_date=$year.'-04-01';
			$finalcial_date=$this->getFinancialStartDate();
            // return $finalcial_date;
            $opening=TdOpening::where('mc_type',$device_desc)->where('date',$finalcial_date)->get();
            // return $opening;
            $alldatas=DB::table('td_device_trans')
                ->leftJoin('md_customers','md_customers.cust_cd','=','td_device_trans.cust_cd')
                ->select('td_device_trans.*','md_customers.cust_name as cust_name')
                ->where('td_device_trans.mc_type',$device_desc)
                ->where('td_device_trans.approval_status','U')
                ->whereDate('td_device_trans.arrival_dt','>=',date('Y-m-d',strtotime($from_dt)))
                ->whereDate('td_device_trans.arrival_dt','<=',date('Y-m-d',strtotime($to_dt)))
                ->orderBy('td_device_trans.arrival_dt','asc')
                ->orderBy('td_device_trans.trans_no','asc')
                ->get();
            // return $alldatas;
            // for ($i=0; $i < count($alldatas); $i++) { 
            //     return $alldatas[$i];
            // }
            $device_name=MdMachineType::where('mc_id',$device_desc)->value('mc_type');
        } else{
          
            $device_desc='';
            $device_name='';
            $alldatas=[];
            $opening=[];
        }
        $machines=MdMachineType::get();
        return view('reports.device_ledger',['from_dt'=>$from_dt,'to_dt'=>$to_dt,'device_desc'=>$device_desc,
        'machines'=>$machines,'opening'=>$opening,'alldatas'=>$alldatas,'device_name'=>$device_name]);
    }
}
