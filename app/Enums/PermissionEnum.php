<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_ANY_STUDENTS = 'view any students';
    case VIEW_OWN_STUDENT = 'view own student';
    case CREATE_STUDENTS = 'create students';
    case UPDATE_ANY_STUDENTS = 'update any students';
    case UPDATE_OWN_STUDENT = 'update own student';
    case DELETE_ANY_STUDENTS = 'delete any students';
    case DELETE_OWN_STUDENT = 'delete own student';
    case RESTORE_ANY_STUDENTS = 'restore any students';
    case RESTORE_OWN_STUDENT = 'restore own student';
    case FORCE_DELETE_ANY_STUDENTS = 'force delete any students';
    case FORCE_DELETE_OWN_STUDENT = 'force delete own student';
}
