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

    public function deleteUser(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
           
        $messages = [
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
        ];
           
        $request->validate($rules, $messages);
        
        User::where('email', $request->email)->delete();
        return response('Usuário removido com sucesso', 201);
    }

    public function allCommonUser(Request $request)
    {
        $user = User::select('email')->where('privileges', Privileges::COMMON->value)->get();
        return response()->json(['users' => $user], 201);

    }
    
}
