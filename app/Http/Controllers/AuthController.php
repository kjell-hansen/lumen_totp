<?php

namespace App\Http\Controllers;

use App\Services\JwtService;
use App\Services\TotpService;
use App\Storage\Interfaces\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function __construct(
        private UserRepository $userRepo,
        private TotpService    $totpService,
        private JwtService     $jwtService
    ) {}

    /**
     * Login via TOTP
     */
    public function login(Request $request) {
        $email = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL);
        $code = filter_var($request->input('code'), FILTER_VALIDATE_INT);

        // Hämta användare via e-post
        $user = $this->userRepo->getUserByEmail($email);
        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Verifiera TOTP
        $totpValid = $this->totpService->verify($user->secret, $code);
        if (!$totpValid) {
            return response()->json(['error' => 'Invalid TOTP code'], 401);
        }

        // Skapa access-token
        $accessToken = $this->jwtService->createAccessToken($user->id);

        // Skapa refresh-token och spara i databasen
        $refreshToken = $this->jwtService->createRefreshToken();
        $this->userRepo->saveRefreshToken($user->id, $refreshToken);

        // Sätt refresh-token i HttpOnly-cookie
        $cookie = cookie(
            'refresh_token',
            $refreshToken,
            60 * 24 * 30,  // 30 dagar
            '/',
            null,
            true,          // secure (använd https i produktion)
            true,          // HttpOnly
            false,         // Raw
            'Strict'       // SameSite
        );

        // Returnera JSON med access-token + cookie
        return response()->json([
            'access_token' => $accessToken,
            'token_type' => 'bearer',
            'expires_in' => 900, // 15 minuter
            'user' => [
                'id' => $user->id,
                'email' => $user->epost,
                'name' => $user->namn,
            ]])->cookie($cookie);
    }
}
