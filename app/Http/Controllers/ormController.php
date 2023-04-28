<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\cart;
use App\Models\product;
use Illuminate\Http\Request;

class ormController extends Controller
{
    public function ormtesting(){
        //  all details of user table 
        //  all function is use to get the all details of table
        // $users = User::all();
        // $product = product::all();
        // $cart = cart::all();
        // Retrieving a single record from a table by its primary key:
        $single_user = User::find(9);
        // Retrieving records from a table based on a condition:
        $condition = product::where('id','=',1)->get();
        // $users = User::where('status', '=', 'active')->get();
        // Creating new record  
        // $product_add = new product;
        // $product_add->name = 'submititing by orm';
        // $product_add->image = 'images\1678702720.jpg';
        // $product_add->price = 20000;
        // $product_add->description = ' hi this is description';
        // // name  image price description
        // $product_add ->save();
        //  updating data 
    // $product_update =new product;
    // $product_update->name ='update  by orm';
    // $product_update->save();
        //  to delete a record 
        // $product_delete = product::find(1);
        // $product_delete->delete();
        //  same way we can use count() to
        // $product_count = Product::count();
        // $product_count = Product::where('status', '=', 'active')->count();
        // $product_count = Product::where('status', '=', 'active')->get();
        // all the query of orm tests
    $product_orderby = product::orderBy('name', 'asc')->get();
    // same as groupby 
        return response()->json(['cart'=>$product_orderby]);
    }
}
// django rest framework is a third party package that provides a set of tools and utilities for building restful
// apis with django. 
// it is build on top of django web framework and provides a set of generic views , serializers renderrs parsers,
// and authentication classes for that make it easy to build robust and scalable  apis 
// the rest api uses http protocol to expose urls 
