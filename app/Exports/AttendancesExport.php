<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $attendances;

    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    /**
     * Return collection data
     */
    public function collection()
    {
        return $this->attendances;
    }

    /**
     * Heading kolom Excel
     */
    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL',
            'SHIFT',
            'JAM ABSEN',
            'NIK',
            'NAMA KARYAWAN',
            'JABATAN',
            'DEPARTEMEN',
            'AREA IMIP',
            'STATUS',
            'CATATAN',
            'PENGAWAS',
            'LOKASI GPS',
        ];
    }

    /**
     * Mapping data per row
     */
    public function map($attendance): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $attendance->session->session_date->format('d/m/Y'),
            $attendance->session->shift->name . ' (' . 
                \Carbon\Carbon::parse($attendance->session->shift->start_time)->format('H:i') . ' - ' .
                \Carbon\Carbon::parse($attendance->session->shift->end_time)->format('H:i') . ')',
            \Carbon\Carbon::parse($attendance->session->session_time)->format('H:i:s'),
            $attendance->employee->employee_number,
            $attendance->employee->name,
            $attendance->employee->position,
            $attendance->employee->department,
            $attendance->session->area ? $attendance->session->area->name : 'Non-Area',
            $attendance->status,
            $attendance->notes ?? '-',
            $attendance->session->supervisor->name,
            ($attendance->session->latitude && $attendance->session->longitude) 
                ? $attendance->session->latitude . ', ' . $attendance->session->longitude
                : '-',
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style header (baris 1)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563eb'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}