<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $newCategory = Category::create(
                [
                    'name' => ucfirst($request->name),
                    'slug' => Str::slug($request->name)
                ])->save();

            return response()->json([
                'category' => $newCategory
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ],400);
        }
        
    }

    public function getAll()
    {
        return Category::paginate(10);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return $category;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $category->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Categoria alterada com sucesso!'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category){
            $category->delete();
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
