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

use Illuminate\Support\Facades\Route;


Route::namespace('Merchant')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@LoginForm')->name('merchant.login');
        Route::post('/login', 'LoginController@postData')->name('merchant.login.post');
        Route::get('/register', 'RegisterController@showForm')->name('merchant.register.get');
        Route::post('/register', 'RegisterController@register')->name('merchant.register.post');
    });
    Route::middleware('merchant')->group(function () {
        Route::get('/register/merchant', 'RegisterMerchantController@registerForm')->name('merchant.register.signed');
        Route::get('/dashboard', 'MerchantDashboardController@index')->name('merchant.dashboard');
        Route::get('/logout', 'MerchantDashboardController@index')->name('vendor.logout');
        Route::get('vendor/report', 'ReportController@index')->name('vendor.report');
        Route::get('vendor/pdfview', array('as' => 'pdfview', 'uses' => 'ReportController@pdfview'));
        Route::post('vendor/pdfview', 'ReportController@search')->name('vendor.pdfview');
        Route::post('vendor/transReport', 'ReportController@gen_trans_report')->name('vendor.transReport');
        // Route::get('vendor/pdfview',array('as'=>'pdfview','uses'=>'ReportController@pdfview'));
        Route::get('merchant/profile', 'VendorController@getProfile')->name('vendor.profile');
        Route::get('merchant/shops/{id}/profile', 'VendorController@getProfile')->name('vendor.shop_profile');
        Route::put('merchant/profile', 'VendorController@updateProfile')->name('vendor.profile.update');
        Route::get('merchant/dashboard', 'VendorDashboardController@index')->name('vendor.dashboard');
        Route::get('merchant/package/{id}', 'VendorDashboardController@package')->name('vendor.package');
        Route::get('merchant/shops/{id}/dashboard', 'VendorDashboardController@shop_index')->name('shop.dashboard');


        //Route::get('vendor/msg', 'VendorDashboardController@index')->name('vendor.msg');
        //Route::get('vendor/vendormsg', 'VendorController@vendormsg')->name('vendor.vendormsg');

        Route::get('vendor/message', 'VendorDashboardController@index')->name('vendor.msg');
        Route::get('merchant/messages', 'VendorController@vendormsg')->name('vendor.vendor_messages');
        Route::get('merchant/notification', 'VendorController@notification')->name('vendor.notification');


        Route::get('merchant/settings', 'VendorController@settings')->name('vendor.settings');
        Route::post('merchant/updatesetting', 'VendorController@updatesetting')->name('vendor.updatesetting');
        Route::post('merchant/updatebilling', 'VendorController@updatecontact')->name('vendor.updatecontact');
        Route::post('merchant/updateaccount', 'VendorController@updateaccount')->name('vendor.updateaccount');
        Route::post('merchant/updatecanadian_post', 'VendorController@updateCompanyOverview')->name('vendor.updateCompanyOverview');
        Route::post('merchant/updateprofile_detail', 'VendorController@updateprofile_detail')->name('vendor.updateprofile_detail');
        Route::post('merchant/updategallery_detail', 'VendorController@updategallery_detail')->name('vendor.updategallery_detail');
        Route::get('merchant/gallery/destroy/{id}', 'VendorController@gallery_destroy')->name('vendor.gallery_destroy');

        Route::get('vendor/ratings', 'ProductRatings\ProductRatingController@getRatings')->name('vendor.ratings');
        Route::get('vendor/vendor_ratings', 'ProductRatings\ProductRatingController@getVendorRatings')->name('onlyvendor.ratings');
        Route::get('vendor/plan', 'VendorController@getPlan')->name('vendor.plan');
        Route::post('vendor/updateplan', 'VendorController@updateplan')->name('vendor.updateplan');
        Route::get('vendor/searchratings', 'ProductRatings\ProductRatingController@searchratings')->name('vendor.searchratings');


        Route::get('vendor/vendor_plan_stripe', 'VendorStripePlanController@stripe');
        Route::post('vendor/vendor_plan_stripe', 'VendorStripePlanController@vendor_planStripePost')->name('vendor_plan_stripe.post');
        //Route::resource('merchant/staffs', 'VendorDashboardController');
        Route::put('merchant/staffs/{id}/update', 'VendorDashboardController@update')->name('staffs.update');
        Route::get('merchant/staffs/{id}/edit', 'VendorDashboardController@edit')->name('staffs.edit');
        Route::get('merchant/shops/{shopId}/staffs/{employeeId}/edit', 'VendorDashboardController@shop_edit')->name('staffs.shop_edit');
        Route::delete('merchant/staffs/{id}/destroy', 'VendorDashboardController@destroy')->name('staffs.destroy');

        Route::get('merchant/staffs/create', 'VendorDashboardController@create')->name('staffs.create');
        Route::get('merchant/shops/{id}/staffs/create', 'VendorDashboardController@create')->name('staffs.shop_create');
        Route::post('merchant/staffs/store', 'VendorDashboardController@store')->name('staffs.store');
        Route::get('merchant/staffs/staff_index', 'VendorDashboardController@staff_index')->name('staffs.staff_index');
        Route::get('merchant/shops/{id}/staffs/staff_index', 'VendorDashboardController@shop_staff_index')->name('staffs.shop_staff_index');
        Route::get('merchant/users/approve/{id}', 'VendorDashboardController@employeeApprove')->name('staffs.update.approve');
        Route::get('merchant/users/unapprove/{id}', 'VendorDashboardController@employeeUnapprove')->name('staffs.update.unapprove');
        Route::get('merchant/products', 'Products\ProductController@productlist')->name('products.index');
        Route::get('merchant/shops/{id}/products', 'Products\ProductController@shop_productlist')->name('products.shop_index');
        Route::post('CategoryListingFilter', 'Products\ProductController@CategoryListingFilter')->name('CategoryListingFilter');


        Route::get('merchant/products/create', 'Products\ProductController@productlist_create')->name('products.create');
        Route::get('merchant/shops/{id}/products/create', 'Products\ProductController@shop_productlist_create')->name('products.shop_create');

        Route::get('merchant/customer', 'Customers\CustomerController@index')->name('customers.list');
        Route::post('merchant/customer', 'Customers\CustomerController@index')->name('customers.list');
        Route::get('merchant/customer/create', 'Customers\CustomerController@create')->name('customers.create');
        Route::get('merchant/customer/{id}', 'Customers\CustomerController@show')->name('customers.show');

        Route::get('merchant/shops/{id}/customer', 'Customers\CustomerController@index')->name('customers.shop_list');
        Route::post('merchant/shops/{id}/customer', 'Customers\CustomerController@index')->name('customers.shop_list');
        Route::get('merchant/shops/{id}/customer/create', 'Customers\CustomerController@create')->name('customers.shop_create');
        Route::get('merchant/shops/{shopId}/customer/{id}', 'Customers\CustomerController@show')->name('customers.shop_show');

        Route::get('merchant/customer/approve/{id}', 'Customers\CustomerController@customerApprove')->name('customers.update.approve');
        Route::get('merchant/customer/unapprove/{id}', 'Customers\CustomerController@customerUnapprove')->name('customers.update.unapprove');

        Route::get('merchant/shop/list', 'VendorController@shop_list')->name('shop.list');
        Route::get('merchant/shop/create', 'VendorController@shop_create')->name('shop.create');
        Route::post('merchant/shop/store', 'VendorController@shop_store')->name('shop.store');
        Route::get('merchant/shop/{id}/edit', 'VendorController@shop_edit')->name('shop.edit');
        Route::put('merchant/shop/{id}/edit', 'VendorController@shop_update')->name('shop.update');
        Route::delete('merchant/shop/destroy/{id}', 'VendorController@shop_destroy')->name('shop.destroy');

        Route::get('merchant/sociallink/list', 'VendorController@sociallink_list')->name('sociallink.list');
        Route::get('merchant/sociallink/create', 'VendorController@sociallink_create')->name('sociallink.create');
        Route::post('merchant/sociallink/store', 'VendorController@sociallink_store')->name('sociallink.store');
        Route::get('merchant/sociallink/{id}/edit', 'VendorController@sociallink_edit')->name('sociallink.edit');
        Route::put('merchant/sociallink/{id}/edit', 'VendorController@sociallink_update')->name('sociallink.update');
        Route::delete('merchant/sociallink/destroy/{id}', 'VendorController@sociallink_destroy')->name('sociallink.destroy');

        Route::post('merchant/products', 'Products\ProductController@product_store')->name('products.store');
        Route::get('merchant/products/{id}/edit', 'Products\ProductController@product_edit')->name('products.edit');
        Route::get('merchant/shops/{shopId}/products/{productId}/edit', 'Products\ProductController@shop_product_edit')->name('products.shop_edit');
        Route::put('merchant/products/{id}/edit', 'Products\ProductController@product_update')->name('products.update');
        Route::get('remove-image-product', 'Products\ProductController@removeImage')->name('product.remove.image');
        Route::get('vendor/remove-image-thumb', 'Products\ProductController@removeThumbnail')->name('product.remove.thumb');
        Route::get('approve/{id}', 'Products\ProductController@productApprove')->name('products.update.approve');
        Route::get('unapprove/{id}', 'Products\ProductController@productUnapprove')->name('products.update.unapprove');
        Route::post('merchant/products/destroyy', 'Products\ProductController@destroyy')->name('vendor.products.destroyy');


        Route::namespace('Orders')->group(function () {
            Route::get('vendor/orders/transaction_report', 'OrderController@vendortransaction')->name('vendor.orders.transaction_report');

            Route::get('merchant/orders/{id}/edit', 'OrderController@order_edit')->name('vendor.orders.edit');
            Route::put('merchant/orders/{id}/edit', 'OrderController@order_update')->name('vendor.orders.update');
            Route::get('merchant/orders/', 'OrderController@order_index')->name('vendor.orders.index');

            Route::get('merchant/shops/{shop_id}/orders/{id}/edit', 'OrderController@shop_order_edit')->name('shop.orders.edit');
            Route::put('merchant/shops/orders/{id}/edit', 'OrderController@shop_order_update')->name('shop.orders.update');
            Route::get('merchant/shops/{id}/orders/', 'OrderController@shop_order_index')->name('shop.orders.index');

            Route::get('vendor/orders/{id}', 'OrderController@showw')->name('vendor.orders.show');


            // Route::get('merchant/shops/{id}/orders/', 'OrderController@shop_orders')->name('vendor.orders.shop_orders');
            Route::resource('vendor/{{vendor_id}}/order-status', 'OrderStatusController');
            Route::get('merchant/{{shop_id}}/orders/{id}/invoice', 'OrderController@generateInvoice')->name('orders.invoice.generate');
        });
    });
});
