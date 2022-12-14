<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['product_addons', 'product_edits', 'product_sauces', 'product_sizes'])->find($id);
        $data = $product;
        $addons = array();
        $edits = array();
        $sauces = array();
        $sizes = array();
        foreach ($product->product_addons as $pr)
            array_push($addons, $pr->addon);
        foreach ($product->product_edits as $edit)
            array_push($edits, $edit->edit);
        foreach ($product->product_sauces as $sauce)
            array_push($sauces, $sauce->sauce);
        foreach ($product->product_sizes as $size)
            array_push($sizes, $size->size);
        $data['addons'] = $addons;
        $data['edits'] = $edits;
        $data['sauces'] = $sauces;
        $data['sizes'] = $sizes;
        return response()->json($data);
    }
}
