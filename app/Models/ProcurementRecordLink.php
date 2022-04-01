<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementRecordLink extends Model
{
    use HasFactory;
    protected $table = "procurement_records_links";
    protected $guarded = [];
}
