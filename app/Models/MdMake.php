<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdMake extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="md_make";
    protected $primaryKey="sl_no";
    protected $fillable = [
        'sl_no',
        'name',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
