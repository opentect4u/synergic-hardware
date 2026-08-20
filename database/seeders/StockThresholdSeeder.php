<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MdMachineType;

class StockThresholdSeeder extends Seeder
{
    public function run()
    {
        $machines = MdMachineType::all();
        $now = date('Y-m-d H:i:s');
        foreach ($machines as $m) {
            DB::table('td_stock_threshold')->updateOrInsert(
                ['mc_id' => $m->mc_id],
                [
                    'stk_val' => 5,
                    'created_by' => 'system',
                    'created_at' => $now,
                    'modified_by' => null,
                    'modified_at' => null,
                ]
            );
        }
    }
}
