<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        $students = StudentResource::collection($students);

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

            $user = $student->user()->create([
              'name'          => $data['first_name'] . ' ' . $data['last_name'],
              'email'         => $data['email'],
              'password'      => Hash::make(12345678),
            ]);

            $user->assignRole(RoleEnum::STUDENT);

            $image = $request->file('image');

            if ($image) {
                $student->image()->create([
                  'path' => $image->store('students'),
                ]);
            }

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student created successfully.');
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

        $student->load([
            'image',
            'itClassGenerationAcademicStudents'
        ]);

        $student = StudentResource::make($student);

        return Inertia::render('Dashboard/Students/Show', [
            'student'           => $student,
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

        $student->load([
            'image',
            'itClassGenerationAcademicStudents',
        ]);
        $student = StudentResource::make($student);

        return Inertia::render('Dashboard/Students/Edit', [
            'student'       => $student,
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
              'phone'               => $data['phone'],
            ]);

            $student->user()->update([
                'password'      => Hash::make($data['password']),
            ]);

            $image = $request->file('image');
            if ($image) {
                if ($student->image) {
                    Storage::delete($student->image->path);
                    $student->image->delete();
                }
                $student->image()->create([
                    'path' => $image->store('students'),
                ]);
            }
            DB::commit();

            return redirect()->route('students.edit', [
                'student'       => $student,
            ])->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
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
            if ($student->image) {
                Storage::delete($student->image->path);
                $student->image()->delete();
            }
            $student->user()->delete();
            $student->delete();

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('students.index')->with('error', 'Student not deleted.');
        }
    }



}
