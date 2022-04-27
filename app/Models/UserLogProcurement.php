<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserLogProcurement extends Model
{
    use HasFactory;
    protected $table = "user_logs_procurement";
    protected $guarded = [];

    public function users()
    {
        return $this->hasOne('App\Models\User', "id", "user_id");

    }

    public function procurement()
   {
      return $this->hasOne('App\Models\ProcurementRecord', "id", "procurement_record_id");
   }

   public function getCreatedAtAttribute($value){
     return date('F d, Y h:i:s a',strtotime($value));

   }
}
