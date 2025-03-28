<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentEnrollmentRequest;
use App\Http\Resources\ItClassGenerationAcademicResource;
use App\Http\Resources\ItClassGenerationAcademicStudentResource;
use App\Http\Resources\ItClassGenerationResource;
use App\Models\ItClass;
use App\Models\ItClassGeneration;
use App\Models\ItClassGenerationAcademic;
use App\Models\ItClassGenerationAcademicStudent;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use InertiaUI\Modal\Modal;

class ItClassGenerationAcademicStudentController extends Controller
{
    /**
     * Display a listing of the students for a specific academic generation.
     *
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     *
     * @return \Inertia\Response
     */
    public function index(ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic): \Inertia\Response
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
            'academic'                          => ItClassGenerationAcademicResource::make($academic),
            'generation'                        => ItClassGenerationResource::make($generation),
            'itClass'                           => $class,
        ]);
    }

    /**
     * Show specific student details in the academic generation.
     *
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     * @param ItClassGenerationAcademicStudent $student
     *
     * @return \Inertia\Response
     */
    public function show(ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic, ItClassGenerationAcademicStudent $student): \Inertia\Response
    {
        return Inertia::render('Dashboard/Classes/Generations/Academics/Students/Show', [
            'academic'          => ItClassGenerationAcademicResource::make($academic),
            'generation'        => ItClassGenerationResource::make($generation),
            'itClass'           => $class,
            'student'           => ItClassGenerationAcademicStudentResource::make($student),
        ]);
    }

    /**
     * Show the form for creating a new student in the academic generation.
     *
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     *
     * @return Modal
     */
    public function create(ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic)
    {
        $students = Student::whereDoesntHave('itClassGenerationAcademicStudents.itClassGenerationAcademic.academic', function ($query) use ($academic) {
            $query->where('year', $academic->academic->year);
        })->get();

        $students = collect($students)->map(function ($student) {
            return [
                'id'                => $student->id,
                'student_id'        => $student->student_id,
                'first_name'        => $student->first_name,
                'last_name'         => $student->last_name,
            ];
        })->toArray();

        return Inertia::modal('Dashboard/Classes/Generations/Academics/Students/Create', [
            'academic'          => ItClassGenerationAcademicResource::make($academic),
            'generation'        => ItClassGenerationResource::make($generation),
            'itClass'           => $class,
            'students'          => $students,
        ])->baseRoute('classes.generations.academics.students.index', [
                'class'             => $class,
                'generation'        => $generation,
                'academic'          => $academic,
            ]);
    }

    /**
     * Store a newly created student in the academic generation.
     *
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudentEnrollmentRequest $request, ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $studentIds = $data['student_ids'];

            foreach ($studentIds as $studentId) {
                ItClassGenerationAcademicStudent::create([
                    'it_class_generation_academic_id' => $academic->id,
                    'student_id'                      => $studentId,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('classes.generations.academics.students.index', [
                    'class'             => $class,
                    'generation'        => $generation,
                    'academic'          => $academic,
                ])
                ->with('success', 'Students enrolled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Failed to enroll students. Please try again.');
        }
    }

    /**
     * Show the form for deleting a student from the academic generation.
     *
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     * @param ItClassGenerationAcademicStudent $student
     *
     * @return Modal
     */
    public function delete(ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic, ItClassGenerationAcademicStudent $student): Modal
    {
        return Inertia::modal('Dashboard/Classes/Generations/Academics/Students/Delete', [
            'academic'          => ItClassGenerationAcademicResource::make($academic),
            'generation'        => ItClassGenerationResource::make($generation),
            'itClass'           => $class,
            'student'           => ItClassGenerationAcademicStudentResource::make($student),
        ])->baseRoute('classes.generations.academics.students.index', [
            'class'             => $class,
            'generation'        => $generation,
            'academic'          => $academic,
        ]);
    }

    /**
     * Remove the specified student from the academic generation.
     *
     * @param ItClass $class
     * @param ItClassGeneration $generation
     * @param ItClassGenerationAcademic $academic
     * @param ItClassGenerationAcademicStudent $student
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ItClass $class, ItClassGeneration $generation, ItClassGenerationAcademic $academic, ItClassGenerationAcademicStudent $student): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();

        try {
            $student->delete();

            DB::commit();

            return redirect()
                ->route('classes.generations.academics.students.index', [
                    'class'             => $class,
                    'generation'        => $generation,
                    'academic'          => $academic,
                ])
                ->with('success', 'Student removed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Failed to remove student. Please try again.');
        }
    }
}
