<?php

namespace App\Http\Controllers;

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

        return Inertia::render('DashBoard/Student/Index', [
            'students'     => $students,
        ]);
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return Inertia::render('DashBoard/Student/Create');
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
              'student_id' => $request->student_id,
              'firstname' => $request->firstname,
              'lastname' => $request->lastname,
              'gender' => $request->gender,
              'dob' => $request->dob,
              'address' => $request->address,
              'email' => $request->email,
              'phone' => $request->phone,

            ]);

            DB::commit();

            return redirect()->route('student.index')->with('success', 'student created.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect()->route('student.index')->with('error', 'Student not created.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
