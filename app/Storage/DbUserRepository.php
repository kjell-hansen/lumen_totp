<?php

namespace App\Storage;

use App\Models\RefreshToken;
use App\Models\User;
use Carbon\Carbon;
use DateTimeInterface;

class DbUserRepository implements Interfaces\UserRepository {
    /**
     * @inheritDoc
     */

    function add(User $user):void {
        $user->save();
    }

    /**
     * @inheritDoc
     */
    function getUserByEmail($email):?User {
        return User::findOrFail($email);
    }

    /**
     * @inheritDoc
     */
    public function saveRefreshToken(string $user_id, string $refreshToken, ?DateTimeInterface $expiresAt = null):void {
        $expiresAt = $expiresAt ?? Carbon::now()->addDays(30);

        RefreshToken::create([
            'user_id' => $user_id,
            'token' => $refreshToken,
            'expires' => $expiresAt
        ]);
    }
}
