<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('seasons')->paginate(6);
        $seasons = Season::all();
        return view('products.index', compact('products', 'seasons'));
    }

    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store(
                'images',
                'public'
            );
            $product->image = $imagePath;
        }
        $product->save();
        $product->seasons()->sync($validatedData['seasons']);
        return redirect()->route('products.index');
    }

    public function show($product_id)
    {
        $product = Product::find($product_id);
        $seasons = Season::all();
        return view('products.show', compact('product', 'seasons'));
    }

    public function edit(Product $product)
    {
        $seasons = Season::all();
        $product->load('seasons');
        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(UpdateProductRequest $request, $product_id)
    {
        $validatedData = $request->validated();
        $product = Product::findOrFail($product_id);
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store(
                'images',
                'public'
            );
            $product->image = $imagePath;
        }
        $product->save();
        $product->seasons()->sync($validatedData['seasons']);
        return redirect()->route('products.index');
    }

    public function destroy($product_id)
    {
        $product = Product::find($product_id);
        $product->delete();
        return redirect()->route('products.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort', 'default');
        // クエリを初期化
        $products = Product::query();
        // キーワードでのフィルタリング
        if (!empty($keyword)) {
            $products->where('name', 'LIKE', "%{$keyword}%");
        }
        // ソートオプションの適用
        if ($sort === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $products->orderBy('price', 'desc');
        }
        $products = $products->paginate(6);
        return view('products.index', compact('products', 'sort', 'keyword'));
    }
}
