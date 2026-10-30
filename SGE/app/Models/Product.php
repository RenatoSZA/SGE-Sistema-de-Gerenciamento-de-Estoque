<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'brand', 'sector', 'quantity', 'min_quantity'];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
