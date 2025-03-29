<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Allow mass assignment of user_id
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Define the relationship with the Product model.
     */
 
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}