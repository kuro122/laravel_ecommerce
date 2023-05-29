<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Http;
use App\Mail\OrderNotification;
use Illuminate\Support\Facades\Mail;
use Stripe;
use Exception;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use App\Models\product;
use DateTime;
use Dompdf\Dompdf;
use PDF;
use App\Models\cart;

use Stripe\Charge;
use Stripe\Customer;
use Illuminate\Support\Facades\View;
class adminController extends Controller

{
    public function signupage(){
        return view('signupage');
    }

    public function adminsignup(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        User::create([
            'name'=> $name,
            'email' => $email,
            'password'=>Hash::make($password),

            ]
        );
        return redirect('userlogin');
    }
    public function adminlogin()
    {
        return view('adminlogin');
    }

    public function logins(Request $request){
        $creds = $request->only('email','password');
        if(Auth::attempt($creds)){
            return redirect('addproducts');
        }else{
            echo "error not loged in";
        }

    }

    public function logout()
        {
            Session::flush();
            Auth::logout();

            return Redirect('userlogin');
    }

        public function addproducts(){
            if (Auth::check()) {
                return view('addproducts');
            }
            return redirect('adminlogin');
        }
  
        public function addproductdetails(Request $request){
            if (Auth::check()) {
                $userid = Auth::id();
            }
            $product_name = $request -> input('product_name');
            $product_price =  $request -> input('product_price');
            $product_about =  $request -> input('product_about');
    //    this is used for store image in local folder
            $imageName = time().'.'.$request->product_image->extension();  
            $request->product_image->move(public_path('images'), $imageName);
        
            // $product_image->move($destinationPath, $product_image);
            $ss = DB::insert("insert into product (name, image, price, description) values (?,?,?,?)", [$product_name,$imageName,$product_price,$product_about]);
            if($ss){
                return redirect('addproducts')->with('message', 'Data added Succesful.');;
            }else{
                echo "error";
            }
        }
        public function index(Request $request){
            $data = DB::select('select * from product');
            //  cart details addition
            if(Auth::check()){        
                $userid = Auth::id();
                $cart = cart::where('user_id', $userid)->get();
                $count = $cart ? $cart->count() : 0;
                return view('index',['data'=>$data,'total_cart'=>$count,'userid'=>$userid]);

            } else {
                $count = 0;
                return view('index',['data'=>$data,'total_cart'=>$count]);

            }
                // return response()->json(['val'=>$count]);
        }


        public function shopdetails($id){
            $quer = DB::select('select * from product where id = ?',[$id]);
            return view('shopdetails',['quer'=>$quer]);
        }
       
        public function cart(Request $request, $id){
            $color = $request->input('color');
            $size = $request->input('size');
            $no_of_items = $request->input('no_of_items');
            $userid = Auth::id();
            $existingRecord = DB::select('select * from cart where user_id = ? and product_id = ?', [$userid, $id]);
            if (!$existingRecord) {
                $qr = DB::insert('insert into cart (user_id, product_id,color,size,no_of_items) values (?,?,?,?,?)', [$userid, $id,$color,$size,$no_of_items]);
            }
            $cart_data = DB::table('cart')
                ->join('product', 'cart.product_id', '=', 'product.id')
                ->select('cart.*', 'product.name', 'product.price', 'product.image')
                ->where('cart.user_id', $userid)
                ->get();

            $prices = $cart_data->pluck('price'); // get a collection of all prices
            $items = $cart_data->pluck('no_of_items');
            $total = $prices->map(function ($price, $index) use ($items) {
                return $price * $items[$index];
            })->sum();
          // calculate the sum of prices
            if ($request->ajax()) {
                return response()->json(['cdata'=>$cart_data,'total' => $total,'prices'=>$prices,'userid'=>$userid]);
              } else {
                // return response()->json(['total'=>$total_price,'items'=>$items]);
                return view('cart',['cdata'=>$cart_data,'total' => $total,'prices'=>$prices,'userid'=>$userid]);
              }
              


        }
        
