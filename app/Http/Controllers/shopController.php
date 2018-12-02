<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class shopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
            $categories = Category::all();
            $categoryname = $categories->where('slug', request()->category)->first()->name;
        } else {
            $products = Product::take(12);
            $categories = Category::all();
            $categoryname = 'Featured';
        }
        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price')->paginate(9);
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price','desc')->paginate(9);

        } elseif (request()->sort == 'avg') {
            $products = $products->sortBy('price');

        } elseif (request()->sort == 'popularity') {
            $products = $products->sortBy('price');

        }else{
            $products = $products->paginate(9);

        }
        return view('Theme2.category.category-v2')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryname' => $categoryname,


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->inRandomOrder()->take(3)->get();
        return view('Theme2.product.product')->with([
            'product' => $product,
            'mightAlsoLike' => $mightAlsoLike,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
