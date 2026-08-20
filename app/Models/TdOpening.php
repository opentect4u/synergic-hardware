<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdOpening extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="td_opening";
    // protected $primaryKey="sl_no";
    protected $fillable = [
        'item_type',
        'serv_ctr',
        'total_qty',
        'date',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
