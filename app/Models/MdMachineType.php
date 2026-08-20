<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdMachineType extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="md_mc_type";
    protected $primaryKey="mc_id";
    protected $fillable = [
        'mc_id',
        'mc_type',
        'dev_type',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
