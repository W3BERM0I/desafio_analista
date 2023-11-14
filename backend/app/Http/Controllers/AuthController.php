<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function auth(Request $request)
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
            $token = $user->createToken('token');
            Auth::user()->setRememberToken($token->plainTextToken);

            return response()->json(['token' => $token->plainTextToken, 'usuario' => $user], 200);
        }
        return response()->json('Usuario invalido', 401);
    }
}
