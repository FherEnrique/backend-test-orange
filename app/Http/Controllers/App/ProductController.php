<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function readAllProducts(Request $request) {
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1',
            'name' => 'string',
            'sku' => 'string'
        ]);
    
        $query = Product::query();
    
        if ($request->input('sku')) {
            $query->where('SKU', 'like', '%' . $request->input('sku') . '%');
        }

        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
    
        $products = $query->paginate($request->per_page ?? 10, ['*'], 'page', $request->page ?? 1);
    
        return response()->json([
            'data' => $query->get(),
            'pagination' => [
                'page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ]
        ], 200);
    }

    public function readProduct($id) {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'data' => $product,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }
    }

    public function createProduct(Request $request) {
        $validateRequest = $request->validate([
            'name' => 'required|string|unique:products',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'string',
            'image' => 'image|max:2048', // max 2MB
        ]);

        $sku = Str::uuid();

        $imagePath = $request->file('image')->store('public/images');

        $product = new Product([
            'SKU' => $sku,
            'name' => $request->input('name'),
            'stock' => $request->input('stock'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image' => $imagePath,
        ]);
        $product->save();

        return response()->json([
            'data' => $product,
        ], 201);
    }

    public function updateProduct(Request $request, $id) {
        $product = Product::findOrFail($id);

        $validateRequest = $request->validate([
            'name' => 'string|max:255',
            'stock' => 'integer|min:0',
            'price' => 'numeric|min:0',
            'description' => 'string',
            'image' => 'image|max:2048', // ibid: max 2MB
        ]);

        $product->update($validateRequest);
        

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function deleteProduct($id) {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'message' => 'Product deleted successfully'
            ], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }
    }
}
