<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function login (Request $request) {
        // dd($request->all(['email', 'senha']));
        $credenciais = $request->all(['email', 'password']);
        // autenticacao do usuário
        $token = auth('api')->attempt($credenciais);
        
        if ($token) { // Usuário autenticado com sucesso
            return response()->json(['token' => $token], 200);
        } else { // Erro de usuário ou senha 
            return response()->json(['error' => 'Usuário ou senha invalido'], 403);
        }

        // retornar um token jwt
        return "login";
    }

    public function logout () {
        auth('api')->logout();
        return response()->json(['msg' => 'logout realizado com sucesso']);
    }

    public function refresh () {
        $token = auth('api')->refresh(); // é necessário que o client envie um jwt válido
        return response()->json(['token' => $token], 200);
    }

    public function me() {
        return response()->json(auth()->user());
    }

}
