<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barangay extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['brgyDesc', 'prov_id', 'citymun_id'];

    /**
     * @return mixed
     */
    public function municipal()
    {
        return $this->hasOne('App\Models\Municipality', "id", "citymun_id");
    }
}
