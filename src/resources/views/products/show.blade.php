<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
    <div class="container">
        <h1>Edit Product: {{ $product->name }}</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="5">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @if ($product->image_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                            style="max-width: 300px;">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="seasons">Seasons:</label><br>
                @foreach ($seasons as $season)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="season-{{ $season->id }}" name="seasons[]"
                            value="{{ $season->id }}"
                            {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="season-{{ $season->id }}">{{ $season->name }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
        <!-- 削除用フォーム -->
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
        </form>
    </div>
</body>

</html>
