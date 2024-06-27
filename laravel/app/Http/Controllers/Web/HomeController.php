<?php


namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index() {
        $meats = Product::available()->where('category_id', 5)->orderBy('created_at', 'desc')->limit(5)->get();

        $fruits = Product::available()->where('category_id', 1)->orderBy('created_at', 'desc')->limit(5)->get();

        $vegetables = Product::available()->where('category_id', 2)->orderBy('created_at', 'desc')->limit(5)->get();

        $eggs = Product::available()->where('category_id', 4)->orderBy('created_at', 'desc')->limit(5)->get();

        $dairies = Product::available()->where('category_id', 3)->orderBy('created_at', 'desc')->limit(5)->get();

        $seafoods = Product::available()->where('category_id', 6)->orderBy('created_at', 'desc')->limit(5)->get();

        $cannedFoods = Product::available()->where('category_id', 7)->orderBy('created_at', 'desc')->limit(5)->get();

        $snacks = Product::available()->where('category_id', 8)->orderBy('created_at', 'desc')->limit(5)->get();

        $spices = Product::available()->where('category_id', 9)->orderBy('created_at', 'desc')->limit(5)->get();

        $drinks = Product::available()->where('category_id', 10)->orderBy('created_at', 'desc')->limit(5)->get();

        return view('front.index', compact('meats', 'fruits', 'vegetables', 'eggs', 'dairies',
                                            'seafoods', 'cannedFoods', 'snacks', 'spices', 'drinks'));
    }
}
