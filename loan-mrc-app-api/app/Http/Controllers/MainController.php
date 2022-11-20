<?php

namespace App\Http\Controllers;

use App\Models\Goods;
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
}
