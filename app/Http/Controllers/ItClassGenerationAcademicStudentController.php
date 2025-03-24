<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItClassGenerationAcademicStudentResource;
use App\Models\Academic;
use App\Models\Generation;
use App\Models\ItClass;
use App\Models\ItClassGenerationAcademicStudent;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ItClassGenerationAcademicStudentController extends Controller
{
    //

    /**
     * Display a listing of the students for a specific academic generation.
     *
     * @return \Inertia\Response
     *
     */
    public function index(ItClass $class, Generation $generation, Academic $academic): \Inertia\Response
    {

        $perPage = request()->query('itemsPerPage', 5);

        $itClassGenerationAcademicStudents = QueryBuilder::for(ItClassGenerationAcademicStudent::class)
            ->where('it_class_generation_academic_id', $academic->id)
            ->with([
                'student',
                'itClassGenerationAcademic',
            ])
            ->paginate($perPage)
            ->appends(request()->query());

        $itClassGenerationAcademicStudents = ItClassGenerationAcademicStudentResource::collection($itClassGenerationAcademicStudents);

        return Inertia::render('Dashboard/Classes/Generations/Academics/Students/Index', [
            'itClassGenerationAcademicStudents' => $itClassGenerationAcademicStudents,
            'academic'  => $academic,
            'generation' => $generation,
            'itClass' => $class,
        ]);
    }
}
