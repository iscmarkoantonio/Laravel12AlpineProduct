<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'description' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'image|max:5120',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $this->generateSku(),
            'status' => $request->status,
        ]);

        #Image handling
        if ($request->hasFile('images')){

            foreach ($request->file('images') as $image) {

                # Upload to storage folder
                $path = $image->store('products', 'public');

                # Insert the product images
                $product->productImages()->create([
                    'featured_image' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product saved successfully!');
    }


    // Function: generateSku
    private function generateSku()
    {
        do {
            $sku = 'SKU-'.strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());
        
        return $sku;
    }




    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $existingImages = $request->input('existing_images', []);
        $hasExistingImages = count($existingImages) > 0;
        $hasNewImages = $request->hasFile('images');

         $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'description' => 'required|string',
            'images' => [$hasExistingImages || $hasNewImages ? 'nullable' : 'required', 'array'],
            'images.*' => 'image|max:5120',
        ]);

        $product->update($request->only([
            'name', 'price', 'status', 'description',
        ]));

        # Handle Deleted images
        $product->productImages()->whereNotIn('featured_image', $existingImages)->get()
        ->each(function($image) {
            Storage::disk('public')->delete($image->featured_image);
            $image->delete();
        });

        # Handle new uploads
        if ($hasNewImages) {

            foreach ($request->file('images') as $file) {

                # store image in storage
                $path = $file->store('products', 'public');


                # save new file path in the database
                $product->productImages()->create([
                    'featured_image' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product) {
            $product->delete();

            return redirect()->back()->with('success', 'Product deleted successfully!');
        }
         return redirect()->back()->with('error', 'Product not deleted');
    }
}
