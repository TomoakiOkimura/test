@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報一覧</h1>
    
    <div class="mt-5">
        <h2>検索条件で絞り込み</h2>
        <form id="search-form" action="{{ route('products.index') }}" method="GET" class="row g-3">
            <div class="col-sm-12 col-md-3">
                <input type="text" name="product_name" class="form-control" placeholder="商品名" value="{{ request('product_name') }}">
            </div>

            <div class="col-sm-12 col-md-3">
                <select class="form-select" id="company_id" name="company_id">
                    <option value="">メーカー名</option>    
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-12 col-md-2">
                <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
            </div>

            <div class="col-sm-12 col-md-2">
                <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
            </div>

            <div class="col-sm-12 col-md-2">
                <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
            </div>

            <div class="col-sm-12 col-md-2">
                <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
            </div>

            <div class="col-sm-12 col-md-1">
                <button class="btn btn-outline-secondary" type="submit">絞り込み</button>
            </div>
        </form>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>
    
    <div id="products-table" class="products mt-5">
        <h2>商品情報</h2>
        
        <table id="fav-table" class= "table table-striped" border="2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品名</th>
                    <th>メーカー名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>商品画像</th>
                    <th><a href="{{ route('products.create') }}" class="btn btn-warning btn-sm mx-1">新規登録</a></th>
                   </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>{{ $product->price }}円</td>
                    <td>{{ $product->stock }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    <td><a href="{{ route('products.show', ['product' => $product]) }}"class="btn btn-info btn-sm mx-1">詳細表示</a></td>
                    <td>
                        <form method="POST" action="{{ route('products.destroy', $product) }}">
                            @csrf
                            @method('DELETE')
                            <button data-product_id="{{$product->id}}" type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
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