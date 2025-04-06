<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_category';

    protected $fillable = [
        'product_id',
        'category_name',
        'flower_type',
        'size',
        'dimensions',
        'occasion',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

