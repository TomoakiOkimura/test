<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function search($productName, $companyId, $request){
        $query = $this->newQuery();

        if ($productName) {
            $query->where('product_name', 'LIKE', "%{$productName}%");
        }

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        if($min_price = $request->min_price){
            $query->where('price', '>=', $min_price);
        }
    
        if($max_price = $request->max_price){
            $query->where('price', '<=', $max_price);
        }
    
        if($min_stock = $request->min_stock){
            $query->where('stock', '>=', $min_stock);
        }
    
        if($max_stock = $request->max_stock){
            $query->where('stock', '<=', $max_stock);
        }
        return $query->paginate(10);
    }

    public function saveProduct($data, $file){
        $this->product_name = $data['product_name'];
        $this->company_id = $data['company_id'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
        $this->comment = $data['comment'];

        if ($file) { 
            $filename = $file->getClientOriginalName();
            $filePath = $file->storeAs('products', $filename, 'public');
            $this->img_path = '/storage/' . $filePath;
        }

        $this->save();
    }

    public function updateProduct($requestData){
        $this->product_name = $requestData->product_name;
        $this->company_id = $requestData->company_id;
        $this->price = $requestData->price;
        $this->stock = $requestData->stock;
        $this->comment = $requestData->comment;

        if($requestData->hasFile('img_path')){ 
            $filename = $requestData->img_path->getClientOriginalName();
            $filePath = $requestData->img_path->storeAs('products', $filename, 'public');
            $this->img_path = '/storage/' . $filePath;
        }

        $this->save();
    }
}