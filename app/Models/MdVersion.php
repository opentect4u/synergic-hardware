<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdVersion extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="md_version";
    protected $primaryKey="sl_no";
    protected $fillable = [
        'sl_no',
        'mc_type',
        'version_name',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
