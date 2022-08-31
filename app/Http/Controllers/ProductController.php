<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get()->all();
        return view('product.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        $data = $request->except('_token');
        try {
            if($request->immediate == "on"){
                $data['immediate'] = 1;
            }
            if($request->freeshipping == "on"){
                $data['freeshipping'] = 1;
            }
            $data['slug'] = Str::slug('name');
            $data['value'] = $request->value*100;
            $data['name'] = ucfirst($request->name);
            $newProduct = Product::create($data);

            if(isset($request->category)){
                foreach ($request->category as $cat) {
                    $newProduct->categories()->attach($cat);
                }
            }

            return response()->json([
                'product' => $newProduct
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ],400);
        }
        
    }

    public function getAll()
    {
        return Product::with('categories')->paginate(10);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('categories')->find($id);
        return $product;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        if($request->immediate == "on"){
            $data['immediate'] = 1;
        }else{
            $data['immediate'] = 0;
        }

        if($request->freeshipping == "on"){
            $data['freeshipping'] = 1;
        }else{
            $data['freeshipping'] = 0;
        }
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'value' => $request->value*100,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'immediate' => $data['immediate'],
            'freeshipping' => $data['freeshipping'],
        ]);

        $product->categories()->detach();
        
        if(isset($request->category)){
            foreach ($request->category as $cat) {
                $product->categories()->attach($cat);
            }
        }

        return response()->json([
            'message' => 'Categoria alterada com sucesso!'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
        }else{
            return response()->json([
                'message' => 'Erro, categoria não encontrada'
            ],400);
        }
        return response()->json([
            'message' => 'Categoria deletada com sucesso!'
        ],200);
    }
}
