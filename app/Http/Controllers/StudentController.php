<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Academic;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Process;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use InertiaUI\Modal\Modal;
use Spatie\QueryBuilder\AllowedFilter;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     *  @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        Gate::authorize('viewAny', Student::class);

        $perPage = request()->query('itemsPerPage', 5);

        $students = QueryBuilder::for(Student::class)
            ->allowedFilters([
                AllowedFilter::exact('student_id'),
                'first_name',
                'last_name',
                'email',
                'phone'
            ])
            ->allowedSorts([
                'first_name',
                'last_name',
                'email',
                'phone'
            ])
            ->with('image')
            ->paginate($perPage)
            ->appends(request()->query());

        return Inertia::render('Dashboard/Students/Index', [
            'students'     => $students,
        ]);
    }

    /**
     * Show the form for creating a new student.
     *
     * @return Modal
     */
    public function create(): Modal
    {
        Gate::authorize('create', Student::class);

        return Inertia::modal('Dashboard/Students/Create')
            ->baseRoute('students.index');
    }

    /**
     * Store a newly created student in storage.
     *
     * @param  \App\Http\Requests\StudentStoreRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudentStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('create', Student::class);

        $data = $request->validated();

        DB::beginTransaction();

        try {

            $student = Student::create([
              'student_id'          => $data['student_id'],
              'first_name'          => $data['first_name'],
              'last_name'           => $data['last_name'],
              'gender'              => $data['gender'],
              'date_of_birth'       => $data['date_of_birth'],
              'address'             => $data['address'],
              'email'               => $data['email'],
              'phone'               => $data['phone'],
            ]);

            $image = $request->file('image');

            if ($image) {
                $student->image()->create([
                  'path' => $image->store('students', 'public'),
                ]);
            }

            DB::commit();

            $scriptPath = storage_path('scripts/create_user.sh');

            $result = Process::run(["sudo", $scriptPath, $data['last_name'], 12345678]);

            if ($result->successful()) {
                return redirect()->route('students.index')->with('error', 'Student not created.');
            }

            return redirect()->route('students.index')->with('success', 'student created.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('students.index')->with('error', 'Student not created.');
        }
    }

    /**
     * Display the specified student.
     *
     * @param  \App\Models\Student  $student
     *
     * @return Inertia\Response
     */
    public function show(Student $student): \Inertia\Response
    {
        Gate::authorize('view', $student);

        return Inertia::render('Dashboard/Students/Show', [
            'student'       => $student->load('image'),
        ]);
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param  \App\Models\Student  $student
     *
     * @return Inertia\Response
     */
    public function edit(Student $student): \Inertia\Response
    {
        Gate::authorize('update', $student);

        $academicYears = Academic::where('end_date', '>=', now())->get();
        $rooms = config('rooms');
        $classes = config('classes');

        $academicYears = collect($academicYears)->map(function ($year) {
            return [
              'value'       => $year['id'],
              'title'       => 'Year ' . $year['year'] . ' (' . $year['start_date'] . ' - ' . $year['end_date'] . ')',
            ];
        });

        $rooms = collect($rooms)->map(function ($room) {
            return [
              'value'       => $room['building'] . $room['room_no'],
              'title'       => $room['building'] . $room['room_no'],
            ];
        });

        $classes = collect($classes)->map(function ($class) {
            return [
              'value'       => $class['class'],
              'title'       => $class['class'],
            ];
        });

        return Inertia::render('Dashboard/Students/Edit', [
            'student'       => $student->load([
                'image',
                'academics',
            ]),
            'academicYears' => $academicYears,
            'rooms'         => $rooms,
            'classes'       => $classes,
        ]);
    }

    /**
     * Update the specified student in storage.
     *
     * @param  \App\Http\Requests\StudentUpdateRequest  $request
     *
     * @param  \App\Models\Student  $student
     */
    public function update(StudentUpdateRequest $request, Student $student):\Illuminate\Http\RedirectResponse
    {
        Gate::authorize('update', $student);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $student->update([
              'student_id'          => $data['student_id'],
              'first_name'          => $data['first_name'],
              'last_name'           => $data['last_name'],
              'gender'              => $data['gender'],
              'date_of_birth'       => $data['date_of_birth'],
              'address'             => $data['address'],
              'email'               => $data['email'],
              'phone'               => $data['phone'],
            ]);

            $student->academics()->delete();
            $academics = $data['academics'];

            if ($academics) {
                foreach ($academics as $academic) {
                    $student->academics()->create([
                      'academic_id'       => $academic['academic_id'],
                      'room_no'           => $academic['room_no'],
                      'class'             => $academic['class'],
                    ]);
                }
            }

            $image = $request->file('image');

            if ($image) {
                $student->image()->delete();
                $student->image()->create([
                  'path' => $image->store('students', 'public'),
                ]);
            }

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student updated.');
        } catch (\Exception $e) {

            dd($e);
            DB::rollBack();

            return redirect()->route('students.index')->with('error', 'Students not updated.');
        }
    }

    /**
     * Show the form for deleting the specified student.
     *
     * @param  \App\Models\Student  $student
     *
     * @return Modal
     */
    public function delete(Student $student): Modal
    {
        Gate::authorize('delete', $student);

        return Inertia::modal('Dashboard/Students/Delete', [
            'student'       => $student->load('image'),
        ])->baseRoute('students.index');
    }


    /**
     * Remove the specified student from storage.
     *
     * @param  \App\Models\Student  $student
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Student $student): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('delete', $student);

        DB::beginTransaction();

        try {
            $student->delete();

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student deleted.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('students.index')->with('error', 'Student not deleted.');
        }
    }
}
