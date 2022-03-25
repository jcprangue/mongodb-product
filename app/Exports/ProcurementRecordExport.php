<?php

namespace App\Exports;

use App\Models\ProcurementRecord;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProcurementRecordExport implements FromView, ShouldAutoSize
{
    public $category;
    public function __construct($category)
    {
        $this->category = $category;
    }
    // use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.procurement-record', [
            "procurements" => ProcurementRecord::where('category_id', $this->category->id)->get(),
            "category" => $this->category
        ]);
    }
}
