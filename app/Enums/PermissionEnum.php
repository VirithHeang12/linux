<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case CREATE_STUDENT = 'create student';
    case READ_STUDENT = 'read student';
    case UPDATE_STUDENT = 'update student';
    case DELETE_STUDENT = 'delete student';
}
