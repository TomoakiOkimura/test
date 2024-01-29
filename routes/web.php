<?php

use Illuminate\Support\Facades\Route;
// "Route"というツールを使うために必要な部品を取り込んでいます。
use App\Http\Controllers\ProductController;
// ProductControllerに繋げるために取り込んでいます
use Illuminate\Support\Facades\Auth;
// "Auth"という部品を使うために取り込んでいます。この部品はユーザー認証（ログイン）に関する処理を行います


Route::get('/', function () {
    // ウェブサイトのホームページ（'/'のURL）にアクセスした場合のルートです
    if (Auth::check()) {
        // ログイン状態ならば
        return redirect()->route('products.index');
        // 商品一覧ページ（ProductControllerのindexメソッドが処理）へリダイレクトします
    } else {
        // ログイン状態でなければ
        return redirect()->route('login');
        //　ログイン画面へリダイレクトします
    }
});



Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});
