<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $providers = Provider::where('user_id', auth()->id())->get();

        return response()->json([
            'success' => true,
            'providers' => $providers,
        ]);

    }
    public function show(Provider $provider): JsonResponse
    {
        Provider::where('id', $provider->id)
            ->where('user_id', auth()->id())->first();
        return response()->json([
            'success' => true,
            'provider' => $provider,
        ],200);

    }
    public function store(Request $request): JsonResponse
    {
        $provider = Provider::create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'provider' => $provider,
            'msg' => "Salvo com sucesso"
        ], 200);
    }
    public function update(Request $request, Provider $provider): JsonResponse
    {
        if (\Illuminate\Support\Facades\Auth::id() === $provider->user_id){
            $provider->update([
                'name' => $request->name
            ]);
            return response()->json([
                'success' => true,
                'provider' => $provider,
                'msg' => "Alterado com sucesso"
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'msg'=>'Falha ao atualizar'
            ]);
        }

    }
    public function destroy(Provider $provider): JsonResponse
    {
        if(\Illuminate\Support\Facades\Auth::id() === $provider->user_id){
            $provider->delete();

            return response()->json([
                'success' => true,
                'provider' => $provider,
                'msg' => "Removido com sucesso"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg'=>'Falha ao remover'
            ]);
        }

    }
}
