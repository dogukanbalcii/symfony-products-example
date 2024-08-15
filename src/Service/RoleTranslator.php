<?php

namespace App\Service;

class RoleTranslator
{
    private array $roles = [
        'ROLE_SUPER_ADMIN' => 'Super Admin',
        'ROLE_ADMIN' => 'Admin',
        'ROLE_EDITOR' => 'Editor',
        'ROLE_USER' => 'User',
    ];

    public function translate(string $role): string
    {
        return $this->roles[$role] ?? $role;
    }
}