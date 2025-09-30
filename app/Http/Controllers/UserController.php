<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Storage\Interfaces\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller {
    public function __construct(private UserRepository $repo) {
    }

    public function showRegister() {
        return View::make('register');
    }

    public function register(Request $request) {
        $user = User::factory()->make($request->request->all());

        $this->repo->add($user);
    }
}
