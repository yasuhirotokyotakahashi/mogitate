@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Edit Product: {{ $product->name }}</h1>

        <!-- 編集用フォーム -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- 左側の画像表示 -->
                <div class="col-md-6">
                    <div class="mt-2">
                        <!-- 現在の画像 -->
                        @if ($product->image)
                            @if (Storage::disk('public')->exists($product->image))
                                <img id="current-image" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}" style="max-width: 300px;">
                            @elseif (file_exists(public_path($product->image)))
                                <img id="current-image" src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    style="max-width: 300px;">
                            @endif
                        @endif
                        <!-- 新しい画像のプレビュー -->
                        <img id="image-preview" src="#" alt="New Image Preview"
                            style="max-width: 300px; display: none;">
                    </div>
                </div>

                <!-- 右側のフォーム項目 -->
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div class="form-group">
                        <label for="name">商品名:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $product->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">値段:</label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ $product->price }}">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="seasons">Seasons:</label><br>
                        @foreach ($seasons as $season)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="season-{{ $season->id }}"
                                    name="seasons[]" value="{{ $season->id }}"
                                    {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="season-{{ $season->id }}">{{ $season->name }}</label>
                            </div>
                        @endforeach
                        @error('seasons')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image"
                    onchange="previewImage(event)">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="5">{{ $product->description }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

        <!-- 削除用フォーム -->
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');">Delete</button>
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
