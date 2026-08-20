<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdDeviceTrans extends Model
{
    use HasFactory;
    
    public $timestamps=false;
    protected $table="td_device_trans";
    protected $primaryKey="sl_no";
    protected $fillable = [
        'sl_no',
        'trans_dt',
        'trans_no',
        'trans_type',
        'bill_no',
        'cust_cd',
        'make',
        'arrival_dt',
        'mc_type',
        'mc_name',
        'mc_version',
        'mc_qty',
        'serv_ctr',
        'remarks',
        'oder_by',
        'trf_mode',
        'srv_to',
        'sl_no_from',
        'sl_no_to',
        'warranty_period',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
        'approval_status',
        'approved_by',
        'approved_dt',
    ];
}
