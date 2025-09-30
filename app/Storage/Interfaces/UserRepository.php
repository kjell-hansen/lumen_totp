<?php

namespace App\Storage\Interfaces;

use App\Models\User;

interface UserRepository {
    function add(User $user):void;
}
