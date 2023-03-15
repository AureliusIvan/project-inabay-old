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

Auth::routes();
Route::get('/', function(){
    return redirect('/login');
//    return "Website sedang dalam perbaikan. Silahkan mencoba beberapa saat lagi.";
});

//Route::get('/login', function(){
////    return redirect('/login');
//    return "Website sedang dalam perbaikan. Silahkan mencoba beberapa saat lagi.";
//});
//Route::get('/home', function(){
////    return redirect('/login');
//    return "Website sedang dalam perbaikan. Silahkan mencoba beberapa saat lagi.";
//});
Route::get('/home', 'MemberProductController@index')->name('home');

## GIFT ##
Route::get('/gifts/search', ['middleware' => 'auth', 'uses' => 'ProductController@search']);

Route::get('/gifts', ['middleware' => 'auth', 'uses' => 'GiftController@index']);
Route::get('/gifts/new', ['middleware' => 'auth', 'uses' => 'GiftController@create']);
Route::post('/gifts/new', ['middleware' => 'auth', 'uses' => 'GiftController@store']);
Route::get('/gifts/{id}', ['middleware' => 'auth', 'uses' => 'GiftController@show']);
Route::get('/gifts/edit/{id}', ['middleware' => 'auth', 'uses' => 'GiftController@edit']);
Route::post('/gifts/edit/{id}', ['middleware' => 'auth', 'uses' => 'GiftController@update']);
Route::delete('/gifts/delete/{id}', ['middleware' => 'auth', 'uses' => 'GiftController@destroy']);

## PRODUCTS ##
Route::get('/products/search', ['middleware' => 'auth', 'uses' => 'ProductController@search']);
Route::get('/products/sale', ['middleware' => 'auth', 'uses' => 'ProductController@index_sale']);
Route::get('/products/open-po', ['middleware' => 'auth', 'uses' => 'ProductController@index_open_po']);
Route::get('/products/stock-opname', ['middleware' => 'auth', 'uses' => 'ProductController@index_stock']);
Route::get('/products/stock-opname-page', ['middleware' => 'auth', 'uses' => 'ProductController@index_stock_page']);
Route::get('/products/stock-opname/search', ['middleware' => 'auth', 'uses' => 'ProductController@index_stock_search']);
Route::post('/products/stock-opname/update', ['middleware' => 'auth', 'uses' => 'ProductController@stock_update']);
Route::get('/products/stock-seller', ['middleware' => 'auth', 'uses' => 'ProductController@index_stock_seller']);

Route::post('/seller-stocks/update/{id}', ['middleware' => 'auth', 'uses' => 'SellerStockController@update']);
Route::post('/seller-stocks/new', ['middleware' => 'auth', 'uses' => 'SellerStockController@store']);
Route::get('/user/seller-stocks', ['middleware' => 'auth', 'uses' => 'SellerStockController@index_user']);

Route::get('/products', ['middleware' => 'auth', 'uses' => 'ProductController@index']);
Route::get('/products/new', ['middleware' => 'auth', 'uses' => 'ProductController@create']);
Route::get('/products/copy/{id}', ['middleware' => 'auth', 'uses' => 'ProductController@create_copy']);
Route::post('/products/new', ['middleware' => 'auth', 'uses' => 'ProductController@store']);
Route::get('/products/{id}', ['middleware' => 'auth', 'uses' => 'ProductController@show']);
Route::get('/products/edit/{id}', ['middleware' => 'auth', 'uses' => 'ProductController@edit']);
Route::post('/products/edit/{id}', ['middleware' => 'auth', 'uses' => 'ProductController@update']);
Route::delete('/products/delete/{id}', ['middleware' => 'auth', 'uses' => 'ProductController@destroy']);

Route::post('/products/get_product_price', ['middleware' => 'auth', 'uses' => 'ProductController@get_product_price']);

//Route::post('/products/search', ['middleware' => 'auth', 'uses' => 'ProductController@search']);


## USERS ##
Route::get('/members', ['middleware' => 'auth', 'uses' => 'MemberController@index']);
Route::get('/members/new', ['middleware' => 'auth', 'uses' => 'MemberController@create']);
Route::post('/members/new', ['middleware' => 'auth', 'uses' => 'MemberController@store']);
Route::get('/members/{id}', ['middleware' => 'auth', 'uses' => 'MemberController@show']);
Route::get('/members/edit/{id}', ['middleware' => 'auth', 'uses' => 'MemberController@edit']);
Route::post('/members/edit/{id}', ['middleware' => 'auth', 'uses' => 'MemberController@update']);
Route::delete('/members/delete/{id}', ['middleware' => 'auth', 'uses' => 'MemberController@destroy']);