        public function checkout(Request $request){
            $discounted_price = $request->input('discount');
            if (Auth::check()) {
                $cart_id = Auth::id();
            }
            // ______________________show product Details ____________________________
            $cart_data = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->select('cart.*', 'product.name', 'product.price', 'product.image')
            ->where('cart.user_id', $cart_id)
            ->get();
            $prices = $cart_data->pluck('price'); // get a collection of all prices
            $items = $cart_data->pluck('no_of_items');
            $total = $prices->map(function ($price, $index) use ($items) {
                return $price * $items[$index];
            })->sum();
        return view('checkout',['cdata'=>$cart_data,'total' => $total,'prices'=>$prices,'userid'=>$cart_id]);
      
        }
        public function placeorder(Request $request){
             if (Auth::check()) {
                $cart_id = Auth::id();
            }

            // get the values
            $firstname = $request->input('firstname');
            $lastname = $request->input('lastname');
            $email = $request->input('email');
            $phone = $request->input('mnumber');
            $address = $request->input('address');
            $country = $request->input('country');
            $city = $request->input('city');
            $state = $request->input('state');
            $zipcode = $request->input('zipcode');
            $user_id = Auth::id();
            $save = DB::insert('insert into checkout (first_name,last_name,email,phone,address,country,city,state,zipcode,cart_id,user_id) values (?,?,?,?,?,?,?,?,?,?,?)',[$firstname,$lastname,$email,$phone,$address,$country,$city,$state,$zipcode,$cart_id,$user_id]);
            return redirect('charge');
        }

        public function charge(){
            return view('striptest');
        }

    public function payment(Request $request)
    {
        // Set the Stripe API key
        return view('newpayment');   
    }



