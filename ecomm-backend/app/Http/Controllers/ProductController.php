<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $req)
    {
        // Validate the request to ensure 'file' is present and is a valid file
        $req->validate([
            'file' => 'required|file',
            // Add any other validation rules for your fields
        ]);

        $product = new Product;
        $product->name = $req->input('name');
        $product->price = $req->input('price');
        $product->description = $req->input('description');

        // Store the uploaded file
        if ($req->hasFile('file')) {
            $product->file_path = $req->file('file')->store('products');
        }

        $product->save();

        return $product;
    }

    function list()
    {
        return Product::all();
        
    }
    function delete($id)
    {
        $result= Product::where('id',$id)->delete();
        if($result)
        {
            return ["result"=>"product is been delete"];
        }
        else{
            return ["result"=>"product is already deleted"];
        }
    }

    function getProduct($id)
    {
        return Product::find($id);
    }

 function updateProduct($id, Request $req)
{
    $product=Product::find($id);
    $product->name = $req->input('name');
    $product->price = $req->input('price');
    $product->description = $req->input('description');

    // Update the uploaded file if a new one is provided
    if ($req->file('file')) {
        
        $product->file_path = $req->file('file')->store('products');
    }

    $product->save();

    return $product;
}

function search($key){
    return Product::where('name','Like',"%$key%")->get();
}
}