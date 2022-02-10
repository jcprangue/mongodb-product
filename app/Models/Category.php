<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name', 'abbr', 'parent_id'];
    protected $with = [
        'documents'
    ];

    /**
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    /**
     * @return mixed
     */
    public function documents()
    {
        return $this->hasMany('App\Models\CategoryDocument', "category_id", "id");
    }

    /**
     * @return mixed
     */
    public function procurementRecords()
    {
        return $this->hasMany('App\Models\ProcurementRecord', "category_id", "id");
    }
}
