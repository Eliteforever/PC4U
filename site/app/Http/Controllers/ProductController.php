<?php

namespace App\Http\Controllers;

use App\Traits\uploadTrait;
use App\Products;
use App\Images;
use App\Properties;
use App\PropertyValues;
use App\OrderProducts;
use App\SaleProducts;
use App\StockProducts;
use App\RepairProducts;
use App\Categories;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use uploadTrait;
	public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'getProductInfo', 'selectedProductsWithCategories', 'searchProductsAndCategories']]);
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {

		$productInfo = ProductController::getProductInfo($id);
        $productInfo = SalesController::parseProductsTroughSales(array($productInfo));

        return view('shop.product', compact('productInfo'));
    }
	
	private function getProductInfo($id) 
	{
		$product = Products::where('id', $id)->first();
		if($product !== null) {
			$product['category'] = ProductController::getProductCategorie($product['id']);
			$product['properties'] = ProductController::getProductProperties($product['id']);
			$product['image'] =  Images::where('id', $product['imageID'])->first();
            $product['recommended'] = json_decode(ProductController::getRecommendedProducts($product['category']['id'], $product['id']), true);
			return $product;
		} else {
			return null;
		}
	}

	protected function productSelectTest(Request $request){
		return view('test.productSelect');
	}

	protected static function getProductCategorie($id)
	{
		$categorie = Products::join('PropertyValues', 'Products.id', '=', 'PropertyValues.productID')
				->join('Properties', 'PropertyValues.propertyID', '=', 'Properties.id')
				->join('Categories', 'Properties.categoryID', '=','Categories.id')
				->where('Products.id', '=', $id)
				->select("Categories.*")
				->first();
				
		if($categorie === null) {
			$categorie = PropertyValues::join('Categories', 'PropertyValues.value', '=', 'Categories.id')
				->whereNull('PropertyValues.propertyID')
				->where('PropertyValues.productID', '=', $id)
				->select("Categories.*")
				->first();
		}
				
		return $categorie;
	}

	protected static function getProductProperties($id)
	{
		$properties = PropertyValues::join('Properties', 'PropertyValues.propertyID', '=', 'Properties.id')
			->where('productID', $id)
			->select('Properties.*', 'PropertyValues.*', 'PropertyValues.id as valueID')
			->get();
		return $properties;
	}
	
	protected static function removeProductProperties($id) {
		PropertyValues::where('productID', $id)->delete();
	}
	
	public static function removeProductPropertieValueNull($id) {
		PropertyValues::where('productID', $id)
			->whereNull('PropertyValues.propertyID')
			->delete();
	}
	
	public static function addProductCategory($id, $categoryID) {
		PropertyValues::create(['productID' => $id, 'value' => $categoryID]);
	}
	
    protected function addProduct(Request $request) 
	{
		//return $request;
		$imageID = null;
		if($request['imageFolder'] !== null || $request['imageName'] !== null) {
			$image = null;
			if($request['imageFolder'] !== null && $request['imageName'] !== null) {
				$image = ImageController::getImageOrCreate($request['imageFolder'], $request['imageName']);
			}
			
			if ($image != null){
				$imageID = $image['id'];
			}
		}
		
     	$product = Products::create(['name' => $request['name'],
									'description' => $request['description'],
									'price' => $request['price'],
									'btw' => $request['btw'],
									'imageID' => $imageID
									]);
		
		
		if($product['id'] !== null && $request['productCategoryID']) {
			$this::removeProductProperties($product['id']);
			$this::addProductCategory($product['id'], $request['productCategoryID']);
		}
		
     	return redirect()->route('productsAdminID', $product['id'])->with('message-success', 'Product ' . $product['name'] . ' is aangemaakt.');
	}

    protected function editProduct(Request $request) 
	{
		//return $request;
		if($request['imageFolder'] !== null || $request['imageName'] !== null) {
			$image = ImageController::getImageOrCreate($request['imageFolder'], $request['imageName']);

			$imageID = 0;
			if ($image != null){
				$imageID = $image['id'];
			}
			
			Products::where('id', $request['id'])->update([
				'name' => $request['name'],
				'description' => $request['description'],
				'price' => $request['price'],
				'btw' => $request['btw'],
				'imageID' => $imageID
			]);
		} else {
			Products::where('id', $request['id'])->update([
				'name' => $request['name'],
				'description' => $request['description'],
				'price' => $request['price'],
				'btw' => $request['btw']
			]);
		}


    	return redirect()->route('productsAdminID', $request['id'])->with('message-success', 'Product ' . $request['name'] . ' is gewijzigd.');
    } 

    protected function deleteProduct(Request $request) 
	{
		RepairProducts::where('productID', '=', $request['id'])->delete();
		OrderProducts::where('productID', '=', $request['id'])->delete();
		SaleProducts::where('productID', '=', $request['id'])->delete();
		StockProducts::where('productID', '=', $request['id'])->delete();
		PropertyValues::where('productID', '=', $request['id'])->delete();
		Products::where('id', '=', $request['id'])->delete();
    	return redirect()->route('productsAdmin')->with('message-success', 'Product ' . $request['name'] . ' is verwijderd.');
    }
	
    public static function getAllProducts() 
	{
        $products = Products::get();

        foreach ($products as $key => $product) {
            $product['category'] = ProductController::getProductCategorie($product['id']);
			$product['properties'] = [];
			if($product['category']['id'] !== null) {
				$product['properties'] = CategoryController::getCategoryProperties($product['category']['id']);
			}
			
			$properties = ProductController::getProductProperties($product['id']);
			foreach($properties as $propertie) {
				foreach($product['properties'] as $key => $catoProp) {
					if($catoProp['propertyID'] == $propertie['propertyID']) {
						$product['properties'][$key] = $propertie;
						break;
					}
				}
			}
			
			
            $image = Images::where('id', $product['imageID'])->first();
            $product['image'] = $image;
        }

        return $products;        
    }

    public static function getProductsByCategoryId($categoryID){
    	return  Products::join('PropertyValues', 'PropertyValues.productID', '=', 'Products.id')
						->join('Properties', 'Properties.id', '=', 'PropertyValues.propertyID')
						->join('Categories', 'Categories.id', '=', 'Properties.categoryID')
						->where('Categories.id', $categoryID)
						->get();   	
    }

    public static function getRecommendedProducts($categoryID, $productID) {
        return DB::table('Products')
            ->select('Products.*')
            ->join('Categories', 'Categories.id', '=', 'Categories.id')
            ->where('Categories.id', $categoryID)
            ->where('Products.id', '!=', $productID)
            ->get();
    }

    public static function getSelectedProductsWithCategories($request){

    	$returnData = array();

		$query = Products::join('PropertyValues', 'PropertyValues.productID', '=', 'Products.id');
		$query->join('Properties', 'Properties.id', '=', 'PropertyValues.propertyID');
		$query->join('Categories', 'Categories.id', '=', 'Properties.categoryID');

		if (isset($request['categoryID'])){
			$query->where('Categories.id', $request['categoryID']);
		}

		if (isset($request['categoryName'])){
			$query->where('Categories.name', $request['categoryName']);
		}

		if (isset($request['filters'])){

			$allProperties = json_decode($request['filters'])->properties;

			foreach ($allProperties as $filterProperty){
				
				if ($filterProperty->categoryName == ""){

					if ($filterProperty->propertyName == "Prijs"){
						$min = $filterProperty->value->data->min / 1.21;
						$max = $filterProperty->value->data->max / 1.21;

						$query->where('Products.price', '>=', "{$min}");
						$query->where('Products.price', '<=', "{$max}");
					} else if ($filterProperty->propertyName == "Naam"){
						$query->where('Products.name', 'LIKE', "%{$filterProperty->value->data}%");
					}
			 	} else {
					$property = PropertyController::getPropertyByCategoryNameAndPropertyName($filterProperty->categoryName, $filterProperty->propertyName);
					$returnData['wupperdepup'] = $filterProperty;
					if ($filterProperty->value->datatype == 1){
						$query->where('PropertyValues.value', 'LIKE', "%{$filterProperty->value->data}%");					
					} else if ($filterProperty->value->datatype == 2){
						$query->where('PropertyValues.value', '>=', "{$filterProperty->value->data->min}");
						$query->where('PropertyValues.value', '<=', "{$filterProperty->value->data->max}");
					}

					$query->where('Properties.id', $property['id']);
			 	}
			}

			$allCategories = json_decode($request['filters'])->categories;

			foreach ($allCategories as $category){

				$query->where('Categories.name', $category);
			}
		}

		if (isset($request['sort'])){
			$sort = json_decode($request['sort']);
			$returnData['sort'] = $sort;

			if ($sort != null){
				if ($sort->categoryName == ""){
				 	if ($sort->propertyName == "Prijs"){
				 		$query->orderBy('Products.price', $sort->orderType);
				 	} else if ($sort->propertyName == "Naam"){
				 		$query->orderBy('Products.name', $sort->orderType);
				 	}
				} else {
				 	$query->orderBy("PropertyValues.value", $sort->orderType);
				 	$property = PropertyController::getPropertyByCategoryNameAndPropertyName($sort->categoryName, $sort->propertyName);
				 	$query->where('PropertyValues.propertyID', '=', $property['id']);
				 	$query->groupBy('PropertyValues.value');
				}	
			}		
		}

		$query->groupBy(
			'Products.id',
			'Categories.id'
		);

		$productIDs = $query->get([
			'Products.id AS productID',
			'Categories.id AS categoryID',
		]); 


		$products = array();
		$categories = array();

		foreach ($productIDs as $productQuery){
			$product = ProductController::getProductById($productQuery['productID']);
			$product['image'] = Images::where('id', $product['imageID'])->first();
			$product['categoryID'] = $productQuery['categoryID'];
			array_push($products, $product);
		}

		SalesController::parseProductsTroughSales($products);

		$categoryIDs = ProductController::getUniqueCategoriesFromProducts($products);
		$numeralPropertyRanges = ProductController::getNumeralRangeFromPropertiesByCategoryIDs($categoryIDs);

		// Retrieve properties of category of products
		foreach ($categoryIDs as $categoryID){
			$category = CategoryController::getCategoryById($categoryID);	
			$category['properties'] = CategoryController::getCategoryProperties($categoryID);	

			foreach ($category['properties'] as $property){
				foreach ($numeralPropertyRanges as $range){
					if ($property['id'] == $range['id']){
						$property['min'] = $range['min'];
						$property['max'] = $range['max'];
						break;
					}
				}
			}

			array_push($categories, $category);
		}

		$returnData['products'] = $products;
		$returnData['categories'] = $categories;

		$returnData['other'] = [];

		$priceRange = CategoryController::getPriceRangeOfProductsInCategories($categoryIDs);
		$returnData['other']['priceRange'] = [];
		$returnData['other']['priceRange'] = $priceRange;

		return $returnData;	
    }

    protected static function getProductById($productID){
    	return Products::where('id', $productID)->first();
    }

    protected function searchProductsAndCategories(Request $request){
    	app('debugbar')->disable();

    	$returnData = array();

    	$products = ProductController::getProductsLikeName($request['inputValue']);
    	SalesController::parseProductsTroughSales($products);
    	$returnData['products'] = $products;
    	$returnData['categories'] = CategoryController::getCategoriesLikeName($request['inputValue']);

    	// Retrieve image object for every product
		for ($i = 0; $i < count($returnData['products']); $i++){
			$returnData['products'][$i]['image'] = Images::where('id', $returnData['products'][$i]['imageID'])->first();
		}

    	return $returnData;
    }

    protected function pewpewplonserino(Request $request){
    	// $temp = [1,2,3,4];

    	// return ProductController::getNumeralRangeFromPropertiesByCategoryIDs($temp);

    	return ProductController::getSelectedProductsWithCategories($request);
    }

    public static function getProductsLikeName($name){
    	return Products::where('Products.name', 'LIKE', "%{$name}%")->limit(5)->get();
    }

    private static function getNumeralRangeFromPropertiesByCategoryIDs($categoryIDs){

		$query = PropertyValues::select(DB::raw('Properties.id as id, MIN(PropertyValues.value) AS min, MAX(PropertyValues.value) as max'))
								->where('datatype', 2) // datatype of numeral
								->whereIn('Properties.categoryID', $categoryIDs)
								->join('Properties', 'PropertyValues.propertyID', '=', 'Properties.id')
								->groupBy('Properties.id')	  				
				  				->get();

		return $query;
    }

    private static function getUniqueCategoriesFromProducts($products){

    	$categoryIDs = array();

    	for ($i = 0; $i < count($products); $i++){
		 	array_push($categoryIDs, $products[$i]['categoryID']);
		}

		return array_unique($categoryIDs);
    }

    protected function products(Request $request){
    	//return $this::getSelectedProducts($request);
    	return view('products.index')->with('category', '');
    }

    protected function selectedProductsWithCategories(Request $request){
    	return $this::getSelectedProductsWithCategories($request);
    	//return view('products.index');
    }
	
	protected function productsAdmin(Request $request, $id = null)
	{
		$productInfo = $this->getProductInfo($id);
		
		return view('admin.products', compact('productInfo'));
	}
	
	protected function changeProductCategory(Request $request) 
	{
		if($request['id'] !== null && $request['productCategoryID']) {
			$this::removeProductProperties($request['id']);
			$this::addProductCategory($request['id'], $request['productCategoryID']);
		}
		
    	return redirect()->route('productsAdminID', $request['id'])->with('message-success', 'Categorie van ' . $request['name'] . ' succesvol gewijzigd.');
	}
}
