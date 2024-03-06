<?php
namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Company;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller{
    public function index(Request $request)
    {
        $productName = $request->product_name;
        $companyId = $request->company_id;
        $productModel = new Product;
        $products = $productModel->search($productName, $companyId);
        $companies = Company::all();

        return view('products.index', ['products' => $products, 'companies' => $companies]);
    }


    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(Request $request){
        try {
            $request->validate([
                'product_name' => 'required', 
                'company_id' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'comment' => 'nullable', 
                'img_path' => 'nullable|image|max:2048',
            ]);
            
            $product = new Product();
            $product->saveProduct($request->all(), $request->file('img_path'));
            
            return redirect('products');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()->withErrors('保存に失敗しました');
        }
    }

    public function show(Product $product)
    {

        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product){
        try {
            $request->validate([
                'product_name' => 'required',
                'price' => 'required',
                'stock' => 'required',
            ]);
            $product->updateProduct($request);
            return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            // エラーメッセージの表示など、適切な処理を行う
            return redirect()->back()
            ->with('error', 'An error occurred while updating the product');
        }
    }

    public function destroy(Product $product)
    {
        try {
            if (!$product) {
                return redirect()->back()->with('error', '商品が見つかりませんでした。');
            }
            $product->delete();
        
            return redirect('/products')->with('success', '商品を削除しました。');
        } catch (\Exception $e) {
            // エラーログの記録やエラーメッセージの表示など、エラーハンドリングの処理を行う
            return redirect()->back()->with('error', '削除に失敗しました。');
        }
    }
}