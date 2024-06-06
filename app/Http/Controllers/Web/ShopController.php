<?php


namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function show($id) {
        $product = Product::available()->with('category')->findOrFail($id);
        $relatedProducts = Product::available()->where('category_id', $product->category_id)->where('id', '<>', $product->id)->limit(4)->get();
        return view('front.shop.show', compact('product', 'relatedProducts'));
    }

    public function index(Request $request) {
        $perPage = $request->show ?? 9;
        $sortBy = $request->sort_by ?? 'lastest';
        $search = $request->search ?? '';
        $products = Product::available()->with('category')->where('name','like','%' . $search .'%');

        $products = $this->filter($products, $request);

        $products = $this->sortAndPagination($products,$sortBy,$perPage);
        return view('front.shop.index', compact('products'));
    }

    public function sortAndPagination($products, $sortBy, $perPage){
        switch($sortBy){
            case 'lastest':
                $products = $products->orderBy('id');
                break;
            case 'oldest' :
                $products = $products->orderByDesc('id');
                break;
            case 'price-ascending':
                $products = $products->orderByRaw('CAST(price_per_qty AS UNSIGNED) DESC');
                break;
            case 'price-descending':
                $products = $products->orderByRaw('CAST(price_per_qty AS UNSIGNED) DESC');
            break;
            default:
            $products = $products->orderBy('id');
            break;
        }
        $products = $products->paginate($perPage);
        $products->appends(['sort_by'=>$sortBy, 'show'=>$perPage]);
        return $products;
    }

    public function filter($products, Request $request){

        $priceMin = $request->price_min * 1000;
        $priceMax = $request->price_max * 1000;
        $products = ($priceMin != null && $priceMax != null) ? $products->whereBetween('price_per_qty',[$priceMin, $priceMax]): $products;

        return $products;
    }

    public function category($categoryId, Request $request){

        $perPage = $request->show ?? 9;
        $sortBy = $request->sort_by ?? 'lastest';

        $products = Product::available()->where('category_id', $categoryId);

        $products = $this->filter($products, $request);

        $products = $this->sortAndPagination($products,$sortBy,$perPage);
        return view('front.shop.index', compact('products'));
    }
}
