<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;
use App\Models\product;
class ApiController extends Controller
{
// -------------------API for LOGIN ---------------------------
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('MyApp')->accessToken;
        return response()->json(['token' => $token], 200);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

    //  api created for product add
    public function addProductDetails(Request $request)
    {
      
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $productAbout = $request->input('product_about');

        $imageName = time() . '.' . $request->product_image->extension();
        $request->product_image->move(public_path('images'), $imageName);

        $result = DB::table('product')->insert([
            'name' => $productName,
            'image' => $imageName,
            'price' => $productPrice,
            'description' => $productAbout,
        ]);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data added successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to add data.']);
        }
    }


    ////////////////////////////////////////////////////
    //  api for product delete
    public function deleteProductDetails(Request $request)
    {
        $productName = $request->input('product_name');

        $result = DB::table('product')->where('name', $productName)->delete();

        if ($result) {
            return response()->json(['status' =>'success','message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['status' => 'error','message' => 'Failed to delete data.']);
        }
    }



    ////////////////////////////////////////////////////
 

    public function getallproducts() {
        $products = DB::table('product')->get();
        return response()->json($products);
    
    }

    //  get total users
    public function getallusers() {
        $users = DB::table('users')->get();
        return response()->json($users);
    }

    //  get search result
    public function search(Request $request){
        $searchTerm = $request->input('query');
        $searchdata = product::where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('description', 'like', '%' . $searchTerm . '%')
                            ->get();
    
        return response()->json(['data' => $searchdata]);
    }
    
    
}
