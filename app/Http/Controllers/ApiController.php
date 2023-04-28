<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\product;
class ApiController extends Controller


{
    public function index()
    {
        $resources = product::all();
        return response()->json($resources);
    }

    public function show($id)
    {
        $resource = product::findOrFail($id);
        return response()->json($resource);
    }

    public function store(Request $request)
    {
        $resource = new product;
        $resource->fill($request->all());
        $resource->save();
        return response()->json($resource, 201);
    }

    public function update(Request $request, $id)
    {
        $resource = product::findOrFail($id);
        $resource->fill($request->all());
        $resource->save();
        return response()->json($resource);
    }

    public function destroy($id)
    {
        $resource = product::findOrFail($id);
        $resource->delete();
        return response()->json(null, 204);
    }
}

