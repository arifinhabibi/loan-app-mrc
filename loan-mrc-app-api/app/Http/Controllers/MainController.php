<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Goods;
use App\Models\GoodsLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    // create goods
    public function createGoods(Request $request){
        $validation = Validator::make($request->all(), [
            'goods_name' => 'required',
            'stock' => 'required',
            'goods_category_id' => 'required'
        ], 
        [
            'goods_name' => 'nama barang harus di isi',
            'stock' => 'jumlah barang harus di isi',
            'goods_category_id' => 'kategori barang harus di isi'
        ]);

        if ($validation->fails()) {
            # code...
            return response()->json([
                'message' => 'error field',
                'errors' => $validation->errors()
            ], 401);
        }

        Goods::create([
            'goods_name' => $request->goods_name,
            'stock' => $request->stock,
            'goods_category_id' => $request->goods_category_id
        ]);

        return response()->json([
            'message' => 'barang berhasil ditambahkan'
        ], 200);
    }

    // delete goods 
    public function deleteGoods($id){
        $goods = Goods::find($id);

        $goods->delete();

        return response()->json([
            'message' => 'berhasil mengahapus sebuah data'
        ], 200);
    }


    // list goods
    public function listGoods(Request $request){
        $allGoods = Goods::all();

        foreach ($allGoods as $goods) {
            # code...
            $goodsLoans = GoodsLoan::where('goods_id', $goods->id)->get();

            foreach ($goodsLoans as $goodsLoan) {
                # code...
                $loan = Loan::where('id', $goodsLoan->loan_id)->first();
                if ($loan->return_goods == 'belum') {
                # code...
                    $goods->loan = $goods->loan += $goodsLoan->quantity;
                }
            }
        }



        return response()->json([
            'goods' => $allGoods
        ], 200);
    }


    public function dataLoans(Request $request){
        $loans = Loan::where('return_goods', 'belum')->with(['goodsLoans'])->get();

        foreach ($loans as $loan) {
            # code...
            $date_diff = date_diff(date_create($loan->loan_date), date_create($loan->loan_duration) );  
            $loan->loan_duration = $date_diff->format('%a' == '0' ? '1' : '%a' . " hari");
            $loan->loan_date = date("d F Y", strtotime($loan->loan_date));  

        }

        return response()->json([
            'loans' => $loans
        ], 200);
    }
}
