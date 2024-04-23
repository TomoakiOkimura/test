<?php
namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Company;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller{
    public function index(Request $request){

        $product = Product::sortable()->get();

        $productName = $request->product_name;
        $companyId = $request->company_id;
        $productModel = new Product;
        $products = $productModel->search($productName, $companyId, $request);
        $companies = Company::all();

        return view('products.index', ['products' => $products, 'companies' => $companies]);
    }

    public function create(){
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(ProductRequest $request){
        try {
            $request->validated();
            
            $product = new Product();
            $product->saveProduct($request->all(), $request->file('img_path'));
            
            return redirect('products');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()->withErrors('保存に失敗しました');
        }
    }

    public function show(Product $product){

        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product){
        
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(ProductRequest $request, Product $product){
        try {
            $request->validated();
            
            $product->updateProduct($request);
            return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
            ->with('error', '更新できませんでした');
        }
    }

    public function destroy(Request $request) {
    // dd($request);
    $input = $request->all();
    // dd($input);
        DB::beginTransaction();

        try {
          $product = Product::find($input['product']); 
          $product->delete();

          DB::commit();
          return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => '削除に失敗しました']);
        }
    }
        
};