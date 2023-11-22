<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Enums\Privileges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function createUser(Request $request)
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
        info('pv: ', [Privileges::COMMON->value]);

        try{
            $newUser = [];
            $newUSer['email'] = $request->email;
            $newUSer['password'] = $request->password;
            $newUSer['privileges'] = Privileges::COMMON->value;

            User::create($newUSer);
        } catch (Exception $err) {
            Log::error('Erro ao criar USUARIO no banco', [
                'erro' => $err
            ]);

            return response('Erro ao cadastrar usuário', 500);
        }

        return response('Usuário cadastrado com sucesso', 201);
    }
    
}
