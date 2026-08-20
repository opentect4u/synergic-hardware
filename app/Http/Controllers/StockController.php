<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\MdMachineType;
use App\Models\TdDeviceTrans;
use App\Models\TdStockThreshold;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function alert()
    {
        $items = DB::table('td_stock_threshold as s')
            ->join('md_mc_type as m','s.mc_id','=','m.mc_id')
            ->select('s.mc_id','m.mc_type','s.stk_val')
            ->orderBy('m.mc_type','ASC')
            ->get();

        return view('stock_alert',['items'=>$items]);
    }

    public function showAdd()
    {
        $machines = MdMachineType::orderBy('mc_type','ASC')->get();
        $selected = request()->mc_id ?? null;
        return view('stock_alert_add',['machines'=>$machines,'selected'=>$selected]);
    }

    public function storeAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mc_id' => 'required|integer',
            'stk_val' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // avoid duplicate - update if exists
        $existing = TdStockThreshold::where('mc_id',$request->mc_id)->first();
        if ($existing) {
            $existing->stk_val = $request->stk_val;
            $existing->modified_by = auth()->user()->user_name ?? null;
            $existing->modified_at = date('Y-m-d H:i:s');
            $existing->save();
        } else {
            TdStockThreshold::create([
                'mc_id' => $request->mc_id,
                'stk_val' => $request->stk_val,
                'created_by' => auth()->user()->user_name ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->route('stock.alert')->with('success','Threshold saved');
    }

    public function showEdit($mc_id)
    {
        $threshold = TdStockThreshold::where('mc_id',$mc_id)->first();
        $machines = MdMachineType::orderBy('mc_type','ASC')->get();
        return view('stock_alert_edit',['threshold'=>$threshold,'machines'=>$machines]);
    }

    public function update(Request $request,$mc_id)
    {
        $validator = Validator::make($request->all(), [
            'stk_val' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $threshold = TdStockThreshold::where('mc_id',$mc_id)->first();
        if (!$threshold) {
            return redirect()->route('stock.alert')->with('error','Threshold not found');
        }

        // Run a parameterized SQL update matching the requested format
        $modifiedBy = auth()->user()->user_name ?? 'Synergic';
        $modifiedAt = date('Y-m-d H:i:s');
        DB::update('UPDATE td_stock_threshold SET stk_val = ?, modified_by = ?, modified_at = ? WHERE mc_id = ?', [$request->stk_val, $modifiedBy, $modifiedAt, $mc_id]);

        return redirect()->route('stock.alert')->with('success','Threshold updated');
    }

    public function delete(Request $request)
    {
        $mc_id = $request->mc_id;
        $deleted = TdStockThreshold::where('mc_id',$mc_id)->delete();
        if ($deleted) {
            return response()->json(['msg'=>'Success']);
        }
        return response()->json(['msg'=>'NotFound'],404);
    }
}
