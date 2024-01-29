@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報一覧</h1>
    
    <div class="search mt-5">
        <h2>検索条件で絞り込み</h2>
        <form action="{{ route('products.index') }}" method="GET" class="row g-3">
            <div class="col-sm-12 col-md-3">
                <input type="text" name="product_name" class="form-control" placeholder="商品名" value="{{ request('product_name') }}">
            </div>

            <div class="col-sm-12 col-md-3">
                <select name="company_name" class="form-control" value="{{ request('product->company->company_name') }}">
                    <option value="">未選択</option>

                    @foreach($products as $product)
                    <option value="{{ $product->company->company_name }}">
                        {{ $product->company->company_name }}
                    </option>  
                    @endforeach
                </select>
            </div>

            <div class="col-sm-12 col-md-1">
                <button class="btn btn-outline-secondary" type="submit">絞り込み</button>
            </div>
        </form>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>
    
    <div class="products mt-5">
        <h2>商品情報</h2>
        
        <table class="table table-striped" border="2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品名</th>
                    <th>メーカー名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th><a href="{{ route('products.create') }}" class="btn btn-warning btn-sm mx-1">新規登録</a></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>{{ $product->price }}円</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $products->links() }}
</div>
@endsection