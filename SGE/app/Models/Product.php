<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'brand', 'sector', 'quantity', 'min_quantity'];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
