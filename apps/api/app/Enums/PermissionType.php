<?php

namespace App\Enums;

enum PermissionType: string
{
    // Users
    case USERS_VIEW = 'users.view';
    case USERS_CREATE = 'users.create';
    case USERS_UPDATE = 'users.update';
    case USERS_DELETE = 'users.delete';

        // Roles
    case ROLES_VIEW = 'roles.view';
    case ROLES_CREATE = 'roles.create';
    case ROLES_UPDATE = 'roles.update';
    case ROLES_DELETE = 'roles.delete';

        // Permissions
    case PERMISSIONS_VIEW = 'permissions.view';
    case PERMISSIONS_CREATE = 'permissions.create';
    case PERMISSIONS_UPDATE = 'permissions.update';
    case PERMISSIONS_DELETE = 'permissions.delete';
}
