<?php

namespace App\Services;


interface UserService
{
    public function getUserByAnonymousId($anonymousId);
}
