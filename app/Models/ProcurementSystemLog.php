<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementSystemLog extends Model
{
    use HasFactory;
    protected $table = "procurement_system_logs";
    protected $guarded = [];
}
