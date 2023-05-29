<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\Auth;

class productController extends Controller
{
    public function all_product(){
        $data = DB::select('select * from product');
        return view('admin_index',['data'=>$data]);
}    

    public function product_delete($id){
        $product = product::find($id);
        $product->delete();
        return redirect('all_product');
    }
}
