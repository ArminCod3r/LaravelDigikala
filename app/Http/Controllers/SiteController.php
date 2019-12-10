<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;
use App\Product;
use App\AmazingProducts;

class SiteController extends Controller
{
	private $categories = array();

	public function __construct()
	{
		$categories = self::categoryTree();
		View::share('categories', $categories);
	}

    public function index()
    {
        // Get list of the sliders
        $sliders = DB::table('slider')->orderBy('id', 'DESC')->get();

        $newest_products = Product::with('ProductImage')  // Adding ProductImage[] for image names
                                  ->where('product_status',1)
                                  ->orderBy('id', 'DESC')
                                  ->limit(15)
                                  ->get()
                                  ->toArray();
        
        $amazing_products= AmazingProducts::with('ProductImage')->orderBy('id', 'desc')->get();//->toArray();

        /*return $amazing_products->$id;
        foreach ($amazing_products[0] as $key => $value)
        {
            echo $value."<br/>";

            //foreach ($value["product_image"] as $key1 => $value1)
        }*/

        //return $amazing_products[0]->ProductImage;

        /*foreach ($amazing_products  as $key => $value)
        {
            echo $value->ProductImage."<br/>";
        }*/

    	return view('site.index')->with([                              // $this->categories
                                        'sliders'         => $sliders,
                                        'newest_products' => $newest_products,
                                        'amazing_products'=> $amazing_products,
                                        ]); 
    }





    // Recursive Method to get all the categories/subcategories
    private function categoryTree($parent_id = 0, $sub_mark = '')
    {
	    $query = DB::table('category')
                ->select('*')
                ->where('parent_id',$parent_id)
                ->get()
                ->pluck('cat_name','id');

        
        foreach ($query as $key => $value)
        {
        	//echo $key." : ".$sub_mark.$value."</br>";
        	array_push($this->categories, $value.':'.$parent_id.'-'.$key);
        	$this->categoryTree($key, $sub_mark.'---');
        }
        return $this->categories;
	}

}
