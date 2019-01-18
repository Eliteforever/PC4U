<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Index routes
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('index');
Auth::routes();

//Misc routes
Route::get('/about-us', 'ContactController@about')->name('about-us');
Route::get('/contact', 'ContactController@index')->name('contact');
Route::get('/settings', 'UserController@settings')->name('settings');

//Category related routes
Route::get('/categories', 'CategoryController@categories')->name('categories');
Route::get('/categories/{categoryID}', 'CategoryController@category')->name('category');
Route::post('/getCategoriesByIds', 'CategoryController@getCategoriesByIds')->name('getCategoriesByIds');
Route::get('/admin/categories', 'CategoryController@categoriesAdmin')->name('categoriesAdmin');
Route::post('/getAllCategories', 'CategoryController@getAllCategories')->name('getAllCategories');

//Repair routes
Route::get('repair', 'RepairController@index')->name('repair');
Route::post('repair/post', 'RepairController@postRepair')->name('repair/post');

//Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/repair', 'RepairController@adminIndex')->name('repairAdmin');
    Route::post('/addCategory', 'CategoryController@addCategory')->name('addCategory');
    Route::post('/editCategory', 'CategoryController@editCategory')->name('editCategory');
    Route::post('/deleteCategory', 'CategoryController@deleteCategory')->name('deleteCategory');
    Route::post('/addProperty', 'PropertyController@addProperty')->name('addProperty');
    Route::post('/editProperty', 'PropertyController@editProperty')->name('editProperty');
    Route::post('/editPropertyValue', 'PropertyController@editPropertyValue')->name('editPropertyValue');
    Route::post('/deleteProperty', 'PropertyController@deleteProperty')->name('deleteProperty');
    Route::get('/commercial', 'CommercialController@index')->name('commercial');
    Route::post('/commercial/post', 'CommercialController@post')->name('commercial-post');
    Route::get('/deleteCommercial/{id}', 'CommercialController@delete')->name('commercial-delete');
    Route::get('/makeBanner/{id}', 'CommercialController@makeBanner')->name('commercial-makeBanner');
    Route::get('/product', 'ProductController@productsAdmin')->name('productsAdmin');
    Route::get('/product/{id}', 'ProductController@productsAdmin')->name('productsAdminID');
    Route::post('/addProduct', 'ProductController@addProduct')->name('addProduct');
    Route::post('/editProduct', 'ProductController@editProduct')->name('editProduct');
    Route::post('/deleteProduct', 'ProductController@deleteProduct')->name('deleteProduct');
    Route::post('/changeProductCategory', 'ProductController@changeProductCategory')->name('changeProductCategory');
    Route::get('/users', 'UserController@getAllUsers')->name('getAllUsers');
    Route::get('/users/{id}', 'UserController@adminGetUser')->name('getUserAdmin');
    Route::get('/users/removedUsers', 'UserController@getRemovedUsers')->name('getRemovedUsers');
    Route::post('/editUser', 'UserController@editUser')->name('editUser');
    Route::post('/removeUsers/{userID}', 'UserController@disableUser')->name('removeUser');
    Route::post('/activateUsers/{userID}', 'UserController@activateUser')->name('activateUser');
    Route::get('/sales', 'SalesController@adminSales')->name('adminSales');
    Route::post('/createEditSales', 'SalesController@createEditSales')->name('createEditSales');
    Route::post('/removeSales', 'SalesController@removeSales')->name('removeSales');
    Route::get('/orders', 'OrderController@allOrdersAdmin')->name('allOrdersAdmin');
});
//Product related routes
Route::post('/getAllProducts', 'ProductController@getAllProducts')->name('getAllProducts;');
Route::get('/products', 'ProductController@products')->name('products');
Route::post('/selectedProductsWithCategories', 'ProductController@selectedProductsWithCategories')->name('selectedProductsWithCategories');
Route::post('/searchProductsAndCategories', 'ProductController@searchProductsAndCategories')->name('searchProductsAndCategories');
Route::get('/product/{id}', 'ProductController@index')->name('product');

//Image related routes
Route::get('resizeImage/{imageFolder}/{imagePath}/{width}x{height}', 'ImageController@resizeImage');
Route::get('getImage/{imageID}', 'ImageController@getImage');
Route::post('/imageSubmit', 'ImageController@submit')->name('imageSubmit');
Route::post('/imageDelete', 'ImageController@delete')->name('imageDelete');
Route::post('/getAllImagesInFolder', 'ImageController@getAllImagesInFolder')->name('getAllImagesInFolder');
Route::post('/getAllFoldersInFolder', 'ImageController@getAllFoldersInFolder')->name('getAllFoldersInFolder');

//Cart related routes
Route::get('/cart', 'CheckoutController@index')->name('cart');
Route::get('/checkout', 'CheckoutController@checkout')->name('checkout');
Route::post('/checkout/post', 'CheckoutController@checkoutPost')->name('checkoutPost');

//Order related routes
Route::get('/orders', 'OrderController@allOrders')->name('orders');
Route::get('/order/{orderID}', 'OrderController@viewOrder')->name('order');
Route::get('/factuur/{uuid}', 'OrderController@getFactuurPDF')->name('factuurPDF');

//Test/Dev routes
Route::get('/pewpewplonserino', 'ProductController@pewpewplonserino')->name('pewpewplonserino');
Route::get('/imageTest', 'ImageController@test')->name('imageTest');
Route::get('/productSelectTest', 'ProductController@productSelectTest')->name('productSelectTest');
Route::get('/salesBannerTest', 'SalesController@BannerTest');
Route::get('/invoice', 'CheckoutController@getPDF');