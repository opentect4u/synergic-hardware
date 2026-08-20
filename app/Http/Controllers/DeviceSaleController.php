<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\TdDeviceTrans;
use App\Models\MdMachineType;
use App\Models\MdServiceCentre;
use App\Models\MdCustomers;
use App\Models\MdVersion;
use App\Models\TdDeviceAmc;

class DeviceSaleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Show(Request $request)
    {
        $from_dt=$request->from_dt;
        $to_dt=$request->to_dt;
        if ($from_dt!='' && $to_dt!='') {
            $device_sale=TdDeviceTrans::where('approval_status','U')
                ->where('trans_type','S')
                ->whereDate('trans_dt','>=',date('Y-m-d',strtotime($from_dt)))
                ->whereDate('trans_dt','<=',date('Y-m-d',strtotime($to_dt)))
                ->groupBy('td_device_trans.trans_no','td_device_trans.trans_dt')
                // ->orWhere('bill_no',1)
                ->orderBy('created_dt','desc')->get();
        }else{
            $date=date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $device_sale=TdDeviceTrans::where('approval_status','U')
                ->where('trans_type','S')
                ->where('trans_dt','>=',$date)
                ->groupBy('td_device_trans.trans_no','td_device_trans.trans_dt')
                // ->orWhere('bill_no',1)
                ->orderBy('created_dt','desc')->get();
        }
        // return  $device_sale;
        // $customers=DB::table('md_customers')->paginate(15);
        return view('device_sale',['device_sale'=>$device_sale,'from_dt'=>$from_dt,'to_dt'=>$to_dt]);
    }

    public function ShowAdd ()
    {
        $mdcustomers=MdCustomers::get();
        $machines=MdMachineType::get();
        $serviceCenter=MdServiceCentre::get();
        $versions=MdVersion::get();
        return view('device_sale_add_edit',['machines'=>$machines,
        'serviceCenter'=>$serviceCenter,'mdcustomers'=>$mdcustomers,'versions'=>$versions]);
    }

    public function Add(Request $request)
    {
        // return $request;
        $transDt=date('Y-m-d');
        $trans_details= TdDeviceTrans::whereDate('trans_dt',date('Y-m-d'))->orderBy('trans_no','DESC')->get();
        if (count($trans_details)>0) {
            $trans_no=$trans_details[0]['trans_no'] + 1;
        }else{
            $trans_no=1;
        }
        for ($i=0; $i < count($request->mc_type); $i++) { 
            $mc_name=MdMachineType::where('mc_id',$request->mc_type[$i])->value('mc_type');
            TdDeviceTrans::create(array(
                'trans_dt'=>$transDt,
                'trans_no'=>$trans_no,
                'trans_type'=>'S',
                'bill_no'=>$request->bill_no,
                'cust_cd'=>$request->cust_cd,
                'make'=>'Power Craft',
                'arrival_dt'=> date('Y-m-d', strtotime($request->sale_dt)),
                'mc_type'=>$request->mc_type[$i],
                'mc_name'=>$mc_name,
                'mc_version'=>$request->mc_ver[$i],
                'mc_qty'=>"-".$request->mc_qty[$i],
                'serv_ctr'=>$request->srv_ctr,
                'remarks'=>$request->remarks,
                'sl_no_from'=>$request->sl_frm[$i],
                'sl_no_to'=>$request->sl_to[$i],
                'warranty_period'=>$request->warr_prd[$i],
                'created_by'=>auth()->user()->user_name,
                'created_dt'=>date('Y-m-d H:i:s'),
            ));

            $slFrm=$request->sl_frm[$i];
            $slTo=$request->sl_to[$i];
            $prd=$request->warr_prd[$i];
            $amcDt = date('Y-m-d', strtotime("+$prd months", strtotime($request->sale_dt)));
            if ($slFrm > 0  && $slTo > 0) {
                // return "if block";
                while($slFrm <= $slTo ){
                    // echo $slFrm."  _ ";
                    TdDeviceAmc::create(array(
                        'trans_dt'=>$transDt,
                        'trans_no'=>$trans_no,
                        'trans_type'=>'S',
                        'mc_type'=>$request->mc_type[$i],
                        'sl_no'=>$slFrm,
                        'amc_from'=>date('Y-m-d', strtotime($request->sale_dt)),
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
                            'trans_dt'=>$transDt,
                            'trans_no'=>$trans_no,
                            'trans_type'=>'S',
                            'mc_type'=>$request->mc_type[$i],
                            'sl_no'=>$array_c_sl[$j],
                            'amc_from'=>date('Y-m-d', strtotime($request->sale_dt)),
                            'amc_to'=>$amcDt,
                        ));
                    }
                }
            }
            
        }

        // return "hello";

        return redirect()->route('deviceSale')->with('success','success');
    }

    public function ShowEdit($trans_dt,$trans_no)
    {
        // return $trans_dt." ".$trans_no;
        $mdcustomers=MdCustomers::get();
        $machines=MdMachineType::get();
        $serviceCenter=MdServiceCentre::get();
        $versions=MdVersion::get();
        $allcustomer=TdDeviceTrans::where('trans_dt',$trans_dt)->where('trans_no',$trans_no)->get();
        $id=$allcustomer[0]['sl_no'];
        $customer=TdDeviceTrans::find($id);
        // return $allcustomer;
        // return $customer;

        // $amc_details=TdDeviceAmc::where('trans_dt',$customer->trans_dt)
        //     ->where('trans_no',$customer->trans_no)
        //     ->where('mc_type',$customer->mc_type)
        //     ->get();
        // $sql1     = "select * from td_device_amc where trans_dt = '$transDt' and trans_no = $transNo";
        // $result1  =  mysqli_query($db,$sql1);
        // return $amc_details;

        return view('device_sale_add_edit',['customer'=>$customer,'machines'=>$machines,
        'serviceCenter'=>$serviceCenter,'mdcustomers'=>$mdcustomers,'versions'=>$versions,'allcustomer'=>$allcustomer]);
    }

    public function Edit(Request $request)
    {
        return $request;
        $id=$request->id;
        $customer=TdDeviceTrans::find($id);
        return $customer;
        $customer->cust_name=$request->name;
        $customer->arrival_dt= date('Y-m-d', strtotime($request->sale_dt));
        $customer->bill_no=$request->bill_no;
        $customer->srv_ctr=$request->srv_ctr;
        $customer->cust_cd=$request->cust_cd;
        $customer->remarks=$request->remarks;

        if ($customer->mc_type!=$request->mc_type[0]) {
            $mc_name=MdMachineType::where('mc_id',$request->mc_type[0])->value('mc_type');
            
            $customer->mc_name=$mc_name;
            $customer->mc_type=$request->mc_type[0];

        }

        $customer->cust_name=$request->name;
        $customer->cust_ph_no=$request->phone_no;
        $customer->cust_email=$request->email;
        $customer->cust_addr=$request->address;
        $customer->modified_by=auth()->user()->user_name;
        $customer->modified_dt=date('Y-m-d H:i:s');
        $customer->save();
        return redirect()->back()->with('success','success');
    }

    public function Delete (Request $request)
    {
        $trans_dt=$request->trans_dt;
        $trans_no=$request->trans_no;
        $customer=TdDeviceTrans::where('trans_dt',$trans_dt)->where('trans_no',$trans_no)->get();
        // $customer=TdDeviceTrans::find($id);
        foreach ($customer as $key => $value2) {
            $amc_details=TdDeviceAmc::where('trans_dt',$value2->trans_dt)
                ->where('trans_no',$value2->trans_no)
                ->where('mc_type',$value2->mc_type)
                ->get();
        
            foreach ($amc_details as $key => $value) {
                $id1=$value->id;
                TdDeviceAmc::find($id1)->delete();
            }
        }
        TdDeviceTrans::where('trans_dt',$trans_dt)->where('trans_no',$trans_no)->delete();
        $msg="Success";
        $arrNewResult = array();
        // $arrNewResult['id'] = $id;
        $arrNewResult['msg'] = $msg;
        $status_json = json_encode($arrNewResult);
        echo $status_json;
    }
}
