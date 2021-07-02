<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    protected $table = 'goods_category';
    protected $guarded = [];

    public function goods()
    {
        return $this->hasMany(Goods::class, 'category_id');
    }
}
