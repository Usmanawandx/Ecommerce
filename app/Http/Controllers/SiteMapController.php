<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brands;
use App\Models\Category;
use App\Models\User; 

class SiteMapController extends Controller
{
    public function product()
	{
	  $prods= Product::all();
	  return response()->view('sitemap.product', [
	      'prods' => $prods,
	  ])->header('Content-Type', 'text/xml');
	}
	 public function brand()
	{
	  $brands= Brands::all();
	  return response()->view('sitemap.brand', [
	      'brands' => $brands,
	  ])->header('Content-Type', 'text/xml');
	}
	public function category()
	{
	  $categories= Category::all();
	  return response()->view('sitemap.category', [
	      'categories' => $categories,
	  ])->header('Content-Type', 'text/xml');
	}
	public function store()
	{
	  $stores= User::where('is_vendor','=',2)->get();
	  return response()->view('sitemap.store', [
	      'stores' => $stores,
	  ])->header('Content-Type', 'text/xml');
	}
}
