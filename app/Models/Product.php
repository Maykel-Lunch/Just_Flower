<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public $timestamps = false;
    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'product_id',
        'store_id',
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'created_at',
        'image_id',
    ];

    // Relationship to fetch the primary image
    public function primaryImage()
    {
        return $this->belongsTo(ProductImage::class, 'image_id', 'image_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'product_id', 'product_id');
    }


}



