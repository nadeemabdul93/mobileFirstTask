<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
class ProductController extends Controller
{
    // List all products
    public function index()
    {
        $products = Product::all();
        if(sizeof($products)){
            return response()->json(["status"=>201, "success"=>true,"message"=>"Product List",'data'=>$products]);
        }else{
            return response()->json(["status"=>400, "success"=>false,'message'=>"Produt not found"]);
        }
    }

    // Show a single product
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(["status"=>400, "success"=>false,'message'=>"Produt not found"]);
        }

        return response()->json(["status"=>201, "success"=>true,"message"=>"Product Details",'data'=>$product]);
    }

    // Create a new product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric',
            'price' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
           'quantity' => ['required', 'numeric'],
           
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>400, "success"=>false,'message' => $validator->errors()],400);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $query=$product->save();

        if($query){
            return response()->json(['status'=>201, "success"=>true,'message' =>"Product successfully created"], 201);
        }
        return response()->json(['status'=>400, "success"=>false,'message' =>"Failed try again"], 400);
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric',
            'price' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'quantity' => ['required', 'numeric'],
            // Add more validation rules as needed
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $product->update($request->all());
        return response()->json(['status'=>201, "success"=>true,'message' =>"Product successfully updated"], 201);
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $product->delete();

        return response()->json(['status'=>201, "success"=>true,'message' =>"Product successfully deleted"], 201);
    }
}
