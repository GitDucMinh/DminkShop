<?php

namespace App\Repositories\Interfaces\Auth;

Interface LoginRepositoryInterface
{
    public function login(array $attributes);
    public function logout();
    public function me();
}
