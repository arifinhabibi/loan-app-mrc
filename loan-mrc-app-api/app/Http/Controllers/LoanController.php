<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Goods;
use App\Models\Borrower;
use App\Models\GoodsLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    // get all goods
    public function getAllGoods(Request $request){
        $borrower = Borrower::where('id_card', $request->id_card)->first();

        if (!$borrower) {
            # code...
            return response()->json([
                'message' => 'Data tidak ditemukan silahkan daftarkan dulu id card pada system'
            ], 402);
        }

        $goods = Goods::all();

        return response()->json([
            'borrower' => $borrower,
            'goods' => $goods
        ], 200);
    }

    // loan
    public function loan(Request $request){
        // request = borrower, necessity, loan_duration, goods_loans
        $validation = Validator::make($request->all(), [
            'necessity' => 'required',
            'loan_duration' => 'required|date',
        ]);

        if ($validation->fails()) {
            # code...
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validation->errors()
            ], 402);
        }

        $loan = Loan::create([
            'borrower' => $request->borrower,
            'necessity' => $request->necessity,
            'loan_date' => date('Y-m-d'),
            'loan_duration' => $request->loan_duration
        ]);

        foreach ($request->goods_loans as $goods_loan) {
            $goods = Goods::where('id', $goods_loan[0])->first();

            if ($goods_loan[3] > $goods->stock) {
                # code...
                $goods_loan[3] = $goods->stock;
            }
            GoodsLoan::create([
                'loan_id' => $loan->id,
                'goods_id' => $goods_loan[0],
                'goods_name' => $goods_loan[1],
                'goods_type' => $goods_loan[2],
                'quantity' => $goods_loan[3]
            ]);

            
            $goods->update([
                'stock' => $goods->stock - $goods_loan[3]
            ]);
        }

        return response()->json([
            'message' => 'peminjaman barang berhasil'
        ], 200);
    }

    // history
    public function history(){
        $month_year = date('F Y');

        $loans = Loan::with(['goodsLoans'])->get();

        foreach ($loans as $loan) {
            # code...
            $loan->loan_date = date("d F Y", strtotime($loan->loan_date));  
        }



        return response()->json([
            'bulan' => $month_year,
            'loans' => $loans
        ], 200);
    }
}
