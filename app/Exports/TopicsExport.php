<?php

namespace App\Exports;

use App\Models\Topics;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopicsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Topics::all();
    }

    public function headings(): array
    {
        return [
            'Topic Id',
            'Name',
            'Icon Path',
            'Category',
            'Created At',
            'Flg Show',
            'Is custom Topic',
            'Sort',
            'Deleted At',
        ];
    }
}
