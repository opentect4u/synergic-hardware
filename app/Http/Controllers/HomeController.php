<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MdCustomers;
use App\Models\MdMachineType;
use App\Models\MdServiceCentre;
use App\Models\MdTechnician;
use App\Models\TdDeviceAmc;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function Show(Request $request)
    {
        $today = date('Y-m-d');
        $currentMonth = (int) date('m');
        $currentYear = (int) date('Y');

        $availableItems = MdMachineType::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('td_device_trans')
                ->whereColumn('td_device_trans.mc_type', 'md_mc_type.mc_id')
                ->whereIn('td_device_trans.trans_type', ['I', 'S'])
                ->where('td_device_trans.approval_status', 'U');
        })->orderBy('mc_type')->get();

        $selectedItem = $request->get('item');
        if (!$availableItems->contains('mc_id', $selectedItem)) {
            $selectedItem = optional($availableItems->first())->mc_id;
        }

        $financialYearStart = $currentMonth >= 4 ? $currentYear : $currentYear - 1;
        $previousFinancialYearStart = $financialYearStart - 1;
        $comparisonPeriods = [
            'This Month' => [date('Y-m-01'), $today],
            'Previous Month' => [date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month'))],
            'Current Financial Year' => [$financialYearStart . '-04-01', $today],
            'Previous Financial Year' => [$previousFinancialYearStart . '-04-01', $financialYearStart . '-03-31'],
        ];

        $comparisonChart = collect($comparisonPeriods)->map(function ($dates, $periodLabel) use ($selectedItem) {
            $totals = DB::table('td_device_trans')
                ->where('td_device_trans.mc_type', $selectedItem)
                ->whereIn('td_device_trans.trans_type', ['I', 'S'])
                ->where('td_device_trans.approval_status', 'U')
                ->whereDate('td_device_trans.trans_dt', '>=', $dates[0])
                ->whereDate('td_device_trans.trans_dt', '<=', $dates[1])
                ->select('trans_type', DB::raw('SUM(mc_qty) as total_quantity'))
                ->groupBy('trans_type')
                ->pluck('total_quantity', 'trans_type');

            return [
                'period' => $periodLabel,
                'purchase_quantity' => (float) $totals->get('I', 0),
                'sale_quantity' => abs((float) $totals->get('S', 0)),
            ];
        })->values();

        $financialStartDate = $currentMonth >= 4
            ? $currentYear . '-04-01'
            : ($currentYear - 1) . '-04-01';
        $openingStock = DB::table('td_opening')
            ->where('mc_type', $selectedItem)
            ->whereDate('date', $financialStartDate)
            ->sum('total_qty');
        $transactionStock = DB::table('td_device_trans')
            ->where('mc_type', $selectedItem)
            ->where('approval_status', 'U')
            ->whereDate('arrival_dt', '>=', $financialStartDate)
            ->whereDate('arrival_dt', '<=', $today)
            ->sum('mc_qty');
        $currentStock = $openingStock + $transactionStock;

        $thresholds = DB::table('td_stock_threshold')->pluck('stk_val', 'mc_id');
        $openingStocks = DB::table('td_opening')
            ->whereDate('date', $financialStartDate)
            ->select('mc_type', DB::raw('SUM(total_qty) as total_quantity'))
            ->groupBy('mc_type')
            ->pluck('total_quantity', 'mc_type');
        $transactionStocks = DB::table('td_device_trans')
            ->where('approval_status', 'U')
            ->whereDate('arrival_dt', '>=', $financialStartDate)
            ->whereDate('arrival_dt', '<=', $today)
            ->select('mc_type', DB::raw('SUM(mc_qty) as total_quantity'))
            ->groupBy('mc_type')
            ->pluck('total_quantity', 'mc_type');
        $lowStockItems = MdMachineType::orderBy('mc_type')->get()
            ->filter(function ($item) use ($thresholds, $openingStocks, $transactionStocks) {
                if (!$thresholds->has($item->mc_id)) {
                    return false;
                }

                $currentQuantity = (float) $openingStocks->get($item->mc_id, 0)
                    + (float) $transactionStocks->get($item->mc_id, 0);

                return $currentQuantity < (float) $thresholds->get($item->mc_id);
            })
            ->map(function ($item) use ($thresholds, $openingStocks, $transactionStocks) {
                $item->current_quantity = (float) $openingStocks->get($item->mc_id, 0)
                    + (float) $transactionStocks->get($item->mc_id, 0);
                $item->threshold_quantity = (float) $thresholds->get($item->mc_id);
                return $item;
            })
            ->values();

        $counts = [
            'customers' => MdCustomers::count(),
            'devices' => MdMachineType::count(),
            'service_centres' => MdServiceCentre::count(),
            'technicians' => MdTechnician::count(),
            'purchase_amc' => TdDeviceAmc::where('trans_type', 'P')
                ->whereBetween('amc_to', [date('Y-m-01'), date('Y-m-t')])
                ->count(),
            'sale_amc' => TdDeviceAmc::where('trans_type', 'S')
                ->whereBetween('amc_to', [date('Y-m-01'), date('Y-m-t')])
                ->count(),
        ];

        return view('home', [
            'counts' => $counts,
            'availableItems' => $availableItems,
            'selectedItem' => $selectedItem,
            'comparisonChart' => $comparisonChart,
            'currentStock' => $currentStock,
            'lowStockItems' => $lowStockItems,
        ]);
    }
}
