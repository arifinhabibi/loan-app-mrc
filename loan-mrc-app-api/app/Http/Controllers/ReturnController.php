<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    // return goods
    public function returning(Request $request, $id){
        $loan = Loan::find($id);

        if (!$loan) {
            # code...
            return response()->json([
                'message' => 'data peminjaman tidak ditemukan'
            ], 401);
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
