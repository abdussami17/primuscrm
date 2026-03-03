<?php

namespace App\Exports;

use App\Models\Activity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActivityReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $rows;

    public function __construct(Collection $rows)
    {
        $this->rows = $rows;
    }

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Assigned To',
            'Assigned By',
            'Source',
            'Lead Type',
            'Vehicle of Interest',
            'Trade-In Vehicle',
            'Activity Type',
            'Activity Date & Time',
            'Status Type',
            'Notes',
            'Duration',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}