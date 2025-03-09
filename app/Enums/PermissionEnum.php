<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_ANY_STUDENTS = 'view any students';
    case CREATE_STUDENT = 'create student';
    case VIEW_STUDENT = 'read student';
    case UPDATE_STUDENT = 'update student';
    case DELETE_STUDENT = 'delete student';
    case RESTORE_STUDENT = 'restore student';
    case FORCE_DELETE_STUDENT = 'force delete student';
}
