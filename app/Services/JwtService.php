<?php

namespace App\Services;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService {
    private string $key;
    private string $algo = 'HS256';

    public function __construct() {
        $this->key = env('JWT_SECRET', 'fallback_secret');
    }

    public function createAccessToken(int $userId):string {
        $now = Carbon::now();
        $exp = $now->copy()->addMinutes(15); // kortlivat token
        $payload = [
            'sub' => $userId,
            'iat' => $now->timestamp,
            'exp' => $exp->timestamp,
        ];
        return JWT::encode($payload, $this->key, $this->algo);
    }

    public function validate(string $token):?object {
        try {
            return JWT::decode($token, new Key($this->key, $this->algo));
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function createRefreshToken():string {
        return bin2hex(random_bytes(40));
    }
}
