<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipality extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['lgus', 'prov_id'];

    /**
     * @return mixed
     */
    public function barangay()
    {
        return $this->hasMany('App\Models\Barangay', "citymun_id", "id");
    }
}
