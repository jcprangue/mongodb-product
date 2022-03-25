<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documents extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name', 'abbr'];
    /**
     * @return mixed
     */
    public function documentFields()
    {
        return $this->hasMany('App\Models\DocumentField', "id", "document_id");
    }
}
