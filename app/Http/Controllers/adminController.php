<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Stripe;
use Exception;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use App\Models\product;
use DateTime;
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
   

        public function index(){
           
            $data = DB::select('select * from product');
            return view('index',['data'=>$data]);
        }


        public function shopdetails($id){
            $quer = DB::select('select * from product where id = ?',[$id]);
            return view('shopdetails',['quer'=>$quer]);
        }
        
        public function cart($id){
            $userid = Auth::id();
            $existingRecord = DB::select('select * from cart where user_id = ? and product_id = ?', [$userid, $id]);
            if (!$existingRecord) {
                $qr = DB::insert('insert into cart (user_id, product_id) values (?,?)', [$userid, $id]);
            }
            $cart_data = DB::table('cart')
                ->join('product', 'cart.product_id', '=', 'product.id')
                ->select('cart.*', 'product.name', 'product.price', 'product.image')
                ->where('cart.user_id', $userid)
                ->get();

                
            $prices = $cart_data->pluck('price'); // get a collection of all prices
            $total = $prices->sum(); // calculate the sum of prices
            return view('cart',['cdata'=>$cart_data,'total' => $total,'prices'=>$prices,'userid'=>$userid]);
          


        }
        
        public function checkout(){
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
        $total = $prices->sum(); // calculate the sum of prices
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
            
           
            $save = DB::insert('insert into checkout (first_name,last_name,email,phone,address,country,city,state,zipcode,cart_id) values (?,?,?,?,?,?,?,?,?,?)',[$firstname,$lastname,$email,$phone,$address,$country,$city,$state,$zipcode,$cart_id]);
       
            return redirect('charge');
        }

        public function striptest(){
            return view('pay');
        }
        public function charge(){
            return view('striptest');
        }
    public function payment(Request $request)
    {
        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        //
      
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = Charge::create ([
                "amount" => 100*100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "This payment is testistuff",
        ]);
   
        // Handle the Stripe response and redirect the user
        if ($charge->status === 'succeeded') {
            return redirect()->route('checkout')->with('success', 'Payment successful.');
        } else {
            return redirect()->route('checkout')->with('error', 'Payment failed.');
        }
    }



    public function destroy($id)
{        $deleted = DB::delete("delete from cart where id = ?",[$id]);
    if($deleted){
        return response()->json(['success' => true]);
    }
    else {
        echo "some error";
    }

}



// payment handingling


public function stripe()
{
    return view('pay');
}

public function stripePost(Request $request)
{
    // Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $stripe = new \Stripe\StripeClient("sk_test_51Mea73SJaP0ximCYamrqV4g1GeQjvImK0KGEbxc97dA2HS1nzSb41jezwc5sCc9tfioeJQZw3TA7dRBgwpB51nJH00V1cqzY7q");

    $charge = $stripe->charges->create([
            "amount" => 200,
            "currency" => "USD",
            "source" => $request->stripeToken,
            "description" => "This payment is testing purpose of websolutionstuff",
    ]);

    Session::flash('success', 'Payment Successfull!');
       
    return 'payment done';
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


public function search(){
    return view('search');
}




public function searcheddata(Request $request)
{
    $searchTerm = $request->input('search');

    $products = product::where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->get();

    return view('searcheddata', compact('products'));
}



// CREATE NEW COUPON
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

        return response()->json(['status'=>$result]);
    }else{
        return response()->json(['status'=>'coupon details not found']);
    }
    //  match the code 
    // check valid or not
    // check how much discount on coupon
    // check usage limit

}

}