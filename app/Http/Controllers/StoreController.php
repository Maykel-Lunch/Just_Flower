<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::all();
        dd($stores);
        return view('dashboard', compact('stores'));
    }
}