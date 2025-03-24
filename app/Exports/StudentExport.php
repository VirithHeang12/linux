<?php

namespace App\Exports;

use App\Models\ItClassGenerationAcademicStudent;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentExport implements FromView, WithStyles, ShouldAutoSize, WithTitle
{
    private $itClass;
    private $generation;
    private $academic;
    private $data;

    /**
     * StudentExport constructor.
     *
     * @param $itClass
     * @param $generation
     * @param $academic
     * @param $format
     */
    public function __construct($itClass, $generation, $academic, $format)
    {
        $this->itClass = $itClass;
        $this->generation = $generation;
        $this->academic = $academic;

        $students = ItClassGenerationAcademicStudent::with([
            'student',
        ])
            ->where('it_class_generation_academic_id', $this->academic->id)
            ->orderBy('student_id')
            ->get()
            ->toArray();

        $students = collect($students)->map(function ($student) {
            return [
                'student_id'        => $student['student']['id'],
                'first_name'        => $student['student']['first_name'],
                'last_name'         => $student['student']['last_name'],
                'date_of_birth'     => $student['student']['date_of_birth'],
            ];
        });

        $this->data = [
            'itClass'               => $this->itClass,
            'generation'            => $this->generation,
            'academic'              => $this->academic,
            'students'              => $students,
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('student_export', $this->data);
    }

    /**
     * Set the sheet title
     *
     * @return string
     */
    public function title(): string
    {
        return 'និស្សិត';
    }


    /**
     * Set the styles for the sheet
     *
     * @param Worksheet $sheet
     *
     * @return void
     */
    public function styles(Worksheet $sheet): void
    {
        $fontPrimary        = 'Khmer OS Siemreap';
        $fontSecondary      = 'Khmer OS Muol';

        // Get the last column index as an integer
        $lastColumnIndex    = Coordinate::columnIndexFromString($sheet->getHighestColumn());
        // Convert the last column index back to a string
        $lastColumn                 = Coordinate::stringFromColumnIndex($lastColumnIndex);
        $lastColumnFooter           = Coordinate::stringFromColumnIndex($lastColumnIndex - 1);

        /// last row
        $lastRow            = count($this->data['students']) + 7;

        // Merge cells for row date footer
        $sheet->mergeCells('A' . ($lastRow + 2) . ':' . $lastColumnFooter . ($lastRow + 2));
        // Merge cells for row director footer
        $sheet->mergeCells('A' . ($lastRow + 3) . ':' . $lastColumnFooter . ($lastRow + 3));


        // Define the array to store cell styles
        $styles = [

            // Header Section Style
            'A1:' . $lastColumn . '2' => [
                'font' => [
                    'name' => $fontSecondary,
                    'bold' => true,
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_CENTER,
                    'vertical'      => Alignment::VERTICAL_CENTER
                ],
            ],

            // Header Section Style
            'A3:' . $lastColumn . '3' => [
                'font' => [
                    'name' => $fontSecondary,
                    'bold' => true,
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_LEFT,
                    'indent'        => 8,
                ],
            ],

            'A4:' . $lastColumn . '4' => [
                'font' => [
                    'name' => $fontSecondary,
                    'bold' => true,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_LEFT,
                    'indent'        => 9,
                ],
            ],

            /// Sub-Header Section Style
            'A5:' . $lastColumn . '5' => [
                'font' => [
                    'name' => $fontSecondary,
                    'bold' => true,
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_CENTER,
                    'vertical'      => Alignment::VERTICAL_CENTER
                ],
            ],

            /// Table Header Section Style
            'A7:' . $lastColumn . '7' => [
                'font' => [
                    'name' => $fontPrimary,
                    'bold' => true,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_CENTER,
                    'vertical'      => Alignment::VERTICAL_CENTER
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],

            /// Table Data Section Style
            'A8:' . $lastColumn . $lastRow => [
                'font' => [
                    'name' => $fontPrimary,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_CENTER,
                    'vertical'      => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],

            /// Footer Section Style
            'A' . ($lastRow + 2) . ':' . $lastColumnFooter . ($lastRow + 2) => [
                'font' => [
                    'name' => $fontPrimary,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_RIGHT,
                    'vertical'      => Alignment::VERTICAL_CENTER
                ],
            ],
            'A' . ($lastRow + 3) . ':' . $lastColumnFooter . ($lastRow + 3) => [
                'font' => [
                    'name' => $fontPrimary,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal'    => Alignment::HORIZONTAL_RIGHT,
                    'vertical'      => Alignment::VERTICAL_CENTER,
                    'indent'        => 3,
                ],
            ],
        ];

        /// Apply styles to the worksheet
        foreach ($styles as $range => $style) {
            $sheet->getStyle($range)->applyFromArray($style);
        }
    }

}
