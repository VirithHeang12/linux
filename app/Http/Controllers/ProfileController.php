<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Academic;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display the student's profile.
     *
     * @return \Inertia\Response
     */
    public function profile(): \Inertia\Response
    {
        $student = auth()->user()->userable;

        Gate::authorize('update', $student);

        $academicYears = Academic::get();
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

        $student->load([
            'image',
            'academics'
        ]);

        $student = StudentResource::make($student);

        return Inertia::render('Dashboard/Profile/Index',[
            'student'       => $student,
            'academicYears' => $academicYears,
            'rooms'         => $rooms,
            'classes'       => $classes,
        ]);
    }
    public function edit(Student $student){
         $student=Student::find($student->id);
         $student->load([
              'image',
              'academics'
         ]);
   
          return Inertia::render('Dashboard/Profile/Edit',[
                'student' => $student,
          ]);
    }
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


            $image = $request->file('image');
            if ($image) {
                Storage::delete($student->image->path);
                $student->image()->delete();
                $student->image()->create([
                    'path' => $image->store('students'),
                ]);
            }
            DB::commit();

            return redirect()->route('students.profile')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('students.profile.index')->with('error', 'Students not updated.');
        }
    }

}
