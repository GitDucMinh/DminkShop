<?php

namespace App\Repositories\Interfaces\Auth;

interface RegisterRepositoryInterface {
    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * isExistEmail
     * @param $email
     * @return boolean
     */
    public function isExistEmail($email);
}