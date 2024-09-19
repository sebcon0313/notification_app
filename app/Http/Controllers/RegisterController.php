<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store() {
        $this->validate(request(), [
            'password' => 'confirmed',
        ],[
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]); 

        $user = User::Create(Request(['name', 'email', 'password']));
        
        /* auth()->login($user); */
        return redirect()->to('/login');
    }
}
