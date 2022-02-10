<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementDetails extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = [
        'procurement_record_id',
        'category_id',
        'document_id',
        'field_id',
        'data',
        'remarks',
    ];
    protected $with = ['field', 'document'];

    /**
     * @return mixed
     */
    public function field()
    {
        return $this->hasOne('App\Models\DocumentField', "id", "field_id");
    }

    /**
     * @return mixed
     */
    public function document()
    {
        return $this->hasOne('App\Models\Documents', "id", "document_id");
    }
}
