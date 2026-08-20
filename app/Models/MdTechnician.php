<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdTechnician extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="md_tech";
    protected $primaryKey="emp_code";
    protected $fillable = [
        'emp_code',
        'tech_name',
        'tech_ph',
        'created_by',
        'created_dt',
        'modified_by',
        'modified_dt',
    ];
}
