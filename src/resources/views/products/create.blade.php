@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>商品を作成</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" class="form-control" id="name" name="name" value="" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">価格</label>
                <input type="text" class="form-control" id="price" name="price" value="" required>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">説明</label>
                <textarea class="form-control" id="description" name="description"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                @error('seasons')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">画像</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
    </body>
@endsection
