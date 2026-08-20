<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdServiceCentre extends Model
{
    use HasFactory;
    
    public $timestamps=false;
    protected $table="md_service_centre";
    protected $primaryKey="sl_no";
    protected $fillable = [
        'sl_no',
        'center_name',
        'address',
        'cnct_no',
        'email',
        'in_charge',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
