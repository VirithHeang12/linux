<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
    /**
     * Determine whether the user can view any students.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function viewAny(User $user): Response
    {
        return $user->can(PermissionEnum::VIEW_ANY_STUDENTS, Student::class)
            ? Response::allow()
            : Response::deny('You do not have permission to view students.');
    }

    /**
     * Determine whether the user can view the student.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function view(User $user, Student $student): Response
    {
        if ($user->can(PermissionEnum::VIEW_ANY_STUDENTS, Student::class)) {
            return Response::allow();
        }

        return $user->can(PermissionEnum::VIEW_OWN_STUDENT, $student) && $user->id === $student->user_id
            ? Response::allow()
            : Response::deny('You do not have permission to view this student.');
    }

    /**
     * Determine whether the user can create students.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user): Response
    {
        return $user->can(PermissionEnum::CREATE_STUDENTS, Student::class)
            ? Response::allow()
            : Response::deny('You do not have permission to create students.');
    }

    /**
     * Determine whether the user can update the student.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function update(User $user, Student $student): Response
    {
        if ($user->can(PermissionEnum::UPDATE_ANY_STUDENTS, Student::class)) {
            return Response::allow();
        }
        
        return $user->can(PermissionEnum::UPDATE_OWN_STUDENT, $student) && $user->id === $student->user?->id
            ? Response::allow()
            : Response::deny('You do not have permission to update this student.');
    }

    /**
     * Determine whether the user can delete the student.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function delete(User $user, Student $student): Response
    {
        if ($user->can(PermissionEnum::DELETE_ANY_STUDENTS, Student::class)) {
            return Response::allow();
        }

        return $user->can(PermissionEnum::DELETE_OWN_STUDENT, $student) && $user->id === $student->user_id
            ? Response::allow()
            : Response::deny('You do not have permission to delete this student.');
    }

    /**
     * Determine whether the user can restore the student.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function restore(User $user, Student $student): Response
    {
        if ($user->can(PermissionEnum::RESTORE_ANY_STUDENTS, Student::class)) {
            return Response::allow();
        }

        return $user->can(PermissionEnum::RESTORE_OWN_STUDENT, $student) && $user->id === $student->user_id
            ? Response::allow()
            : Response::deny('You do not have permission to restore this student.');
    }

    /**
     * Determine whether the user can permanently delete the student.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function forceDelete(User $user, Student $student): Response
    {
        if ($user->can(PermissionEnum::FORCE_DELETE_ANY_STUDENTS, Student::class)) {
            return Response::allow();
        }

        return $user->can(PermissionEnum::FORCE_DELETE_OWN_STUDENT, $student) && $user->id === $student->user_id
            ? Response::allow()
            : Response::deny('You do not have permission to permanently delete this student.');
    }
}
