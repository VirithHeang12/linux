<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Models\Academic;
use App\Models\Student;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogUserOutWhenGraduate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $user = Auth::user();

        if ($user->hasRole(RoleEnum::STUDENT)) {
            $student = $user->userable;

            $year4 = Academic::whereHas('itClassGenerationAcademics.itClassGenerationAcademicStudents.student', function ($query) use ($student) {
                $query->where('id', $student->id);
            })->where('year', 4)
                ->first();

            if ($year4) {
                if ($year4->end_date < now()) {
                    Auth::logout();
                }
            }
        }

        return $next($request);
    }
}
