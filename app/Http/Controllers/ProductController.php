<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return $products;
    }

    public function show($id)
    {
        $product = Product::find($id);
        return $product;
    }

    public function store(Request $request)
    {
        $faker = \Faker\Factory::create();
        $name = $request->name;
        $slug = Str::slug($name);
        $image = $faker->imageUrl();
        $description = $faker->paragraph();
        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'featured_image' => $image,
            'description' => $description,
            'details' => $request->details,
            'price' => $request->price,
        ]);

        \App\Jobs\ProductCreated::dispatch($product->toArray())->onQueue('main_queue');

        return response($product, Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        if(!$product || empty($product)){
            return response(null, Response::HTTP_NOT_FOUND);
        }
        $name = $request->name;
        $slug = Str::slug($name);
        //$image = $faker->imageUrl();
        //$description = $faker->paragraph();
        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            //'featured_image' => $image,
            //'description' => $description,
            'details' => $request->details,
            'price' => $request->price,
        ]);

        \App\Jobs\ProductUpdated::dispatch($product->toArray())->onQueue('main_queue');

        return response($product, Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product || empty($product)){
            return response(null, Response::HTTP_NOT_FOUND);
        }
        $product->delete();
        \App\Jobs\ProductDeleted::dispatch($id)->onQueue('main_queue');
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
