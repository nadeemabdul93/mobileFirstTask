<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
class ProductsController extends Controller
{
    // Index method to retrieve all products
    public function index()
    {
        $products = Product::all();
        if(sizeof($products)){           
            return response()->json(["status" => 201,"success" => true, "message" => "All product list", "data"=>$products]);
            
        }else{
            return response()->json(["status" => 400,"success" => false, "message" => "Products not found"]);

        }
        
     
    }

    // Show method to retrieve a single product
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(["status" => 400,"success" => false, "message" => "Product not found"]);
        }

        return response()->json(["status" => 201,"success" => true, "message" => "Product Details", "data"=>$product]);
    }

    // Store method to create a new product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'required|integer',                
        ]);
        if ($validator->fails()){
            return response()->json(["status" => 400,"success" => false, "message" => $validator->messages()->first()]);
        }
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $query=$product->save();
        
        if ($query==true){
            return response()->json(["status" => 201,"success" => true, "message" => "Product Successfully added"]);
        }else{
            return response()->json(["status" => 400,"success" => false, "message" => "Failed try again"]);

        }
    }

    // Update method to update an existing product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(["status" => 400,"success" => false, "message" => "Product not found"]);
        }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;        
        $product->quantity = $request->quantity;        
        $query=$product->save();
        if ($query==true){
            return response()->json(["status" => 201,"success" => true, "message" => "Product Successfully Updated","data"=>$product]);
        }else{
            return response()->json(["status" => 400,"success" => false, "message" => "Failed try again"]);

        }
    }

    // Destroy method to delete a product
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(["status" => 400,"success" => false, "message" => "Product not found"]);
        }
        $product->delete();
        return response()->json(["status" => 201,"success" => true, "message" => "Product successlly deleted"]);
    }
}