Route::get('/users', ['middleware' => 'auth', 'uses' => 'UserController@index']);
Route::get('/users/new', ['middleware' => 'auth', 'uses' => 'UserController@create']);
Route::post('/users/new', ['middleware' => 'auth', 'uses' => 'UserController@store']);
Route::get('/users/{id}', ['middleware' => 'auth', 'uses' => 'UserController@show']);
Route::get('/users/edit/{id}', ['middleware' => 'auth', 'uses' => 'UserController@edit']);
Route::post('/users/edit/{id}', ['middleware' => 'auth', 'uses' => 'UserController@update']);
Route::delete('/users/delete/{id}', ['middleware' => 'auth', 'uses' => 'UserController@destroy']);

Route::post('/users/get_user_info', ['middleware' => 'auth', 'uses' => 'UserController@get_user_info']);

Route::get('/user', ['middleware' => 'auth', 'uses' => 'UserController@my_account_show']);
Route::get('/user/stock', ['middleware' => 'auth', 'uses' => 'UserController@user_stock']);

## COURIER ##
Route::get('/couriers', ['middleware' => 'auth', 'uses' => 'CourierController@index']);
Route::get('/couriers/new', ['middleware' => 'auth', 'uses' => 'CourierController@create']);
Route::post('/couriers/new', ['middleware' => 'auth', 'uses' => 'CourierController@store']);
//Route::get('/couriers/{id}', ['middleware' => 'auth', 'uses' => 'CourierController@show']);
Route::get('/couriers/edit/{id}', ['middleware' => 'auth', 'uses' => 'CourierController@edit']);
Route::post('/couriers/edit/{id}', ['middleware' => 'auth', 'uses' => 'CourierController@update']);
Route::delete('/couriers/delete/{id}', ['middleware' => 'auth', 'uses' => 'CourierController@destroy']);

Route::get('/couriers/deactivate/{id}', ['middleware' => 'auth', 'uses' => 'CourierController@deactivate']);
Route::get('/couriers/activate/{id}', ['middleware' => 'auth', 'uses' => 'CourierController@activate']);

## SUPPLIER ##
Route::get('/suppliers', ['middleware' => 'auth', 'uses' => 'SupplierController@index']);
Route::get('/suppliers/new', ['middleware' => 'auth', 'uses' => 'SupplierController@create']);
Route::post('/suppliers/new', ['middleware' => 'auth', 'uses' => 'SupplierController@store']);
Route::get('/suppliers/edit/{id}', ['middleware' => 'auth', 'uses' => 'SupplierController@edit']);
Route::post('/suppliers/edit/{id}', ['middleware' => 'auth', 'uses' => 'SupplierController@update']);
Route::delete('/suppliers/delete/{id}', ['middleware' => 'auth', 'uses' => 'SupplierController@destroy']);

## REPORTS ##
Route::get('/reports', ['middleware' => 'auth', 'uses' => 'ReportController@index']);
Route::get('/reports/sales', ['middleware' => 'auth', 'uses' => 'ReportController@sales']);
Route::post('/reports/sales', ['middleware' => 'auth', 'uses' => 'ReportController@monthly_sales']);
Route::get('/reports/sales/pdf/{year}/{month}', ['middleware' => 'auth', 'uses' => 'ReportController@sales_pdf']);

## MEMBER AREA ##
## PRODUCTS ##
Route::get('/member/gifts', ['middleware' => 'auth', 'uses' => 'MemberProductController@gifts']);
Route::get('/member/sale', ['middleware' => 'auth', 'uses' => 'MemberProductController@sale']);
Route::get('/member/top-up', ['middleware' => 'auth', 'uses' => 'TopUpController@top_up']);

//Route::get('/member/products/{type}', ['middleware' => 'auth', 'uses' => 'MemberProductController@product_list']);
Route::get('/member/products/new', ['middleware' => 'auth', 'uses' => 'MemberProductController@new_products']);
Route::get('/member/products/restock', ['middleware' => 'auth', 'uses' => 'MemberProductController@restock_products']);
Route::get('/member/products/empty', ['middleware' => 'auth', 'uses' => 'MemberProductController@empty_stock_products']);
Route::get('/member/products/open-po', ['middleware' => 'auth', 'uses' => 'MemberProductController@open_po']);

Route::get('/member/products/search', ['middleware' => 'auth', 'uses' => 'MemberProductController@search']);

//Route::get('/member/products', ['middleware' => 'auth', 'uses' => 'MemberProductController@index']);
Route::get('/member/products/{id}', ['middleware' => 'auth', 'uses' => 'MemberProductController@show']);
Route::post('/member/products/add_to_cart', ['middleware' => 'auth', 'uses' => 'MemberProductController@addToCart']);

