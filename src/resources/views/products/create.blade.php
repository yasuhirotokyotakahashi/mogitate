@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
@endsection
@section('content')
    <div class="container">
        <h1>商品登録</h1>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">商品名 <span class="required-label">必須</span></label>
                <input type="text" class="form-control" id="name" name="name" value="" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">値段 <span class="required-label">必須</span></label>
                <input type="text" class="form-control" id="price" name="price" value="" required>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">商品画像 <span class="required-label">必須</span></label>
                <input type="file" class="form-control-file" id="image" name="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="seasons">季節 <span class="required-label">必須</span> <span
                        class="optional-label">複数選択可</span></label>
                <div class="row">
                    <div class="col-12">
                        @foreach ($seasons as $season)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="season_{{ $season->id }}"
                                    name="seasons[]" value="{{ $season->id }}">
                                <label class="form-check-label" for="season_{{ $season->id }}">{{ $season->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('seasons')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">商品説明 <span class="required-label">必須</span></label>
                <textarea class="form-control" id="description" name="description"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg mr-3"
                    style="background-color: lightgray;">戻る</a>
                <button type="submit" class="btn btn-primary btn-lg" style="background-color: orange;">登録</button>
            </div>
        </form>
    </div>
@endsection
