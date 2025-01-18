<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('FINANCEIRO2024')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'Login Realizado com Sucesso!'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Usuario ou Senha Incorreto!'
            ]);
        }

    }

    public function logout(): JsonResponse
    {
        $userLogado = Auth::check();

        if ($userLogado) {
            $user = User::where('id', Auth::id())->first();
            $user->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout realizado com sucesso!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao fazer logout!'
            ]);
        }

    }
    public function validaToken(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
            ]);
        }



    }
}
