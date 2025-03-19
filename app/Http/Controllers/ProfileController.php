<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Academic;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProfileController extends Controller
{
    //
    public function profile(Student $student)
    
    {
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
}
