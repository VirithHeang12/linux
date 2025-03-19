<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Process;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticationController extends Controller
{
    /**
     * Display the login view.
     *
     * @return Response
     */
    public function createLogin(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     *
     * @return RedirectResponse
     */
    public function storeLogin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('index')->with('success', 'You are logged in');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function createRegister(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param RegisterRequest $request
     *
     * @return RedirectResponse
     *
     */

    public function storeRegister(RegisterRequest $request): RedirectResponse
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

            $image = $request->file('image');

            if ($image) {
                $student->image()->create([
                  'path' => $image->store('students'),
                ]);
            }

            $user = User::create([
              'name'          => $data['first_name'] . ' ' . $data['last_name'],
              'email'         => $data['email'],
              'password'      => Hash::make($data['password']),
            ]);

            $user->assignRole(RoleEnum::STUDENT);

            Auth::login($user);

            DB::commit();

            return redirect()->route('index')->with('success', 'Student registered successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('index')->with('error', 'Student not registered.');
        }

    }
}
