<?php
//2.5 version
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Transaction;


class ProductController extends Controller
{
    // get all products
    public function index()
    {
        $products = product::all();
        return response()->json(data: $products);
    }

    // Get a single product by ID

    public function show($id)
    {
        $products = product::find($id);

        if (!$products) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($products);
    }


    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'director' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'release_date' => 'required|date',
        //     'number_of_ratings' => 'required|integer|min:0',
        //     'average_rating' => 'required|numeric|min:0|max:10',
        // ]);

        $products = product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image URL' => $request->image_URL,
            'stock_left' => $request->stock_left,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price,

        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'product was created successfully',
            'data' => $products
        ], 201);
    }
//     public function update(Request $request, $id)
// {
//     $movie = movies::find($id);

//     if (!$movie) {
//         return response()->json(['message' => 'Movie not found'], 404);
//     }

//     $request->validate([
//         'name' => 'sometimes|required|string|max:255',
//         'director' => 'sometimes|required|string|max:255',
//         'description' => 'nullable|string',
//         'release_date' => 'sometimes|required|date',
//         'number_of_ratings' => 'sometimes|required|integer|min:0',
//         'average_rating' => 'sometimes|required|numeric|min:0|max:10',
//     ]);

//     // Log the request data for debugging
//     \Log::info($request->all());

//     try {
//         $movie->update($request->only(['name', 'director', 'description', 'release_date', 'number_of_ratings', 'average_rating']));
//     } catch (\Exception $e) {
//         return response()->json(['message' => 'Update failed', 'error' => $e->getMessage()], 500);
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'Movie updated successfully',
//         'data' => $movie
//     ]);
// }


//     // Delete a product
    public function destroy($id)
    {
        $products = product::find($id);

        if (!$products) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $products->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie deleted successfully'
        ], 200);
    }


    //buy product
    public function buy($id, $amount)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        if ($product->stock_left < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock for this purchase'
            ], 400);
        }
    
        // Update product stock and prices
        $product->stock_left -= $amount;
        $product->buy_price += $amount * 0.005;
        $product->sell_price -= $amount * 0.005;
        $product->save();
    
        // Record the buy transaction
        Transaction::create([
            'product_id' => $product->id,
            'type' => 'buy',
            'quantity' => $amount
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Product bought successfully',
            'remaining_stock' => $product->stock_left
        ], 200);
    }
    

     
    //sell product
    
    public function sell($id, $amount)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Update product stock and prices
        $product->stock_left += $amount;
        $product->buy_price -= $amount * 0.005;
        $product->sell_price += $amount * 0.005;
        $product->save();
    
        // Record the sell transaction
        Transaction::create([
            'product_id' => $product->id,
            'type' => 'sell',
            'quantity' => $amount
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Product sold successfully',
            'new_stock' => $product->stock_left
        ], 200);
    }
    
   

    public function returnInward($id, $amount)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        //juice
        $product->stock_left += $amount;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product stock_left increased successfully',
            'new_stock' => $product->stock_left
        ], 200);
    }
    public function returnOutward($id, $amount)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        //juice
        $product->stock_left -= $amount;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product stock_left decreased successfully',
            'new_stock' => $product->stock_left
        ], 200);
    }



}

//





//2.0 VERSION
/*
<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // get all products
    public function index()
    {
        $products = product::all();
        return response()->json(data: $products);
    }

    // Get a single product by ID

    public function show($id)
    {
        $products = product::find($id);

        if (!$products) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($products);
    }


    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'director' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'release_date' => 'required|date',
        //     'number_of_ratings' => 'required|integer|min:0',
        //     'average_rating' => 'required|numeric|min:0|max:10',
        // ]);

        $products = product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image URL' => $request->image_URL,
            'stock_left' => $request->stock_left,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price,

        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'product was created successfully',
            'data' => $products
        ], 201);
    }
//     public function update(Request $request, $id)
// {
//     $movie = movies::find($id);

//     if (!$movie) {
//         return response()->json(['message' => 'Movie not found'], 404);
//     }

//     $request->validate([
//         'name' => 'sometimes|required|string|max:255',
//         'director' => 'sometimes|required|string|max:255',
//         'description' => 'nullable|string',
//         'release_date' => 'sometimes|required|date',
//         'number_of_ratings' => 'sometimes|required|integer|min:0',
//         'average_rating' => 'sometimes|required|numeric|min:0|max:10',
//     ]);

//     // Log the request data for debugging
//     \Log::info($request->all());

//     try {
//         $movie->update($request->only(['name', 'director', 'description', 'release_date', 'number_of_ratings', 'average_rating']));
//     } catch (\Exception $e) {
//         return response()->json(['message' => 'Update failed', 'error' => $e->getMessage()], 500);
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'Movie updated successfully',
//         'data' => $movie
//     ]);
// }


//     // Delete a product
    public function destroy($id)
    {
        $products = product::find($id);

        if (!$products) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $products->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie deleted successfully'
        ], 200);
    }


    //buy product
    public function buy($id, $amount)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($product->stock_left < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock for this purchase'
            ], 400);
        }

        $product->stock_left -= $amount;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product bought successfully',
            'remaining_stock' => $product->stock_left
        ], 200);
    }

     
    //sell product
    
    public function sell($id, $amount)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        //juice
        $product->stock_left += $amount;
        $product->save();


        return response()->json([
            'success' => true,
            'message' => 'Product stock_left increased successfully',
            'new_stock' => $product->stock_left
        ], 200);
    }
   

    public function returnInward($id, $amount)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        //juice
        $product->stock_left += $amount;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product stock_left increased successfully',
            'new_stock' => $product->stock_left
        ], 200);
    }
    public function returnOutward($id, $amount)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        //juice
        $product->stock_left -= $amount;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product stock_left decreased successfully',
            'new_stock' => $product->stock_left
        ], 200);
}

}
*/

