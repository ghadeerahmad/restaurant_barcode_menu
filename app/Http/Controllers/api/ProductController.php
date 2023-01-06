<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * get products in category
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate(['category' => 'nullable|exists:product_categories,id']);
        $query = Product::query();
        if ($request['category']) {
            $query = $query->where('product_category_id', $request['category']);
        }
        $result = $query->get();
        return success_response($result);
    }
}
