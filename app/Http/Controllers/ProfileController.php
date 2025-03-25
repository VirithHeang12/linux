<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display the student's profile.
     *
     * @return \Inertia\Response
     */
    public function profile()
    {
        $student = Auth::user()?->userable;

        if (!$student) {
            return redirect()->route('index')->with('error', 'Student not found.');
        }

        Gate::authorize('update', $student);

        $student->load([
            'image',
            'itClassGenerationAcademicStudents'
        ]);

        $student = StudentResource::make($student);

        return Inertia::render('Dashboard/Profile/Index',[
            'student'       => $student,
        ]);
    }

    /**
     * Update the student's profile.
     *
     * @param ProfileUpdateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request):\Illuminate\Http\RedirectResponse
    {
        $student = Auth::user()->userable;

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

            if (Hash::check($data['current_password'], Auth::user()->password)) {
                if ($data['password']) {
                    Auth::user()->update([
                        'password'      => Hash::make($data['password']),
                    ]);
                }
            }

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

            return redirect()->route('students.profile')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('students.profile')->with('error', 'Students not updated.');
        }
    }

}
