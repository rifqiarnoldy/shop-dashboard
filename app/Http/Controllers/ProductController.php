<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    //
    public function detail($id)
    {
        $response = Http::get(env('APP_API_URL') . '/api/product/' . $id);
        $product = json_decode($response->body())->data;
        return view('pages.product.detail', compact('product'));
    }

    public function edit($id)
    {
        $response = Http::get(env('APP_API_URL') . '/api/product/' . $id);
        $product = json_decode($response->body())->data;
        return view('pages.product.edit', compact('product', 'id'));
    }
}
