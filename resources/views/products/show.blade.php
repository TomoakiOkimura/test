@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報詳細</h1>
    <dl>
        <form>
            <label for="product_name">商品名
                <div class="form-group">{{ $product->product_name }}</div>
            </label><br>
            <label for="company_id">メーカー名
                <div class="form-group">{{ $product->company->company_name }}</div>
            </label><br>
            <label for="price">価格
                <div class="form-group">{{ $product->price }}円</div>
            </label><br>
            <label for="stook">在庫数
                <div class="form-group">{{ $product->stock }}</div>
            </label><br>
            <label for="comment">コメント
                <div class="form-group">{{ $product->comment }}</div>
            </label><br>

            <label>商品画像
                <div><img src="{{ asset($product->img_path) }}" width="300"></div>
            </label>

            <label class="btn">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-success ">編集</a>
            </label>
            <label class= "btn">
                <a class="btn btn-primary" onclick="history.back()">戻る</a>
            </label>
        </form>
    </dl>
</div>
<style>
    form{
        padding: 0.5em 1em;margin: 2em 0;font-weight: bold;border: solid 1.5px #000000;
    }
    label{
        display:flex;justify-content:space-between;
    }
</style>
@endsection