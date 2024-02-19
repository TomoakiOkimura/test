<?php
namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Company;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required', 
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', 
            'img_path' => 'nullable|image|max:2048',
        ]);
       
        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);

        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }
        $product->save();

        return redirect('products');
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

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);


        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/products');
    }
}