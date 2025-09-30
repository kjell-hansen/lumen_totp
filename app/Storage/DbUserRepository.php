<?php

namespace App\Storage;

use App\Models\User;
use App\Storage\Interfaces\UserRepository;

class DbUserRepository implements Interfaces\UserRepository {

    function add(User $user): void {
        $user->save();
    }
}
