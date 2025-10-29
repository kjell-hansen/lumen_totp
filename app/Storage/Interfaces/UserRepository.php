<?php

namespace App\Storage\Interfaces;

use App\Models\User;
use DateTimeInterface;

interface UserRepository {
    /**
     * Spara ny användare till databasen
     * @param User $user
     * @return void
     */
    function add(User $user):void;

    /**
     * Hitta användare via epost
     * @param $email
     * @return User|null
     */
    function getUserByEmail($email):?User;

    /**
     * Sparar refreshtoken för angiven användare
     * @param string $user_id
     * @param string $refreshRefreshToken
     * @param DateTimeInterface $expiresAt
     * @return void
     */
    function saveRefreshToken(string $user_id, string $refreshToken, ?DateTimeInterface $expiresAt):void;

    /**
     * Hämtar en användare baserat på refresh-token
     * @param string $refreshtoken
     * @return User|null
     */
    function getUserByRefreshToken(string $refreshtoken):?User;

    /**
     * Raderar ett refreshtoken så att användaren loggas ut
     * @return void
     */
    public function deleteRefreshToken(string $refreshtoken):void;
}
