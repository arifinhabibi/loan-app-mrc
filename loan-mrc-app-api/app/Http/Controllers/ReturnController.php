<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Goods;
use App\Models\GoodsLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    // return goods
    public function returning(Request $request, $id){
        $loan = Loan::with(['goodsLoans'])->find($id);

        if (!$loan) {
            # code...
            return response()->json([
                'message' => 'data peminjaman tidak ditemukan'
            ], 401);
        }

        $goodsLoans = GoodsLoan::where('loan_id', $loan->id)->get();

        foreach ($goodsLoans as $goodsLoan) {
            # code...
            $goods = Goods::find($goodsLoan->goods_id);

            $goods->update([
                'stock' => $goods->stock + $goodsLoan->quantity
            ]);

        }

        $user = User::where('tokens', $request->token)->first();

        $loan->update([
            'return_goods' => 'sudah',
            'return_date' => date('Y-m-d'),
            'receiver' => $user->username
        ]);


        return response()->json([
            'message' => 'barang berhasil dikembalikan'
        ], 200);
    }
}
