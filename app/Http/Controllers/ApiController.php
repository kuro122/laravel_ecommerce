<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(){
        $data = DB::select('select * from product');
        return response()->json(['message' => 'first API Created!']);

    }

}
