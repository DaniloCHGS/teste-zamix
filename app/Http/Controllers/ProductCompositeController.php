<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductCompositeController extends Controller
{
    public function index()
    {
        return view('admin.products.composite.index');
    }

    public function create()
    {
        return view('admin.products.composite.create');
    }
}
