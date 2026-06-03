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


Route::get('/test', 'TestController@index');


/**
 * Frontend routes
 */

Route::namespace('Auth')->group(function () {
    Route::get('/forgot-password', 'ForgotPasswordController@viewForm')->name('password.request');
    Route::post('/forgot-password', 'ForgotPasswordController@postData')->name('password.email');
    Route::post('/change/password', 'ChangePasswordController@postData')->name('password.update');
    Route::get('/change/password', 'ChangePasswordController@viewForm')->name('password.reset');
    Route::get('/verify/email', 'VerifyEmailController@viewForm')->name('verification.notice');;
    Route::get('/email/verify/{id}/{hash}', 'VerifyEmailController@verifyEmail')->middleware('signed')->name('verification.verify');
    Route::post('/email/verification/notification', 'VerifyEmailController@resendLink')->middleware('throttle:6,1')->name('verification.send');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

Route::namespace('Customer')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('register', 'RegisterController@customer_account')->name('register');
        Route::get('login', 'LoginController@showLoginForm')->name('login.get');
        Route::post('cart/login', 'CartLoginController@login')->name('cart.login.post');
        Route::post('product/add_review', 'ProductController@add_review')->name('product.review');
        Route::get('logout', 'LoginController@logout');
        Route::get('emailVerifyByUser/{Id}', 'RegisterController@emailVerifyByUser')->name('register.emailVerifyByUser');
        Route::post('ResetPasswordUser', 'LoginController@ResetPasswordUser')->name('ResetPasswordUser');
        Route::post('create-account-form', 'RegisterController@create_account_form')->name('create-account-form.post');
        Route::get('create-account-form', 'RegisterController@create_account_form')->name('create-account-form.get');

        Route::post('customer-account', 'RegisterController@customer_account')->name('customer-account.post');
        Route::get('customer-account', 'RegisterController@customer_account')->name('customer-account.get');
        Route::get('customer-info', 'LoginController@customer_info')->name('customer-info');
    });
});

Route::namespace('Front')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('shipping_info', 'HomeController@shipping_info')->name('shipping_info');
    Route::get('return_policy', 'HomeController@return_policy')->name('return_policy');
    Route::get('internat_help', 'HomeController@internat_help')->name('internat_help');
    Route::get('accessibility', 'HomeController@accessibility')->name('accessibility');
    Route::get('mission', 'HomeController@mission')->name('mission');
    Route::get('terms_condition', 'HomeController@terms_condition')->name('terms_condition');
    Route::group(['middleware' => ['auth', 'web']], function () {

        Route::namespace('Payments')->group(function () {
            Route::get('bank-transfer', 'BankTransferController@index')->name('bank-transfer.index');
            Route::post('bank-transfer', 'BankTransferController@store')->name('bank-transfer.store');
            Route::get('cash-transfer', 'CashOnDelivController@index')->name('cash-transfer.index');
            Route::post('cash-transfer', 'CashOnDelivController@store')->name('cash-transfer.store');
        });

        Route::namespace('Addresses')->group(function () {
            Route::resource('country.state', 'CountryStateController');
            Route::resource('state.city', 'StateCityController');
        });


        Route::post('addreview', 'RatingController@index')->name('product.add.review');
        Route::post('addvendorreview', 'RatingController@vendorRating')->name('vendor.add.review');
        Route::get('accounts', 'AccountsController@index')->name('accounts');
        Route::get('merchant/detail/{id}', 'AccountsController@merchant_view')->name('merchant.view');
        Route::get('shopList', 'AccountsController@shop_list')->name('shop.listing');
        Route::get('shopList/search', 'AccountsController@action')->name('shop.action');
        Route::get('merchant/shop/{id}/products/search', 'AccountsController@product_action')->name('product.action');
        Route::get('merchant/shop/{shop_id}/product-detail/{id}', 'ProductController@show')->name('product.detail');

        Route::get('merchant/shop/{id}/products', 'AccountsController@product_list')->name('shop.products');

        Route::get('stripe', 'StripePaymentController@stripe');
        Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');

        Route::get('vendor_stripe', 'VendorStripePaymentController@stripe');
        Route::post('vendor_stripe', 'VendorStripePaymentController@vendor_stripePost')->name('vendor_stripe.post');
        Route::get('destroyAddress/{id}', 'AccountsController@destroyAddress')->name('destroyAddress');


        Route::get('track-order-details/{id}', 'AccountsController@track_order')->name('track-order-details');
        Route::put('accounts', 'AccountsController@updateProfile')->name('accounts.profile.update');
        Route::post('accounts', 'AccountsController@updatePassword')->name('accounts.profile.changepassword');
        Route::get('checkout', 'CheckoutController@index')->name('checkout.index');
        Route::get('checkout/{id}', 'CheckoutController@address_details')->name('checkout.address');
        Route::get('customer/orders/{id}/invoice', 'AccountsController@customerInvoice')->name('customer.invoice.generate');



        Route::get('addaddress', 'CustomerAddressController@checkoutAddress')->name('checkout.add_address');


        Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
        Route::get('checkout/execute', 'CheckoutController@executePayPalPayment')->name('checkout.execute.get');
        Route::post('checkout/execute', 'CheckoutController@charge')->name('checkout.execute.post');
        Route::get('checkout/cancel', 'CheckoutController@cancel')->name('checkout.cancel');
        Route::get('checkout/success', 'CheckoutController@success')->name('checkout.success');
        Route::resource('customer.address', 'CustomerAddressController');
    });

    Route::post('wishlist', 'WishlistController@index')->name('wishlist.save');

    Route::get('wishlist_detail', 'WishlistController@wishlist_details')->name('wishlist_detail');
    Route::get('wishlist_detail/{id}', 'WishlistController@wishlist_destroy')->name('wishlist_destroy');

    Route::post('contact-us', 'ContactUSController@contactUSPost')->name('contact.form');
    Route::get('contact-us', 'ContactUSController@index')->name('contact.list');
    Route::delete('contact-us/destroy/{id}', 'ContactUSController@contact_destroy')->name('contact.destroy');

    Route::post('newsletter', 'ContactUSController@store')->name('newsletter.store');

    Route::get('allbrands', 'BrandsController@index')->name('allbrands');
    Route::get('allvendors', 'VendorsController@index')->name('allvendors');
    Route::resource('cart', 'CartController');
    Route::get("category/{slug}", 'CategoryController@getCategory')->name('front.category.slug');




    Route::get("category/filter/{slug}", 'CategoryController@getCategoryFilter')->name('front.category.filter');
    Route::get("search", 'ProductController@search')->name('search.product');

    Route::get("search/filter", 'ProductController@searchFilter')->name('search.filter');
    Route::get("shop", 'ProductController@shop')->name('shop');
    Route::get("brand/{slug}", 'ProductController@brand')->name('brand');
    Route::get("brand/filter/{slug}", 'ProductController@brandFilter')->name('brand.filter');
    Route::get("shop/filter", 'ProductController@shopFilter')->name('shop.filter');
    Route::get("shop/price", 'ProductController@priceFilter')->name('price.filter');
    Route::get('searchratings', 'ProductController@searchFrontRating');
    Route::get("vendor-details/{id}", 'ProductController@show_vendor_product')->name('shop.vendor-details');
    Route::get("{product}", 'ProductController@show')->name('front.get.product');
});
