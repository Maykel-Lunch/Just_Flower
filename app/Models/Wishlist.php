<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * Get the user who owns the wishlist item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that is added to the wishlist.
     */

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    
}
