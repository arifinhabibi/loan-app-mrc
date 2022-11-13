<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;



    public function goods(){
       return $this->hasMany(Goods::class); 
    }
}
