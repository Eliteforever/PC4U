<?php

namespace App\Http\Controllers;

use App\Traits\uploadTrait;
use App\Categories;
use App\Properties;
use App\PropertyValues;
use App\Images;
use App\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {

    use uploadTrait;
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['getDiscounts', 'getAllCategories', 'getAllCategoriesAjax', 'categories', 'category']]);
    }

    protected function categoriesAdmin() {
        return view('admin.categories');
    }

    protected function addCategory(Request $request) {

		if($request['name'] === null) {
			return redirect()->route('categoriesAdmin')->with('message-error', 'Je moet een naam invoeren.');
		}
	
        $imageID = null;
		if($request['imageID'] !== null) {
			$imageID = $request['imageID'];
			
			if(Images::where('id', $imageID)->first() === null) {
				$imageID = null;
			}
		}
		
		if($imageID === null) {
			// Return error if no image
			if($request['imageFolder'] === null || $request['imageName'] === null) {
				return redirect()->route('categoriesAdmin')->with('message-error', 'Je moet een foto selecteren.');
			}
			
			$image = ImageController::getImageOrCreate($request['imageFolder'], $request['imageName']);

			if ($image != null){
				$imageID = $image['id'];
			}
		}
        echo $imageID;

     	$category = Categories::create(['name' => $request['name'],
     									'description' => $request['description'],
				 						'imageID' => $imageID]);

     	return redirect()->route('categoriesAdmin')->with('message-success', 'Categorie ' . $category['name'] . ' is aangemaakt.');
     }

    protected function editCategory(Request $request) {
		if($request['imageFolder'] !== null || $request['imageName'] !== null) {
			$image = ImageController::getImageOrCreate($request['imageFolder'], $request['imageName']);

			$imageID = 0;
			if ($image != null){
				$imageID = $image['id'];
			}
			
			Categories::where('id', $request['id'])->update([
				'name' => $request['name'],
				'description' => $request['description'],
				'imageID' => $imageID
			]);
		} else {
			Categories::where('id', $request['id'])->update([
				'name' => $request['name'],
				'description' => $request['description'],
			]);
		}


    	return redirect()->route('categoriesAdmin')->with('message-success', 'Categorie ' . $request['name'] . ' is gewijzigd.');
    } 

    protected function deleteCategory(Request $request) {

		PropertyValues::join('Properties', 'PropertyValues.propertyID', '=', 'Properties.id')->where('Properties.categoryID', $request['id'])->delete();
		Properties::where('categoryID', $request['id'])->delete();
    	Categories::where('id', $request['id'])->delete();

    	return redirect()->route('categoriesAdmin')->with('message-success', 'Categorie ' . $request['name'] . ' is verwijderd.');
    }

    public static function getAllCategories() {
        $categories = Categories::get();

        foreach ($categories as $key => $category) {
            $image = Images::where('id', $category['imageID'])->first();

            $category['properties'] = CategoryController::getCategoryProperties($category['id']);
            $category['image'] = $image;
        }

        return $categories;        
    }

    public static function getPriceRangeOfProductsInCategories($categoryIDs){
        $query = PropertyValues::select(DB::raw('   TRUNCATE(MIN(Products.price * (Products.btw / 100 + 1)), 2) AS min, 
                                                    TRUNCATE(MAX(Products.price * (Products.btw / 100 + 1)), 2) as max'))       
                                ->join('Products', 'PropertyValues.productID', '=', 'Products.id')     
                                ->join('Properties', 'Properties.id', '=', 'PropertyValues.propertyID')  
                                ->join('Categories', 'Categories.id', '=', 'Properties.categoryID')   
                                  
                                ->whereIn('Properties.categoryID', $categoryIDs)   
                                ->first();
        return $query;
    }

	public static function getCategoryProperties($id) {
		return Properties::where('categoryID', $id)->select('*', 'id as propertyID')->get();
    }

    protected function getCategoriesByIds(Request $request){
        app('debugbar')->disable();

        if (isset($request['categoryIDs'])){
            $ids = json_decode($request['categoryIDs']);
            $categories = array();

            foreach ($ids as $id) {
                $category = $this::getCategoryById($id);
                $category['properties'] = $this::getCategoryProperties($id);
                array_push($categories, $category);
            }  

            return $categories;
        }

        return json_encode("pew");
    }
	
    public static function getCategoryById($id){
        return Categories::where('id', $id)->first();
    }

    public static function getCategoryByName($name){
        return Categories::where('name', $name)->first();
    }

    protected function categories() {
        return view('categories.index')->with('categories', $this::getAllCategories());
    }

    protected function category(Request $request, $categoryName){
        $category = $this::getCategoryByName($categoryName);

        if ($category != null){
            return view('products.index')->with('category', $category); 
        } else {
            return "Category bestaat niet";
        }      
    }

    public static function getCategoriesLikeName($name){
        return Categories::where('Categories.name', 'LIKE', "%{$name}%")->limit(10)->get();
    }
}
