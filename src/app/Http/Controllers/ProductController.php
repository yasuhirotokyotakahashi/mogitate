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
        $sort = $request->input('sort', 'default');
        $query = Product::with('seasons');
        // ソートオプションに基づいてクエリを修正

        // ページネーションを適用
        $products = $query->paginate(6);

        // すべての季節を取得
        $seasons = Season::all();
        return view('products.index', compact('products', 'seasons', 'sort'));
    }

    // 商品登録フォーム表示
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    // 商品登録
    public function store(StoreProductRequest $request)
    {
        // バリデーション済みデータの取得
        $validatedData = $request->validated();

        // 商品データの保存
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            // 画像の保存処理（必要に応じて変更）
            $image = $request->file('image');
            $imagePath = $image->store(
                'images',
                'public'
            );
            $product->image = $imagePath; // 保存したファイルパスをimage_pathに設定
        }

        $product->save();

        // 関連する季節を保存
        $product->seasons()->sync($validatedData['seasons']);

        // 保存完了後、一覧ページなどにリダイレクト
        return redirect()->route('products.index')->with('success', '商品が作成されました。');
    }

    // 商品詳細表示
    public function show($product_id)
    {
        $product = Product::find($product_id);
        $seasons = Season::all();


        return view('products.show', compact('product', 'seasons'));
    }

    // 商品更新フォーム表示
    public function edit(Product $product)
    {
        $seasons = Season::all();
        $product->load('seasons');
        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(UpdateProductRequest $request, $review_id)
    {
        // バリデーション済みデータの取得
        $validatedData = $request->validated();
        $product = Product::findOrFail($review_id);
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            // 画像の保存処理（必要に応じて変更）
            $image = $request->file('image');
            $imagePath = $image->store(
                'images',
                'public'
            );
            $product->image = $imagePath; // 保存したファイルパスをimage_pathに設定
        }

        $product->save();

        // 関連する季節を保存
        $product->seasons()->sync($validatedData['seasons']);




        return redirect()->route('products.index')->with('success', 'レビューが更新されました');
    }

    // 商品削除
    public function destroy($product_id)
    {
        $product = Product::find($product_id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function search(Request $request)
    {

        // 検索キーワードを取得
        $keyword = $request->input('keyword');
        // ソートオプションを取得
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

        // ページネーションの適用
        $products = $products->paginate(6);

        // ビューに変数を渡す
        return view('products.index', compact('products', 'sort', 'keyword'));
    }
}
