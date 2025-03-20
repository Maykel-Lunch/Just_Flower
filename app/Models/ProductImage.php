<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\ProductController;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images'; 

    protected $primaryKey = 'image_id'; 

    protected $fillable = [
        'image_id',
        'product_id',
        'image_url', 
    ];
}

