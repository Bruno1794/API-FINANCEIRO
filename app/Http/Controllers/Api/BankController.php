<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BankController extends Controller
{
    //
    public function show(): JsonResponse
    {
        $bank = Bank::where('user_id', Auth::id())->get();
        return response()->json([
            'success' => true,
            'banks' => $bank,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            if (Auth::check()) {
                $banck = Bank::create([
                    'name' => $request->name,
                    'balance' => $request->balance,
                    'count' => $request->count,
                    'type_count' => $request->type_count,
                    'path_img' => $request->path_img,
                    'user_id' => Auth::id(),
                ]);
                return response()->json([
                    'success' => true,
                    'banck' => $banck,
                    'msg' => 'Salvo com sucesso!'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Usuario nao autenticado'
                ], 400);
            }
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => $error->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, Bank $bank): JsonResponse
    {
        if (Auth::id() === $bank->user_id) {
            $bank->update([
                'name' => $request->name,
                'balance' => $request->balance,
                'count' => $request->count,
                'type_count' => $request->type_count,
                'path_img' => $request->path_img,

            ]);
            return response()->json([
                'success' => true,
                'banck' => $bank,
                'msg' => 'Alterado com sucesso!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'msg' => "Não possivel fazer a alteração"

            ], 400);
        }
    }

    public function showId(Bank $bank): JsonResponse
    {
        if (Auth::id() === $bank->user_id) {
            Bank::where('id', $bank->id)->first();

            return response()->json([
                'success' => true,
                'Bank' => $bank
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => "Nenhum registro encontrado"

            ]);
        }
    }

    public function destroy(Bank $bank): JsonResponse
    {
        if (Auth::id() === $bank->user_id) {
            Bank::where('id', $bank->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Removido com sucesso!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Falha ao deletar'

            ]);
        }
    }


}
