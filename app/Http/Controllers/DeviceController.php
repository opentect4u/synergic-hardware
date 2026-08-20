<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\TdDeviceTrans;
use App\Models\MdMachineType;
use App\Models\MdServiceCentre;
use App\Models\MdMake;
use App\Models\TdDeviceAmc;

class DeviceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show()
    {
        $date=date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
        // $devices=TdDeviceTrans::where('approval_status','U')
        $devices=DB::table('td_device_trans')
            ->leftJoin('md_service_centre','md_service_centre.sl_no','=','td_device_trans.serv_ctr')
            ->select('td_device_trans.*','md_service_centre.center_name as center_name')
            ->where('td_device_trans.approval_status','U')
            ->where('td_device_trans.trans_dt','>=',$date)
            ->whereIn('td_device_trans.trans_type',['I','T','D'])
            ->groupBy('td_device_trans.trans_no','td_device_trans.trans_dt')
            ->orderBy('td_device_trans.trans_no','ASC')
            ->orderBy('td_device_trans.trans_dt','desc')
            ->get();
        // return $devices;
        return view('devices',['devices'=>$devices]);
    }

    public function Delete (Request $request)
    {
        $trans_dt=$request->trans_dt;
        $trans_no=$request->trans_no;
        $customer=TdDeviceTrans::where('trans_dt',$trans_dt)->where('trans_no',$trans_no)->delete();

        $msg="Success";
        $arrNewResult = array();
        $arrNewResult['msg'] = $msg;
        $status_json = json_encode($arrNewResult);
        echo $status_json;
    }

    public function ShowAdd ()
    {
        $machines=MdMachineType::get();
        $serviceCenter=MdServiceCentre::get();
        $mdmakes=MdMake::get();
        return view('devices_add_edit',['machines'=>$machines,'serviceCenter'=>$serviceCenter,
        'mdmakes'=>$mdmakes]);
    }

    public function Add(Request $request)
    {
        // return $request;
        $trans_details= TdDeviceTrans::whereDate('trans_dt',date('Y-m-d'))->orderBy('trans_no','DESC')->get();
        if (count($trans_details)>0) {
            $trans_no=$trans_details[0]['trans_no'] + 1;
        }else{
            $trans_no=1;
        }
        // return $trans_no;
        if ($request->trans_type=="I") {
            for ($i=0; $i < count($request->mc_type); $i++) { 
                $mc_name=MdMachineType::where('mc_id',$request->mc_type[$i])->value('mc_type');
                // return $mc_name;
                TdDeviceTrans::create(array(
                    'trans_dt'=>date('Y-m-d'),
                    'trans_no'=>$trans_no,
                    'trans_type'=>$request->trans_type,
                    'bill_no'=>$request->bill_no,
                    'arrival_dt'=>date('Y-m-d',strtotime($request->arrival_dt)),
                    'warranty_period' => $request->warr_prd[$i],
                    'mc_type'=>$request->mc_type[$i],
                    'mc_name'=>$mc_name,
                    'mc_qty'=>$request->mc_qty[$i],
                    'serv_ctr'=>$request->srv_ctr,
                    'remarks'=>$request->remarks,
                    'make'=>$request->make,
                    'created_by'=>auth()->user()->user_name,
                    'created_dt'=>date('Y-m-d H:i:s'),
                ));

                $slFrm=$request->sl_frm[$i];
                $slTo=$request->sl_to[$i];
                $prd=$request->warr_prd[$i];
                $amcDt = date('Y-m-d', strtotime("+$prd months", strtotime($request->arrival_dt)));
                if ($slFrm > 0  && $slTo > 0) {
                    // return "if block";
                    while($slFrm <= $slTo ){
                        // echo $slFrm."  _ ";
                        TdDeviceAmc::create(array(
                            'trans_dt'=>date('Y-m-d'),
                            'trans_no'=>$trans_no,
                            'trans_type'=>'P',
                            'mc_type'=>$request->mc_type[$i],
                            'sl_no'=>$slFrm,
                            'amc_from'=>date('Y-m-d', strtotime($request->arrival_dt)),
                            'amc_to'=>$amcDt,
                        ));
                        $slFrm ++;
                    }
                }else{
                    $c_sl=$request->c_sl[$i];
                    if ($c_sl !=null) {
                        // return $c_sl;
                        $array_c_sl = explode(',', $c_sl); 
                        // return $array;
                        for ($j=0; $j < count($array_c_sl); $j++) { 
                            // echo $array_c_sl[$j]."  ";
                            TdDeviceAmc::create(array(
                                'trans_dt'=>date('Y-m-d'),
                                'trans_no'=>$trans_no,
                                'trans_type'=>'P',
                                'mc_type'=>$request->mc_type[$i],
                                'sl_no'=>$array_c_sl[$j],
                                'amc_from'=>date('Y-m-d', strtotime($request->arrival_dt)),
                                'amc_to'=>$amcDt,
                            ));
                        }
                    }
                }
            }
        }else if ($request->trans_type=="T") {
            // return $request;
                // return $mc_name;
            for ($i=0; $i < count($request->mc_type); $i++) { 
                $mc_name=MdMachineType::where('mc_id',$request->mc_type[$i])->value('mc_type');
                TdDeviceTrans::create(array(
                    'trans_dt'=>date('Y-m-d'),
                    'trans_no'=>$trans_no,
                    'trans_type'=>$request->trans_type,
                    'bill_no'=>$request->trf_no,
                    'arrival_dt'=>date('Y-m-d'),
                    'mc_type'=>$request->mc_type[$i],
                    'mc_name'=>$mc_name,
                    'mc_qty'=>"-".$request->mc_qty[$i],
                    'serv_ctr'=>$request->srv_ctr_from,
                    'srv_to'=>$request->srv_ctr_to,
                    'trf_mode'=>$request->trf_mode,
                    'remarks'=>$request->remarks,
                    'created_by'=>auth()->user()->user_name,
                    'created_dt'=>date('Y-m-d H:i:s'),
                ));

                TdDeviceTrans::create(array(
                    'trans_dt'=>date('Y-m-d'),
                    'trans_no'=>$trans_no,
                    'trans_type'=>'I',
                    'bill_no'=>$request->trf_no,
                    'arrival_dt'=>date('Y-m-d'),
                    'mc_type'=>$request->mc_type[$i],
                    'mc_name'=>$mc_name,
                    'mc_qty'=>$request->mc_qty[$i],
                    'serv_ctr'=>$request->srv_ctr_to,
                    'remarks'=>$request->remarks,
                    // 'make'=>$request->make,
                    'created_by'=>auth()->user()->user_name,
                    'created_dt'=>date('Y-m-d H:i:s'),
                ));
            }

        }
        
        return redirect()->route('devices')->with('success','success');
    }

    public function ShowEdit($trans_dt,$trans_no)
    {
        // return $trans_dt." ".$trans_no;
        $allcustomer=TdDeviceTrans::where('trans_dt',$trans_dt)->where('trans_no',$trans_no)->get();
        $id=$allcustomer[0]['sl_no'];
        $customer=TdDeviceTrans::find($id);
        $device_amc = TdDeviceAmc::selectRaw('mc_type, GROUP_CONCAT(sl_no ORDER BY sl_no ASC) as sl_nos')
    ->where('trans_dt', $trans_dt)
    ->where('trans_no', $trans_no)
    ->groupBy('mc_type')
    ->get();
        // return $allcustomer;
        // return $customer;
        $machines=MdMachineType::get();
        $serviceCenter=MdServiceCentre::get();
        $mdmakes=MdMake::get();
        return view('devices_add_edit',['customer'=>$customer,'allcustomer'=>$allcustomer,'machines'=>$machines,
        'serviceCenter'=>$serviceCenter,'mdmakes'=>$mdmakes,'device_amc'=>$device_amc]);
    }

    public function Edit(Request $request)
    {
        // return $request;
        $id=$request->id;
        // $customer=TdDeviceTrans::find($id);
        // return $customer->trans_type;
        $mc_name=MdMachineType::where('mc_id',$request->mc_type[0])->value('mc_type');
        if ($request->trans_type_id=='I') {

            for ($i=0; $i < count($request->ids); $i++) { 
                // return $request->ids[$i];
                $id=$request->ids[$i];
                $mc_name=MdMachineType::where('mc_id',$request->mc_type[$i])->value('mc_type');
                $customer=TdDeviceTrans::find($id);
                $customer->arrival_dt=date('Y-m-d',strtotime($request->arrival_dt));
                $customer->bill_no=$request->bill_no;
                $customer->serv_ctr=$request->srv_ctr;
                $customer->mc_name=$mc_name;
                $customer->mc_type=$request->mc_type[$i];
                $customer->mc_qty=$request->mc_qty[$i];
                $customer->make=$request->make;
                $customer->remarks=$request->remarks;
                $customer->modified_by=auth()->user()->user_name;
                $customer->modified_dt=date('Y-m-d H:i:s');
                $customer->save();

            }
            
        }elseif ($request->trans_type_id=='T') {
            // return $request;
            for ($i=0; $i < count($request->ids); $i++) { 
                $id=$request->ids[$i];
                $mc_name=MdMachineType::where('mc_id',$request->mc_type[$i])->value('mc_type');
                $customer=TdDeviceTrans::find($id);
                // $customer->arrival_dt=date('Y-m-d',strtotime($request->arrival_dt));
                $customer->trf_mode=$request->trf_mode;
                $customer->bill_no=$request->trf_no;
                // $customer->serv_ctr=$request->srv_ctr_from;
                // $customer->srv_to=$request->srv_ctr_to;
                $customer->mc_name=$mc_name;
                $customer->mc_type=$request->mc_type[$i];
                $customer->mc_qty="-".$request->mc_qty[$i];
                $customer->remarks=$request->remarks;
                $customer->modified_by=auth()->user()->user_name;
                $customer->modified_dt=date('Y-m-d H:i:s');
                $customer->save();
            }
            // $customer=TdDeviceTrans::find($id);
            // return $customer;
            // // request
            // $old_trans_dt=$customer->trans_dt;
            // $old_trans_no=$customer->trans_no;
            // $old_mc_type=$customer->mc_type;
            // $old_trans_type=$customer->trans_type;
            //     $details=TdDeviceTrans::where('trans_no',$old_trans_no)
            //         ->where('mc_type',$old_mc_type)->where('trans_dt',$old_trans_dt)
            //         ->where('trans_type','I')
            //         ->get();
            //         // ->value('sl_no');
           
            // // return $details;
            // $customer->trf_mode=$request->trf_mode;
            // $customer->bill_no=$request->trf_no;
            // $customer->serv_ctr=$request->srv_ctr_from;
            // $customer->srv_to=$request->srv_ctr_to;
            // $customer->mc_name=$mc_name;
            // $customer->mc_type=$request->mc_type[0];
            // $customer->mc_qty="-".$request->mc_qty[0];
            // $customer->remarks=$request->remarks;
            // $customer->modified_by=auth()->user()->user_name;
            // $customer->modified_dt=date('Y-m-d H:i:s');
            // $customer->save();
            // if (count($details)>0) {
            //     $id1=$details[0]['sl_no'];
            //     $customer1=TdDeviceTrans::find($id1);
            //     // return $customer1;
            //     $customer1->serv_ctr=$request->srv_ctr_to;
            //     $customer1->mc_name=$mc_name;
            //     $customer1->mc_type=$request->mc_type[0];
            //     $customer1->mc_qty=$request->mc_qty[0];
            //     $customer1->make=$request->make;
            //     $customer1->remarks=$request->remarks;
            //     $customer1->modified_by=auth()->user()->user_name;
            //     $customer1->modified_dt=date('Y-m-d H:i:s');
            //     $customer1->save();
            // }



        }
        return redirect()->back()->with('success','success');
    }
}