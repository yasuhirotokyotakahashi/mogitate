@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/products/show.css') }}">
@endsection
@section('content')
    <div class="container">
        <!-- パンくずリストの追加 -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">商品一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">>{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- 削除用フォーム -->
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="form-delete">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');">この商品を削除する</button>
        </form>

        <!-- 更新用フォーム -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="form-update">
            @csrf
            @method('PUT')

            <div class="form-row">
                <!-- 左側の画像表示 -->
                <div class="form-column">
                    <div class="image-container">
                        <!-- 現在の画像 -->
                        @if ($product->image)
                            @if (Storage::disk('public')->exists($product->image))
                                <img id="current-image" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}" class="image-preview">
                            @elseif (file_exists(public_path($product->image)))
                                <img id="current-image" src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="image-preview">
                            @endif
                        @endif
                        <!-- 新しい画像のプレビュー -->
                        <img id="image-preview" src="#" alt="New Image Preview" class="image-preview"
                            style="display: none;">
                    </div>
                </div>

                <!-- 右側の入力フォーム -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="name">商品名:</label>
                        <input type="text" id="name" name="name" value="{{ $product->name }}" class="form-input">
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">値段:</label>
                        <input type="number" id="price" name="price" value="{{ $product->price }}"
                            class="form-input">
                        @error('price')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="seasons">季節:</label><br>
                        @foreach ($seasons as $season)
                            <div class="form-check-inline">
                                <input type="checkbox" id="season-{{ $season->id }}" name="seasons[]"
                                    value="{{ $season->id }}"
                                    {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                                <label for="season-{{ $season->id }}">{{ $season->name }}</label>
                            </div>
                        @endforeach
                        @error('seasons')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="image">商品画像:</label>
                <input type="file" id="image" name="image" class="form-input-file" onchange="previewImage(event)">
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">商品説明:</label>
                <textarea id="description" name="description" rows="5" class="form-textarea">{{ $product->description }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
                <button type="submit" class="btn-submit">変更を保存</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('image-preview');
                preview.src = reader.result;
                preview.style.display = 'block'; // 画像のプレビューを表示
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);

                const currentImage = document.getElementById('current-image');
                if (currentImage) {
                    currentImage.style.display = 'none'; // 既存の画像を非表示
                }
            }
        }
    </script>
@endsection
