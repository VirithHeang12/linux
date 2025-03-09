<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        DB::beginTransaction();

        try {

            $student = Student::create([
              'student_id'          => $request->student_id,
              'first_name'          => $request->first_name,
              'last_name'           => $request->last_name,
              'gender'              => $request->gender,
              'date_of_birth'       => $request->date_of_birth,
              'address'             => $request->address,
              'email'               => $request->email,
              'phone'               => $request->phone,
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
    public function update(Request $request, Student $student):\Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();

        try {

            $student->update([
                'student_id'          => $request->student_id,
                'first_name'          => $request->first_name,
                'last_name'           => $request->last_name,
                'gender'              => $request->gender,
                'date_of_birth'       => $request->date_of_birth,
                'address'             => $request->address,
                'email'               => $request->email,
                'phone'               => $request->phone,
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
