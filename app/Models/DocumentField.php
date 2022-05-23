<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentField extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['field_name', 'field_type', 'document_id', 'precedence'];

    /**
     * @return mixed
     */
    public function document()
    {
        return $this->belongsTo('App\Models\Documents');
    }
}
