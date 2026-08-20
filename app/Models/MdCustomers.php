<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdCustomers extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table="md_customers";
    protected $primaryKey="cust_cd";
    protected $fillable = [
        'cust_cd',
        'cust_name',
        'cust_addr',
        'cust_ph_no',
        'cust_email',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
