<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function getAll($id)
    {
        $product = Product::find($id);
        return $product->images;
    }

    public function upload(Request $request, $id){
        $product = Product::find($id);

        foreach ($request->image as $image) {
            if($image->isValid()){
                $imagePath = $image->store('products');
            }
            $product->images()->create([
                'name' => 'Foto do produto',
                'url' => $imagePath
            ]);
        }

        return $product->images;
    }

    public function destroy($id, $image)
    {
        $product = Product::find($id);
        $image = $product->images()->where('id', $image)->first();
        Storage::delete($image->url);
        $image->delete();

        return $product->images;

    }
}