    public function destroy($id){

        $deleted = DB::delete("delete from cart where id = ?",[$id]);
        $userid = Auth::id();
        $cart_data = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->select('cart.*', 'product.name', 'product.price', 'product.image')
            ->where('cart.user_id', $userid)
            ->get();

        $prices = $cart_data->pluck('price'); // get a collection of all prices
        $items = $cart_data->pluck('no_of_items');
        $total = $prices->map(function ($price, $index) use ($items) {
            return $price * $items[$index];
        })->sum();
    if($deleted){
        return response()->json(['cdata'=>$cart_data,'total' => $total,'prices'=>$prices,'userid'=>$userid]);
    }
    else {
        echo "some error";
    }

}

public function stripe(){
    return view('pay');
}



public function userlogin(){
    return view('userlogin');
}
public function login_user(Request $request){
    $creds = $request->only('email','password');
        if(Auth::attempt($creds)){
            return redirect('/');
        }else{
            return back()->withInput()->withErrors(['status' => 'wrong credentials']);

        }
}



public function searcheddata(Request $request)
{
    $searchTerm = $request->input('search');

    $data = product::where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->get();

    return view('search',['data'=>$data]);
}

public function autocompleteSearch(Request $request)
{
      $query = $request->get('query');
      $filterResult = product::where('name', 'LIKE', '%'. $query. '%')->get();
      return response()->json($filterResult);
} 

public function createnewcoupon(Request $request){
    return view('createcoupon');
}
public function  coupondetails(Request $request){
    $code = $request->input('code');
    $discout_percent= $request->input('discount');
    $usage_limit = $request->input('usagelimit');
    $usage_count = $request->input('usagecount');
    $start_date = $request->input('startdate');
    $end_date = $request->input('enddate');
    $cdetail = DB::insert('insert into coupon (code,discount_percent,usage_limit,usage_count,start_date,end_date) values (?, ?, ?, ?, ?, ?)', [ $code,$discout_percent,
    $usage_limit,
    $usage_count,
    $start_date,
    $end_date]);
    if($cdetail){
        echo 'coupon details saved';
    }else{
        echo 'error';
    }

}

public function checkcoupon(Request $request){
    $code = $request->input('code');
    $price = $request->input('price');
    $co = DB::select('select * from coupon where code = ?',[$code]);
    if($co){
        $dt = new DateTime();
        $ls =  $dt->format('Y-m-d');
        $discount_percent = $co[0]->discount_percent;
        $usage_limit = $co[0]->usage_limit;
        $usage_count = $co[0]->usage_count;
        $start_date = $co[0]->start_date;
        $end_date = $co[0]->end_date;
        if($end_date != $ls && $usage_limit != $usage_count){
             // Convert the percent to a decimal
        $decimal = $discount_percent / 100;

        // Calculate the value from the percent and original value
        $result = $decimal * $price;

        }else{
            return 'Either coupon expired or limit exceeded';
        }

        return response()->json(['status'=>$result,'discount'=>$discount_percent,]);
    }else{
        return response()->json(['status'=>'coupon details not found']);
    }
   

}

//  addition of search functionality using ajax without page refresh

public function ajax_search(Request $request){
    $data = DB::select('select * from product');
    $searchTerm = $request->input('query');

    $searchdata = product::where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->get();
    if($request->ajax()){
        return response()->json(['data' => $searchdata]);
    }else{
        return view('search',['data'=>$data]);
    } 
}

//  pdf generation 

public function invoice_download(Request $request)
{
    return view('invoice');

}




public function generatePDF()
{
    $name = 'shiv';
    $tax = 500;
    
    if (Auth::check()) {
        $cart_id = Auth::id();
    }
    // ______________________show product Details ____________________________
    $data = DB::table('cart')
    ->join('product', 'cart.product_id', '=', 'product.id')
    ->select('cart.*', 'product.name', 'product.price', 'product.image')
    ->where('cart.user_id', $cart_id)
    ->get();
    // $checkout_details = $data->id;

    $prices = $data->pluck('price'); // get a collection of all prices
    $items = $data->pluck('no_of_items');
    $total = $prices->map(function ($price, $index) use ($items) {
        return $price * $items[$index];
    })->sum();
    $content = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Invoice</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      
    </head>
    <body>
    <h1>E-SHOPPER</h1>
    Order ID : '.$name.'
    <br>
    xyz Name : 
    <br>
    address : 
    <br>
    contact : 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($data as $row) {
                $content .= '<tr scope="row">
                    <td>'.$row->name.'</td>
                    <td>'.$row->no_of_items.'</td>
                    <td>'.$row->price.' Rs.</td>
                </tr>';
            }
            $content .= '
                <tr>
                    <td colspan="3">Subtotal</td>
                    <td>'.$total.' Rs.</td>
                </tr>
                <tr>
                    <td colspan="3">Shipping</td>
                    <td>'.$tax.' Rs.</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td>'.$total+$tax.' Rs.</td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>';
    
  
    //  content = 'html code '.$content.'some new code ';php code content .='html code';  string strcuture

    $pdf = PDF::loadHTML($content);
    return $pdf->download('table.pdf');
// return view('invoice');
}



public function review(){

    return response()->json('review submitted');
}
public function rate(Request $request){
    $val = $request->get('rating');
    return response('rate'.$val);
}



public function bookOrder(Request $request)
{
    // Book the order
    // $mail = 'the mail of user';
    // Send email notification
   $kk =  Mail::to('shivshankar@kuroit.in')->send(new OrderNotification());
    if($kk){
        return view('order');
    }
    else{
        return response('error',500);
    }
}

public function autosuggestsearch(){
    
    return view('autosuggest');
}

    public function suggest(Request $request)
{
    $query = $request->input('q');
    $products = product::where('name', 'like', '%'.$query.'%')->limit(5)->get();
    return response()->json($products->pluck('name'));
}

public function blacklist(){
    return view('blacklist');
}



public function getDelistDetails(Request $request)
{
    $apiKey = '9e4JJUDrP4jEF0nQ6dv4HUdSd5Xw9qGz';
    $ip = $request->input('ip');

    $response = Http::get("http://blacklist.kuroit.co.uk/api/delistdetails", [
        'apikey' => $apiKey,
        'ip' => $ip,
    ]);

    $data = $response->json();

    // Handle the response data as needed
    // For example, you can return the data as a JSON response
    return response()->json($data);
}

public function hi(){
    return view("hi");
}

}

