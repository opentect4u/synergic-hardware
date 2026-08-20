<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\MdCustomers;
use App\Models\TdDeviceTrans;
use App\Models\MdServiceCentre;
use App\Models\TdOpening;
use App\Models\TdDeviceAmc;

class WarrantyStatusController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show(Request $request)
    {
        $sl_no=$request->sl_no;
        // $item=$request->item;
        // return $sl_no;
        if ($sl_no!='') {
            $alldatas=[];
            $datas=TdDeviceAmc::where('sl_no',$sl_no)->get();
			//return $datas;
            foreach ($datas as $key => $value) {
                $data=DB::table('td_device_trans')
                    ->leftJoin('md_version','md_version.sl_no','=','td_device_trans.mc_version')
                    ->leftJoin('md_customers','md_customers.cust_cd','=','td_device_trans.cust_cd')
                    ->select('td_device_trans.*','md_version.version_name as version_name','md_customers.cust_name as cust_name')
                    ->where('td_device_trans.trans_dt',$value->trans_dt)
                    ->where('td_device_trans.trans_no',$value->trans_no)
                    ->where('td_device_trans.trans_type',$value->trans_type)
                    ->where('td_device_trans.mc_type',$value->mc_type)
                    ->get();
				//return $data;
                // return $data[0]->bill_no;
                $value->bill_no=isset($data[0]->bill_no)?$data[0]->bill_no:'';
                $value->arrival_dt=isset($data[0]->arrival_dt)?$data[0]->arrival_dt:'';
                $value->mc_name=isset($data[0]->mc_name)?$data[0]->mc_name:'';
                $value->version_name=isset($data[0]->version_name)?$data[0]->version_name:'';
                $value->cust_name=isset($data[0]->cust_name)?$data[0]->cust_name:'';
                array_push($alldatas,$value);
            }
            // return $datas;
            // return $alldatas;

        }else{
            $sl_no=''; 
            $alldatas=[];
        }
        return view('reports.warranty_status',['sl_no'=>$sl_no,'alldatas'=>$alldatas]);
    }
}
