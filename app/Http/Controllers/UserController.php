<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TotpQrService;
use App\Storage\Interfaces\UserRepository;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller {
    public function __construct(private UserRepository $repo) {}

    public function showRegister() {
        return View::make('register');
    }

    public function register(Request $request) {
        try {
            $user = User::factory()->make($request->request->all());
            $this->repo->add($user);

            $qr = TotpQrService::generateQrCode($user);
            return View::make('mail', ['qr' => $qr]);
        } catch (UniqueConstraintViolationException $e) {
            return View::make('register', ['message' => "Eposten finns redan registrerad"]);
        }
    }
}
