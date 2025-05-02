<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\StoreController;

class Store extends Model
{
    use HasFactory;


    protected $table = 'stores';

    protected $primaryKey = 'store_id';
    protected $fillable = ['owner_id', 'store_name', 'store_description', 'store_logo', 'store_address'];


    // hhhhhhh

}
 
