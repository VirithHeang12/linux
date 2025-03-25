<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Http\Resources\ItClassGenerationAcademicResource;
use App\Http\Resources\ItClassGenerationResource;
use App\Models\ItClass;
use App\Models\ItClassGeneration;
use App\Models\ItClassGenerationAcademic;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use InertiaUI\Modal\Modal;

class ExportController extends Controller
{
    /**
     * Show the form for exporting student data.
     *
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     *
     * @return Modal
     */
    public function showExportForm(ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic): Modal
    {
        return Inertia::modal('Dashboard/Classes/Generations/Academics/Students/Export', [
            'itClass'       => $class,
            'academic'      => ItClassGenerationAcademicResource::make($academic),
            'generation'    => ItClassGenerationResource::make($generation),
        ])->baseRoute('classes.generations.academics.students.index', [
            'class'                 => $class,
            'generation'            => $generation,
            'academic'              => $academic,
        ]);
    }

    /**
     * Export student to Excel, CSV, or PDF.
     *
     * @param Request $request
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic): \Symfony\Component\HttpFoundation\BinaryFileResponse | \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'format' => 'required|string|in:excel,csv',
        ]);

        $format = $request->input('format');

        $generationName = $generation->generation?->name;
        $academicName = $academic?->academic?->year;

        try {
            $export = new StudentExport($class, $generationName, $academicName, $academic->id);

            switch ($format) {
                case 'excel':
                    return Excel::download($export, 'students.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                case 'csv':
                    return Excel::download($export, 'students.csv', \Maatwebsite\Excel\Excel::CSV);
                default:
                    return Excel::download($export, 'students.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export students. Please try again.');
        }
    }
}
