<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductCompositeController extends Controller
{
    public function index()
    {
        return view('admin.products.composite.index');
    }

    public function create()
    {
        $products = Product::where('type', 'simple')->get();
        return view('admin.products.composite.create', compact('products'));
    }
}
