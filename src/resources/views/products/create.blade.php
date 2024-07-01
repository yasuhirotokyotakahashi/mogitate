<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>


    <div class="container">
        <h1>商品を作成</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" class="form-control" id="name" name="name" value="" required>
            </div>

            <div class="form-group">
                <label for="price">価格</label>
                <input type="text" class="form-control" id="price" name="price" value="" required>
            </div>

            <div class="form-group">
                <label for="description">説明</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="seasons">季節</label>
                @foreach ($seasons as $season)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="season_{{ $season->id }}" name="seasons[]"
                            value="{{ $season->id }}">
                        <label class="form-check-label" for="season_{{ $season->id }}">{{ $season->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label for="image">画像</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
</body>
