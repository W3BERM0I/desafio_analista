<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            info("cheguei: ", [$token]);
    
            return response()->json(['token' => $token->plainTextToken]);
        }
        return response()->json(['erro']);

    }
}
