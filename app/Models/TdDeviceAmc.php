<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdDeviceAmc extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="td_device_amc";
    // protected $primaryKey="sl_no";
    protected $fillable = [
        'trans_dt',
        'trans_no',
        'trans_type',
        'mc_type',
        'sl_no',
        'amc_from',
        'amc_to',
    ];
}
