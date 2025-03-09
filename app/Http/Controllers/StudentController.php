<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Enums\PermissionEnum;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     *  @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        if (!auth()->user()->hasPermissionTo(PermissionEnum::READ_STUDENT)) {
            return Inertia::render('Dashboard/Errors/403');
        }
        // $students = Student::all();
        $perPage = request()->query('itemsPerPage', 5);
        $students = Student::paginate($perPage)->appends(request()->query());

        return Inertia::render('Dashboard/Students/Index', [
            'students'     => $students,
        ]);
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {

        if (!auth()->user()->hasPermissionTo(PermissionEnum::CREATE_STUDENT)) {
            return Inertia::render('Dashboard/Errors/403');
        }
        $genders = array_column(Gender::cases(), 'value');
        return Inertia::render('Dashboard/Students/Create', [
            'genders' => $genders,
        ]);
    }

   /**
     * Store a newly created Movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudentStoreRequest $request): \Illuminate\Http\RedirectResponse
    {

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

            DB::commit();

            return redirect()->route('students.index')->with('success', 'student created.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

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
