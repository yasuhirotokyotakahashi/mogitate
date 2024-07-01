<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="http://localhost/products">Mogitate</a>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
        </div>
    </nav>

    <div class="container my-5 pt-5">
        <h1 class="text-center mb-4">Product List</h1>

        <div class="row">
            <!-- 左側の検索フォームとソートオプション -->
            <div class="col-md-3">
                <div class="mb-4">
                    <h5>Search & Sort</h5>
                    <form action="{{ route('products.search') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="keyword">Search by name</label>
                            <input class="form-control" type="text" id="keyword" name="keyword"
                                placeholder="Search by name" value="{{ $keyword ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100">Search</button>
                        <div class="form-group mt-3">
                            <label for="sort-options">Sort By</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control" id="sort-options" name="sort" style="flex: 1;">
                                    <option value="default" {{ $sort === 'default' ? 'selected' : '' }}>Default</option>
                                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low
                                        to
                                        High</option>
                                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price:
                                        High to
                                        Low</option>
                                </select>

                            </div>
                        </div>
                    </form>
                    <div class="alert alert-info d-flex align-items-center justify-content-between">
                        <div>
                            Sorted by:
                            @if ($sort === 'price_asc')
                                Price: Low to High
                            @elseif ($sort === 'price_desc')
                                Price: High to Low
                            @else
                                Default
                            @endif
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-danger reset-btn">×</a>
                    </div>
                </div>
            </div>

            <!-- 右側の商品一覧 -->
            <div class="col-md-9">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                <div class="card h-100">
                                    <div class="card-img-top">
                                        <img src="{{ asset('storage/' . $product->image_path) }}"
                                            alt="{{ $product->name }}" class="img-fluid">
                                    </div>
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                        <p class="card-text mb-0">{{ $product->price }}円</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $products->links() }} <!-- ページネーションリンクを表示 -->
                </div>
            </div>
        </div>
    </div>

    <!-- 必要なJavaScriptを追加 -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sort-options');
            const resetButton = document.querySelector('.reset-btn');

            // 初期表示時にリセットボタンのテキストを設定
            updateResetButtonText();

            // ソートオプションが変更されたときにリセットボタンのテキストを更新
            sortSelect.addEventListener('change', updateResetButtonText);

            function updateResetButtonText() {
                const selectedOption = sortSelect.options[sortSelect.selectedIndex];
                if (selectedOption.value === 'price_asc') {
                    resetButton.innerHTML = '×';
                    resetButton.setAttribute('title', 'Reset: Price Low to High');
                } else if (selectedOption.value === 'price_desc') {
                    resetButton.innerHTML = '×';
                    resetButton.setAttribute('title', 'Reset: Price High to Low');
                } else {
                    resetButton.innerHTML = '×';
                    resetButton.setAttribute('title', 'Reset');
                }
            }
        });
    </script>

    <style>
        svg.w-5.h-5 {
            /* ページネーション矢印のサイズ調整 */
            width: 30px;
            height: 30px;
        }

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
    </style>

</html>
