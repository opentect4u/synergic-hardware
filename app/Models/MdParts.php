<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdParts extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="md_parts";
    protected $primaryKey="sl_no";
    protected $fillable = [
        'sl_no',
        'parts_desc',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
