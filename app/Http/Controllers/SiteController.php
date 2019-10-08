<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;

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
    	return view('site.index'); // $this->categories
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
        	array_push($this->categories, $sub_mark.$value);
        	$this->categoryTree($key, $sub_mark.'---');
        }
        return $this->categories;
	}

}
