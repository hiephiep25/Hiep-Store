<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class ContactController extends Controller
{
    public function index(){
        $stores = Store::where('status', Store::ACTIVE)->get();
        return view('front.contact.index', compact('stores'));
    }
}
