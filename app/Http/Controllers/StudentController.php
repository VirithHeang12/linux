<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Process;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use InertiaUI\Modal\Modal;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     *  @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $perPage = request()->query('itemsPerPage', 5);

        $students = QueryBuilder::for(Student::class)
            ->allowedFilters(['first_name', 'last_name', 'email', 'phone'])
            ->allowedSorts(['first_name', 'last_name', 'email', 'phone'])
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

        return Inertia::modal('Dashboard/Students/Create')->baseRoute('students.index');
    }

    /**
     * Store a newly created student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudentStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();

        // DB::beginTransaction();

        try {

            // $student = Student::create([
            //   'student_id'          => $data['student_id'],
            //   'first_name'          => $data['first_name'],
            //   'last_name'           => $data['last_name'],
            //   'gender'              => $data['gender'],
            //   'date_of_birth'       => $data['date_of_birth'],
            //   'address'             => $data['address'],
            //   'email'               => $data['email'],
            //   'phone'               => $data['phone'],
            // ]);

            // $image = $request->file('image');

            // if ($image) {
            //     $student->image()->create([
            //       'path' => $image->store('students', 'public'),
            //     ]);
            // }

            // $student->user()->create([
            //   'name'                => $data['first_name'] . ' ' . $data['last_name'],
            //   'email'               => $data['email'],
            //   'password'            => bcrypt('password'),
            // ]);

            // DB::commit();

            $scriptPath = storage_path('scripts/create_user.sh');

            $result = Process::run(["sudo", $scriptPath, $data['last_name'], 12345678]);

            if ($result->successful()) {
                return redirect()->route('students.index')->with('error', 'Student not created.');
            }

            return redirect()->route('students.index')->with('success', 'student created.');
        } catch (\Exception $e) {
            // DB::rollBack();

            return redirect()->route('students.index')->with('error', 'Student not created.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return Inertia::render('Dashboard/Students/Show', [
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $genders = array_column(Gender::cases(), 'value');

        return Inertia::render('Dashboard/Students/Edit', [
            'student' => $student,
            'genders' => $genders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentUpdateRequest $request, Student $student):\Illuminate\Http\RedirectResponse
    {

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

            DB::commit();

            return redirect()->route('students.index')->with('success', 'Student updated.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('students.index')->with('error', 'Students not updated.');
        }
    }

    public function delete(Student $student)
    {
        return Inertia::render('Dashboard/Students/Delete', [
            'student' => $student,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Student $student): \Illuminate\Http\RedirectResponse
    {

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
