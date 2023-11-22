<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\Privileges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
       $rules = [
            'email' => 'required|email', 
            'password' => 'required|string'
        ];
           
        $messages = [
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'password.required' => 'Por favor informe o token de acesso'
        ];
           
        $request->validate($rules, $messages);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = Auth::user();
            $token = $user->createToken('etl');
            info("cheguei: ", [$user->privileges]);
            $admin = false;

            if($user->privileges === Privileges::ADMIN->value || $user->privileges === Privileges::SUPER_ADMIN->value)
                $admin = !$admin;
        
            return response()->json(['token' => $token->plainTextToken, 'admin' => $admin]);
        }
        return response()->json(['erro'], 401);
    }
}
