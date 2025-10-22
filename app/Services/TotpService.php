<?php

namespace App\Services;

use Exception;
use OTPHP\TOTP;

class TotpService {
    public function verify(string $secret, string $code):bool {
        try {
            $totp = TOTP::create($secret);
            return $totp->verify($code, null, 1); // ±30 sekunders tolerans
        } catch (Exception $e) {
            return false;
        }
    }

    public function generateSecret(int $length = 32):string {
        // används när ny användare skapas eller byter authenticator-app
        return bin2hex(random_bytes($length / 2));
    }

    public function getOtpAuthUrl(string $email, string $secret):string {
        $issuer = env('APP_NAME', 'LumenApp');
        $totp = TOTP::create($secret);
        $totp->setLabel($email);
        $totp->setIssuer($issuer);
        return $totp->getProvisioningUri();
    }
}
