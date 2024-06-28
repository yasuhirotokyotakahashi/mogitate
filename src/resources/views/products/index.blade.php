<h1>商品一覧</h1>

<ul>
    @foreach ($products as $product)
        <li>{{ $product->name }} - ¥{{ $product->price }}</li>
    @endforeach
</ul>
