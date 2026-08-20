<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdStockThreshold extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "td_stock_threshold";
    // protected $primaryKey = "id";
    protected $fillable = [
        'mc_id',
        'stk_val',
        'created_by',
        'created_at',
        'modified_by',
        'modified_at',
    ];
}
