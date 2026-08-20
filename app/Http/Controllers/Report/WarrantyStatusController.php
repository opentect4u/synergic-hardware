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
    public function ShowPurchase(Request $request)
    {
        $sl_no=$request->sl_no;
        if ($sl_no != '') {
            $alldatas = DB::table('td_device_trans')
                ->join('td_device_amc', function($join) {
                    $join->on('td_device_trans.trans_dt', '=', 'td_device_amc.trans_dt')
                        ->on('td_device_trans.trans_no', '=', 'td_device_amc.trans_no')
                        ->on('td_device_trans.mc_type', '=', 'td_device_amc.mc_type');
                })
                ->join('md_make', 'md_make.sl_no', '=', 'td_device_trans.make')
                ->join('md_service_centre', 'md_service_centre.sl_no', '=', 'td_device_trans.serv_ctr')
                ->select(
                    'td_device_trans.*', 
                    'td_device_amc.sl_no',
                    'td_device_amc.amc_from',
                    'td_device_amc.amc_to',
                    'md_make.name as make_name',
                    'md_service_centre.center_name'
                )
                ->where('td_device_amc.sl_no', $sl_no)
                ->where('td_device_amc.trans_type', 'P')
                ->first(); // returns single object or null

            // Wrap it in an array so Blade can loop safely
            $alldatas = $alldatas ? [$alldatas] : [];
        } else {
            $sl_no = '';
            $alldatas = []; // empty array
        }

        return view('reports.warranty_status_purchase', [
            'sl_no' => $sl_no,
            'alldatas' => $alldatas
        ]);
    }

    public function ShowCurrentMonthSale()
    {
        $alldatas = DB::table('td_device_amc')
            ->join('td_device_trans', function($join) {
                $join->on('td_device_trans.trans_dt', '=', 'td_device_amc.trans_dt')
                    ->on('td_device_trans.trans_no', '=', 'td_device_amc.trans_no')
                    ->on('td_device_trans.mc_type', '=', 'td_device_amc.mc_type')
                    ->on('td_device_trans.trans_type', '=', 'td_device_amc.trans_type');
            })
            ->leftJoin('md_version', 'md_version.sl_no', '=', 'td_device_trans.mc_version')
            ->leftJoin('md_customers', 'md_customers.cust_cd', '=', 'td_device_trans.cust_cd')
            ->select(
                'td_device_trans.*',
                'td_device_amc.sl_no',
                'td_device_amc.amc_from',
                'td_device_amc.amc_to',
                'md_version.version_name as version_name',
                'md_customers.cust_name as cust_name',
                'md_customers.cust_ph_no as cust_ph_no'
            )
            ->where('td_device_amc.trans_type', 'S')
            ->whereYear('td_device_amc.amc_to', date('Y'))
            ->whereMonth('td_device_amc.amc_to', date('m'))
            ->get()
            ->groupBy(function($item) {
                return implode('|', [
                    $item->cust_cd,
                    $item->bill_no,
                    $item->arrival_dt,
                    $item->amc_from,
                    $item->amc_to,
                ]);
            })
            ->map(function($items) {
                $first = $items->first();
                $first->sl_no = $items->pluck('sl_no')->filter()->unique()->implode(', ');
                $first->mc_name = $items->pluck('mc_name')->filter()->unique()->implode(', ');
                $first->version_name = $items->pluck('version_name')->filter()->unique()->implode(', ');
                return $first;
            })
            ->values();

        return view('reports.warranty_status_current_month', ['alldatas' => $alldatas]);
    }

    public function ShowCurrentMonthPurchase()
    {
        $alldatas = DB::table('td_device_amc')
            ->join('td_device_trans', function($join) {
                $join->on('td_device_trans.trans_dt', '=', 'td_device_amc.trans_dt')
                    ->on('td_device_trans.trans_no', '=', 'td_device_amc.trans_no')
                    ->on('td_device_trans.mc_type', '=', 'td_device_amc.mc_type');
            })
            ->join('md_make', 'md_make.sl_no', '=', 'td_device_trans.make')
            ->join('md_service_centre', 'md_service_centre.sl_no', '=', 'td_device_trans.serv_ctr')
            ->select(
                'td_device_trans.*',
                'td_device_amc.sl_no',
                'td_device_amc.amc_from',
                'td_device_amc.amc_to',
                'md_make.name as make_name',
                'md_service_centre.center_name'
            )
            ->where('td_device_amc.trans_type', 'P')
            ->whereYear('td_device_amc.amc_to', date('Y'))
            ->whereMonth('td_device_amc.amc_to', date('m'))
            ->get();

        return view('reports.warranty_status_current_month_purchase', ['alldatas' => $alldatas]);
    }
}
