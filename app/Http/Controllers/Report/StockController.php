<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\MdCustomers;
use App\Models\TdDeviceTrans;
use App\Models\MdServiceCentre;
use App\Models\TdOpening;
use App\Models\TdStockThreshold;

class StockController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
	
	
	// public function getFinancialStartDate()
    // {
    //     if ( date('m') > 3 ) {
    //         $startDate = date('Y').'-04-01';
    //     } else {
    //         $year = date('Y') - 1;
    //         $startDate = $year.'-04-01';
    //     }
    //     return $startDate;
    // }
	public function getFinancialStartDate($inputDate)
{
    $month = date('m', strtotime($inputDate));
    $year  = date('Y', strtotime($inputDate));

    if ($month >= 4) {
        // April or later
        return $year . '-04-01';
    } else {
        // Jan–March
        return ($year - 1) . '-04-01';
    }
}
	
	public function getFinancialEndDate()
    {
        if ( date('m') > 3 ) {
            $year = date('Y') + 1;
            $date = $year.'-04-01';
            $endDate = date ("Y-m-d", strtotime ($date ."-1 days"));
        } else {
            $date = date('Y').'-04-01';
            $endDate = date ("Y-m-d", strtotime ($date ."-1 days"));
        }
        return $endDate;
    }

	

    public function Show(Request $request)
    {
        $date=$request->sale_dt;
        $item=$request->item;
        // return $date;
        if ($date!='' && $item=='N') {
            $datas=DB::table('td_device_trans')->groupBy('mc_type')->get();
            // return $datas;
            $service_centre=MdServiceCentre::orderby('sl_no','ASC')->get();
            // return $service_centre;
            $alldatas=[];
            foreach ($datas as $key => $value) {
                // return $value;
                for ($i=0; $i < count($service_centre); $i++) { 
                    // return $service_centre[$i];
                    $center_name= $service_centre[$i]['center_name'];
                    $center_id= $service_centre[$i]['sl_no'];
                    $total_qty=0;
                    
                
					$finalcial_date=$this->getFinancialStartDate($date);
				
                    $stock_opening=TdOpening::where('mc_type',$value->mc_type)->where('serv_ctr',$center_id)
                        ->whereDate('date',$finalcial_date)->value('total_qty');
                    // return $stock_opening;
                    $total_qty +=$stock_opening;
                    $valll=TdDeviceTrans::where('mc_type',$value->mc_type)->where('serv_ctr',$center_id)
                        ->where('approval_status','U')
                        ->whereDate('arrival_dt','>=',$finalcial_date)
                        ->whereDate('arrival_dt','<=',date('Y-m-d',strtotime($date)))
                        ->get();
                    // return $valll;
                    foreach ($valll as $value1) {
                        $total_qty +=$value1->mc_qty;
                    }
					
                     // HERE a insert query in td_opening table for update opening stock
                    
                    //    if($total_qty > 0 || $total_qty < 0){
                    //    $opening=new TdOpening();
                    //    $opening->mc_type=$value->mc_type;
                    //    $opening->serv_ctr=$center_id;
                     //   $opening->date=date('2026-04-01');
                     //   $opening->total_qty=$total_qty;
                     //   $opening->save();
                      //  }
					
                    if ($center_name=="SHANTI PALLY") {
                        $value->kolkata=$total_qty;
                    }else if ($center_name=="Darjeeling CCB") {
                        $value->Darjeeling_CCB=$total_qty;
                    } else {
                        $value->$center_name=$total_qty;
                    }
                }
                array_push($alldatas,$value);
                // return $value;
            }
            // return $alldatas;

        }elseif ($date!='' && $item=='C') {
            $alldatas=[];
        } else{
            $date=''; 
            $item='';
            $alldatas=[];
        }
        $thresholds = TdStockThreshold::pluck('stk_val', 'mc_id');

        return view('reports.stock',[
            'date' => $date,
            'item' => $item,
            'alldatas' => $alldatas,
            'thresholds' => $thresholds,
        ]);
    }
}
