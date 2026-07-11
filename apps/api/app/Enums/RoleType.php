<?php

namespace App\Enums;

enum RoleType: string
{
    case SUPER_ADMIN = 'Super Admin';

    case ADMIN = 'Admin';

    case MANAGER = 'Manager';

    case EMPLOYEE = 'Employee';

    case CUSTOMER = 'Customer';
}
