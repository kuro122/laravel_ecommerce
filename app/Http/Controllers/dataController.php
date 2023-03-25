<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class dataController extends Controller
{
    //  get all the data  of products
    public function all_data(){
        $data = DB::select( 'select * from product ');
        return  view('data',['data'=>$data]);
    }
}