## SHOPPING CART ##
Route::get('/member/cart', ['middleware' => 'auth', 'uses' => 'MemberShoppingCartController@index']);
Route::delete('/member/cart/delete/{id}', ['middleware' => 'auth', 'uses' => 'MemberShoppingCartController@destroy']);
Route::post('/member/cart/update/{id}', ['middleware' => 'auth', 'uses' => 'MemberShoppingCartController@update']);

## SHOPPING CART PO ##
Route::get('/member/cart-po', ['middleware' => 'auth', 'uses' => 'MemberShoppingCartController@index_po']);
Route::delete('/member/cart-po/delete/{id}', ['middleware' => 'auth', 'uses' => 'MemberShoppingCartController@destroy_po']);
Route::post('/member/cart-po/update/{id}', ['middleware' => 'auth', 'uses' => 'MemberShoppingCartController@update_po']);


## PURCHASING CART ADMIN ##
Route::get('/admin/cart', ['middleware' => 'auth', 'uses' => 'PurchasingCartController@index']);
Route::post('/admin/cart/add', ['middleware' => 'auth', 'uses' => 'PurchasingCartController@ajax_add_product']);

## SALES ##
Route::post('/member/sales/new', ['middleware' => 'auth', 'uses' => 'SalesController@store']);
Route::get('/member/sales', ['middleware' => 'auth', 'uses' => 'SalesController@index_member']);
Route::get('/member/sales/{id}', ['middleware' => 'auth', 'uses' => 'SalesController@show_member']);

Route::post('/member/sales/new-po', ['middleware' => 'auth', 'uses' => 'SalesController@store_po']);

Route::get('/sales/cancel', ['middleware' => 'auth', 'uses' => 'SalesController@index_cancel']);
Route::get('/sales/all', ['middleware' => 'auth', 'uses' => 'SalesController@index_all']);
//Route::get('/sales/cancel/search', ['middleware' => 'auth', 'uses' => 'SalesController@search_cancel']);
//Route::get('/sales/all/search', ['middleware' => 'auth', 'uses' => 'SalesController@search_all']);

Route::post('/sales/status/update', ['middleware' => 'auth', 'uses' => 'SalesController@status_update']);

Route::get('/sales', ['middleware' => 'auth', 'uses' => 'SalesController@index']);
Route::get('/sales/new', ['middleware' => 'auth', 'uses' => 'SalesController@create']);
Route::post('/sales/new', ['middleware' => 'auth', 'uses' => 'SalesController@store']);
Route::get('/sales/search', ['middleware' => 'auth', 'uses' => 'SalesController@search']);
Route::get('/sales/{mode}/search', ['middleware' => 'auth', 'uses' => 'SalesController@search']);
Route::post('/sales/edit/{id}', ['middleware' => 'auth', 'uses' => 'SalesController@update']);
Route::get('/sales/{id}', ['middleware' => 'auth', 'uses' => 'SalesController@show']);
Route::post('/sales/status/{id}', ['middleware' => 'auth', 'uses' => 'SalesController@updateStatus']);
Route::get('/sales/label/{id}', ['middleware' => 'auth', 'uses' => 'SalesController@printLabel']);
Route::get('/sales/print/invoice/{id}', ['middleware' => 'auth', 'uses' => 'SalesController@printInvoice']);

## PAYMENTS ##
Route::get('/payments', ['middleware' => 'auth', 'uses' => 'PaymentController@index']);
Route::get('/payments/paid', ['middleware' => 'auth', 'uses' => 'PaymentController@index_paid']);
Route::get('/payments/unpaid', ['middleware' => 'auth', 'uses' => 'PaymentController@index_unpaid']);
Route::post('/payments/status/update', ['middleware' => 'auth', 'uses' => 'PaymentController@status_update']);
Route::get('/payments/search', ['middleware' => 'auth', 'uses' => 'PaymentController@search']);
Route::get('/payments/paid/search', ['middleware' => 'auth', 'uses' => 'PaymentController@search_paid']);
Route::get('/payments/unpaid/search', ['middleware' => 'auth', 'uses' => 'PaymentController@search_unpaid']);

## PRINT ##
Route::get('/prints/invoice', ['middleware' => 'auth', 'uses' => 'PrintController@bulk_invoice']);
Route::get('/prints/deliverylabel', ['middleware' => 'auth', 'uses' => 'PrintController@bulk_delivery_label']);

## TOP-UP ##
Route::get('/top-ups', ['middleware' => 'auth', 'uses' => 'TopUpController@index']);
Route::post('/top-ups/status/update', ['middleware' => 'auth', 'uses' => 'TopUpController@status_update']);
Route::post('/top-ups/new', ['middleware' => 'auth', 'uses' => 'TopUpController@store_member_top_up']);

## TEST ##
//Route::get('/test', ['middleware' => 'auth', 'uses' => 'TestController@index']);
//Route::post('/test', ['middleware' => 'auth', 'uses' => 'MemberProductController@addToCart']);
