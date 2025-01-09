<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $card = Card::where('user_id', auth()->id())->get();
        return response()->json(
            [
                'success' => true,
                'cards' => $card
            ],
            200
        );
    }

    public function show(Card $card): JsonResponse
    {
        Card::where('id', $card->id)
            ->where('user_id', auth()->id())
            ->first();

        return response()->json(
            [
                'success' => true,
                'card' => $card
            ],
            200
        );
    }

    public function store(Request $request): JsonResponse
    {
        $card = Card::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'credit' => $request->credit,
            'used' => $request->used,
            'path_img' => $request->path_img,
        ]);
        return response()->json([
            'success' => true,
            'Card' => $card

        ], 200);
    }

    public function destroy(Card $card): JsonResponse
    {
        if (Auth::id() === $card->user_id) {
            $card->where('id', $card->id)->delete();

            return response()->json([
                'success' => true,
                'Card' => $card,
                'message' => 'Card deleted'
            ], 200);
        } else {
            return response()->json([
                'success' => false,

                'message' => 'Falha ao  deleted card'
            ], 400);
        }
    }

    public function update(Request $request, Card $card): JsonResponse
    {
        if (Auth::id() === $card->user_id) {
            $card->update([
                'name' => $request->name,
                'credit' => $request->credit,
                'path_img' => $request->path_img,
            ]);
            return response()->json([
                'success' => true,
                'bank' => $card,
                'msg' => 'Alterado com sucesso!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'falha ao Alterar'
            ]);
        }
    }

}
