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
            # code...
            GoodsLoan::create([
                'loan_id' => $loan->id,
                'goods_name' => $goods_loan[0],
                'goods_type' => $goods_loan[1]
            ]);
        }
    }
}
