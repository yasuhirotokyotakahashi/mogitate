@extends('layouts.app')
@section('content')
    <div class="container my-5 pt-5">
        <div class="header-row">
            @if (isset($keyword))
                <div class="alert alert-info">
                    "{{ $keyword }}"の商品一覧
                </div>
            @endif
            @if (!isset($keyword))
                <h1 class="mb-4">商品一覧</h1>
            @endif
            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3"
                style="background-color: orange; color: black;">+商品を追加</a>
        </div>

        <div class="row">
            <!-- 上段左側の検索フォームとソートオプション -->
            <div class="col-md-3">
                <div class="search-sort-block mb-4">
                    <form action="{{ route('products.search') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="keyword"></label>
                            <input class="form-control" type="text" id="keyword" name="keyword" placeholder="商品名で検索"
                                value="{{ $keyword ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100"
                            style="background-color: orange; color: black;">検索</button>
                        <div class="form-group mt-3">
                            <label for="sort-options">価格順で表示</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control" id="sort-options" name="sort" style="flex: 1;">
                                    <option value="default" {{ $sort === 'default' ? 'selected' : '' }}>価格で並べ替え</option>
                                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>安い順に表示</option>
                                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>高い順に表示
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="alert alert-info d-flex align-items-center justify-content-between">
                        <div>
                            @if ($sort === 'price_asc')
                                安い順に表示
                            @elseif ($sort === 'price_desc')
                                高い順に表示
                            @else
                                価格で並べ替え
                            @endif
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-danger reset-btn">×</a>
                    </div>
                </div>
            </div>

            <!-- 上段右側の商品一覧 -->
            <div class="col-md-9">
                <div class="row g-2">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                <div class="card h-100">
                                    <div class="card-img-top" style="height: 200px; overflow: hidden;">


                                        @if (Storage::disk('public')->exists($product->image))
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                "class="img-fluid">
                                        @elseif (file_exists(public_path($product->image)))
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                "class="img-fluid">
                                        @endif


                                    </div>
                                    <div class="card-body d-flex justify-content-between align-items-center"
                                        style="min-height: 100px;">
                                        <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                        <p class="card-text mb-0">{{ $product->price }}円</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 下段右側のページネーション -->
        <div class="d-flex justify-content-center mt-4 pagination-block">
            {{ $products->links() }}
        </div>
    </div>

    <style>
        .card {
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .card-img-top {
            overflow: hidden;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-img-top img {
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 0;
        }

        .container {
            margin-top: 60px;
            /* ナビゲーションバーの高さに合わせる */
        }

        .btn-outline-danger.ml-2 {
            margin-left: 10px;
        }

        /* リセットボタンのサイズと位置を調整 */
        .reset-btn {
            margin-left: 10px;
            height: 38px;
            /* ドロップダウンと同じ高さに合わせる */
            line-height: 38px;
            padding: 0 12px;
            /* サイズに合わせてパディングを調整 */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reset-btn:hover {
            text-decoration: none;
            /* ホバリング時のテキスト装飾をなしにする */
        }

        /* 商品カードの高さを均一に */
        .card h-100 {
            height: 100%;
        }

        /* 上段左側のブロック (検索フォームとソートオプション) */
        .search-sort-block {
            position: sticky;
            top: 0;
        }

        /* 下段右側のページネーションを固定 */
        .pagination-block {
            width: 100%;
            position: relative;
            bottom: 0;
        }

        /* ヘッダーロウ */
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        /* ボタンのスタイル */
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }
    </style>
@endsection
