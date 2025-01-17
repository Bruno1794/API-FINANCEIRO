<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Debit;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DebitController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        if ($request->mes && !$request->mesfinal) {
            $debit = Debit::with('provider')->with('banck')->with('card')->where('user_id', auth()->id())
                ->where('status_debit', 'PENDING')
                ->whereMonth('date_maturity', $request->mes)
                ->whereYear('date_maturity', Carbon::now()->year)
                ->orderBy('date_maturity', 'asc')->get();

            $valueDebit = $debit->where('status_debit', 'PENDING')->sum('value_debit');
        } else {
            if ($request->mes && $request->mesfinal) {
                $debit = Debit::with('provider')->with('bank')->with('card')->where('user_id', auth()->id())
                    ->whereBetween('date_maturity', [$request->mes, $request->mesfinal])
                    ->orderBy('date_maturity', 'asc')->get();

                $valueDebit = $debit->where('status_debit', 'PENDING')->sum('value_debit');
            } else {
                $debit = Debit::with('provider')->with('banck')->with('card')->where('user_id', auth()->id())
                    ->where('status_debit', 'PENDING')
                    ->whereMonth('date_maturity', Carbon::now()->month)
                    ->whereYear('date_maturity', Carbon::now()->year)
                    ->orderBy('date_maturity', 'asc')->get();

                $valueDebit = $debit->where('status_debit', 'PENDING')->sum('value_debit');
            }
        }

        return response()->json([
            'success' => true,
            'debits' => $debit,
            'valueDebit' => number_format($valueDebit, 2),
        ], 200);
    }

    public function indexPaid(Request $request): JsonResponse
    {
        if ($request->mes && !$request->mesfinal) {
            $debit = Debit::with('provider')->with('banck')->with('card')->where('user_id', auth()->id())
                ->where('status_debit', 'PAID')
                ->whereMonth('date_maturity', $request->mes)
                ->whereYear('date_maturity', Carbon::now()->year)
                ->orderBy('date_maturity', 'asc')->get();

            $valueDebit = $debit->where('status_debit', 'PAID')->sum('value_debit');
        } else {
            if ($request->mes && $request->mesfinal) {
                $debit = Debit::with('provider')->with('bank')->with('card')->where('user_id', auth()->id())
                    ->whereBetween('date_maturity', [$request->mes, $request->mesfinal])
                    ->orderBy('date_maturity', 'asc')->get();

                $valueDebit = $debit->where('status_debit', 'PAID')->sum('value_debit');
            } else {
                $debit = Debit::with('provider')->with('banck')->with('card')->where('user_id', auth()->id())
                    ->where('status_debit', 'PAID')
                    ->whereMonth('date_maturity', Carbon::now()->month)
                    ->whereYear('date_maturity', Carbon::now()->year)
                    ->orderBy('date_maturity', 'asc')->get();

                $valueDebit = $debit->where('status_debit', 'PAID')->sum('value_debit');
            }
        }

        return response()->json([
            'success' => true,
            'debits' => $debit,
            'valueDebit' => number_format($valueDebit, 2),
        ], 200);
    }





    public function store(Request $request): JsonResponse
    {
        if (auth()) {
            if ($request->parcel > 1) {
                for ($x = 1; $x <= $request->parcel; $x++) {
                    Debit::create([
                        'value_debit' => $request->value_debit,
                        'type_payment' => $request->type_payment,
                        'status_debit' => $request->status_debit,
                        'date_maturity' => Carbon::parse($request->date_maturity)->addMonths($x),
                        'parcel' => $x . '/' . $request->parcel,
                        'observation' => $request->observation,
                        'banck_id' => $request->banck_id,
                        'provider_id' => $request->provider_id,
                        'card_id' => $request->card_id,
                        'user_id' => auth()->id()
                    ]);
                }
            } else {
                Debit::create([
                    'value_debit' => $request->value_debit,
                    'type_payment' => $request->type_payment,
                    'status_debit' => $request->status_debit,
                    'date_maturity' => $request->date_maturity,
                    'observation' => $request->observation,
                    'banck_id' => $request->banck_id,
                    'provider_id' => $request->provider_id,
                    'card_id' => $request->card_id,
                    'user_id' => auth()->id()
                ]);
            }

            return response()->json([
                'success' => true,
                'msg' => 'Debit cadastrado com sucesso!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Falha ao Cadastrar Debit!'
            ]);
        }
    }

    public function show(Debit $debit): JsonResponse
    {
        if (auth()->id() === $debit->user_id) {
            $debitResult = Debit::with('provider')->where('id', $debit->id)->first();
            return response()->json([
                'success' => true,
                'debit' => $debitResult
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Dados nao encontrado!'
            ]);
        }
    }

    public function updateQuit(Request $request, Debit $debit): JsonResponse
    {
        if (auth()->id() === $debit->user_id) {
            $debit->update([
                'date_paid' => carbon::now(),
                'status_debit' => 'PAID',
                'value_discount' => $request->value_discount

            ]);
            return response()->json([
                'success' => true,
                'debit' => $debit,
                'msg' => 'Debit atualizado com sucesso!'

            ], 200);
        } else {
            return response()->json([
                'success' => false,

            ], 400);
        }
    }
    public function destroy(Debit $debit): JsonResponse
    {
        if(auth()->id() === $debit->user_id){
            $debit->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Debit removido com sucesso!'
            ]);
        }else{

            return response()->json([
                'success' => false,
                'msg' => 'Falha ao remover Debit!'
            ]);
        }



    }
}
