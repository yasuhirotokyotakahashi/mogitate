@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

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
            <!-- 上段左側の検索フォーム -->
            <div class="col-md-3">
                <div class="search-sort-block mb-4">
                    <form action="{{ route('products.search') }}" method="GET">
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
                                    <option value="default" {{ request()->input('sort') === 'default' ? 'selected' : '' }}>
                                        価格で並べ替え</option>
                                    <option value="price_asc"
                                        {{ request()->input('sort') === 'price_asc' ? 'selected' : '' }}>安い順に表示</option>
                                    <option value="price_desc"
                                        {{ request()->input('sort') === 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    @if (isset($keyword) || request()->input('sort'))
                        <div class="alert alert-info d-flex align-items-center justify-content-between mt-3">
                            <div>
                                @if (request()->input('sort') === 'price_asc')
                                    安い順に表示
                                @elseif (request()->input('sort') === 'price_desc')
                                    高い順に表示
                                @else
                                    価格で並べ替え
                                @endif
                            </div>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-danger reset-btn">×</a>
                        </div>
                    @endif
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
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="img-fluid">
                                        @elseif (file_exists(public_path($product->image)))
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                class="img-fluid">
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
        <div class="d-flex justify-content-center mt-4 pagination-block">
            {{ $products->appends(request()->except(['_token']))->links() }}
        </div>
    </div>
@endsection
