<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public const ACCESS_DENIED_BY_USER_ID = [
        1 => [
            'logs',
            'bookkeeping',
            'admins',
            'years',
            'lessons',
            'students',
            'teachers',
            'subjects',
        ], // Mauro
        2 => [ // Julia
            'admins',
            'years',
            'lessons',
            'students',
            'teachers',
            'subjects',
        ],
        3 => [ // Matias
            'years',
            'lessons',
            'students',
            'teachers',
            'subjects',
        ],
        4 => [ // Santa
            'lessons',
            'students',
            'teachers',
            'subjects',
        ],
        5 => [ // Marta
        ],
    ];

    public static function hasAccessTo(string $permission, ?User $user = null): bool
    {
        return in_array($permission, self::ACCESS_DENIED_BY_USER_ID[$user?->id ?? backpack_user()->id] ?? []);
    }
}
