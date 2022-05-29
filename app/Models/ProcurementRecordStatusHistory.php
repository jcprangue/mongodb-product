<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementRecordStatusHistory extends Model
{
    use HasFactory;
    protected $table = "procurement_record_status_history";
    protected $guarded = [];

    protected $with = [
        'users'
    ];
    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsTo('App\Models\User', "user_id", "id");
    }
}
