<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;

class MainController extends Controller
{
    // create goods
    public function createGoods(Request $request){
        $validation = Validation::make($request->all(), [
            'goods_name' => 'required',
            'stock' => 'required',
            'goods_category' => 'required'
        ]);


        Goods::create([
            'goods_name' => $request->goods_name,
            'stock' => $request->stock,
            'goods_category_id' => $request->goods_category_id
        ]);
    }
}
