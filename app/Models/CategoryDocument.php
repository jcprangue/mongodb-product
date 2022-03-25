<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDocument extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['category_id', 'document_id', 'precedence'];
    protected $with = ['document'];
    /**
     * @return mixed
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', "id", "category_id");
    }

    /**
     * @return mixed
     */
    public function document()
    {
        return $this->hasOne('App\Models\Documents', "id", "document_id");
    }

    /**
     * @return mixed
     */
    public function fields()
    {
        return $this->hasMany('App\Models\DocumentField', "document_id", "document_id");
    }
}
