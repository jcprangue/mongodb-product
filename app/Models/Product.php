<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products_record';
    protected $guarded = [];

    public function scopeFilter($query, $request)
    {
        $query->when($request["search"] ?? null, function ($query) use ($request) {
            $query->where('title', 'like', "%$request->search%")
                ->orWhere('sku', 'like', "%$request->search%");
        });
        
    }
}
