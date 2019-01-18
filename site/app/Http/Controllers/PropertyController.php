<?php

namespace App\Http\Controllers;

use App\Properties;
use App\Categories;
use App\PropertyValues;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;

class PropertyController extends Controller {
	
	public function __construct()
    {
        $this->middleware('admin');
    }
	
    protected function addProperty(Request $request) {
    	$property = Properties::create(['name' => $request['name'],
    									'description' => $request['description'],
                                        'categoryID' => $request['categoryID'],
                                        'datatype' => $request['datatype'],
                                        'prefix' => $request['prefix'],
                                        'postfix' => $request['postfix']]);

        $category = Categories::where('id', $request['categoryID'])->first();

    	return redirect()->route('categoriesAdmin')->with('message-success', 'Eigenschap ' . $property['name'] . ' voor ' . $category['name'] . ' is aangemaakt.');
    }

    protected function editProperty(Request $request) {
    	Properties::where('id', $request['id'])->update([
    		'name' => $request['name'],
            'description' => $request['description'],
            'datatype' => $request['datatype'],
            'prefix' => $request['prefix'],
            'postfix' => $request['postfix']
        ]);

        $category = Categories::where('id', $request['categoryID'])->first();

    	return redirect()->route('categoriesAdmin')->with('message-success', 'Eigenschap ' . $request['name'] . ' voor ' . $category['name'] . ' is gewijzigd.');
    } 

    protected function deleteProperty(Request $request) {
		$propertyvalues = PropertyValues::join('Properties', 'PropertyValues.propertyID', '=', 'Properties.id')
			->where('Properties.categoryID', $request['categoryID'])
			->where('Properties.id', $request['propertyID'])
			->get();
			
		PropertyValues::join('Properties', 'PropertyValues.propertyID', '=', 'Properties.id')
			->where('Properties.categoryID', $request['categoryID'])
			->where('Properties.id', $request['propertyID'])
			->delete();
			
    	Properties::where('id', $request['id'])->delete();
		
		
		foreach($propertyvalues as $propertyvalue) {
			$exists = PropertyValues::where('productID', '=', $propertyvalue['productID'])
				->first();
				
			if($exists === null) {
				ProductController::addProductCategory($propertyvalue['productID'], $propertyvalue['categoryID']);
			} 
		}
		
        $category = Categories::where('id', $request['categoryID'])->first();

    	return redirect()->route('categoriesAdmin')->with('message-success', 'Eigenschap ' . $request['name'] . ' voor ' . $category['name'] . ' is verwijderd.');
    }
	
	protected function addEditPropertyValue($propertyID, $productID, $value) {
		if($value === null) {
			PropertyValues::where('propertyID', '=', $propertyID)
			->where('productID', '=', $productID)
			->delete();
		} else {
			$exists = PropertyValues::where('propertyID', '=', $propertyID)
				->where('productID', '=', $productID)
				->first();
				
			if($exists !== null) {
				PropertyValues::where('propertyID', '=', $propertyID)
				->where('productID', '=', $productID)
				->update([
					'propertyID' => $propertyID,
					'productID' => $productID,
					'value' => $value
				]);
			} else {
				PropertyValues::create([
					'propertyID' => $propertyID,
					'productID' => $productID,
					'value' => $value
				]);
			}
		}
		
	}
	
	protected function editPropertyValue(Request $request) {
		ProductController::removeProductPropertieValueNull($request['id']);
		$this::addEditPropertyValue($request['propertyID'], $request['id'], $request['value']);
		
		$exists = PropertyValues::where('propertyID', '=', $request['propertyID'])
			->where('productID', '=', $request['id'])
			->first();
			
		if($exists === null) {
			ProductController::addProductCategory($request['id'], $request['productCategoryID']);
		}
		
        $properties = Properties::where('id', $request['propertyID'])->first();
		
    	return redirect()->route('productsAdminID', $request['id'])->with('message-success', 'Eigenschap '. $properties['name'] .' van ' . $request['name'] . ' succesvol gewijzigd.');
	}

    public static function getPropertyByCategoryNameAndPropertyName($categoryName, $propertyName){
        $category = CategoryController::getCategoryByName($categoryName);

        return Properties::where('categoryID', $category['id'])->where('name', $propertyName)->first();
    }

    public static function getPropertyByName($products){
        
    }
}

?>