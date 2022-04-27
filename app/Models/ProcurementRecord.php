<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementRecord extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'bid_opening_date',
        'ib_number',
        'project_name',
        'contractor',
        'category_id',
        'office_id',
        'lgu_id',
        'barangay_id',
        'amount',
        'status',
        'remarks',
        'created_user_by_id',
        'updated_user_by_id',
    ];


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
    public function details()
    {
        return $this->hasMany('App\Models\ProcurementDetails', "procurement_record_id", "id");
    }

    /**
     * @return mixed
     */
    public function lgu()
    {
        return $this->hasOne('App\Models\Municipality', "id", "lgu_id");
    }

    /**
     * @return mixed
     */
    public function barangay()
    {
        return $this->hasOne('App\Models\Barangay', "id", "barangay_id");
    }

    /**
     * @return mixed
     */
    public function office()
    {
        return $this->hasOne('App\Models\Office', "id", "office_id");
    }


    public function scopeFilter($query, $request)
    {

        $user = auth()->user();
        $query->when($request["search"] ?? null, function ($query) use ($request) {
            $query->where('ib_number', 'like', "%$request->search%")
                ->orWhere('project_name', 'like', "%$request->search%")
                ->orWhere('contractor', 'like', "%$request->search%");
        })->when($request['category'] ?? null, function ($query) use ($request) {
            $query->where('category_id', $request->category);
        })->when($request['category'] == null, function ($query) use ($user) {
            $tags = json_decode($user->tag);
            $query->whereIN('category_id', $tags);
        })->when($request['lgu_id'] ?? null, function ($query) use ($request) {
            $query->where('lgu_id', $request->lgu_id);
        })->when($request['barangay_id'] ?? null, function ($query) use ($request) {
            $query->where('barangay_id', $request->barangay_id);
        })->when($request['office_id'] ?? null, function ($query) use ($request) {
            $query->where('office_id', $request->office_id);
        })->when($request['month_from'] ?? null, function ($query) use ($request) {
            if (!$request->month_to) {
                $query->where('created_at', 'like', $request->month_from . "%");
            } else {
                $query->whereDate('created_at', '>=', date('Y-m-01', strtotime($request->month_from)))
                    ->whereDate('created_at', '<=', date('Y-m-t', strtotime($request->month_to)));
            }
        })->when($request['currentSort'] ?? null, function ($query) use ($request) {
            $query->orderBy($request['currentSort'], $request['currentSortDir']);
        });
        
    }
}
