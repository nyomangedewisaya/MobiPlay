<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $guarded = ['id'];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
