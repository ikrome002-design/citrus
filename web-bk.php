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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/**
 * Admin routes
 */
//Route::get('/send-email', [MailController::class, 'sendEmail']);
Route::get('/send-email', 'MailController@sendEmail');
Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::get('staff/login', 'LoginController@showLoginForm')->name('staff.login');
    Route::get('subadmin/login', 'LoginController@subadminLoginForm')->name('subadmin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::post('admin/staff_login', 'LoginController@staff_login')->name('admin.staff_login');
    Route::post('admin/subadmin_login', 'LoginController@subadmin_login')->name('admin.subadmin_login');
    Route::post('admin/dashboard', 'RegisterController@reply_msg')->name('admin.reply.msg');
    Route::post('subadmin/dashboard', 'RegisterController@reply_msg')->name('subadmin.reply.msg');
    Route::get('admin/messages', 'VendorController@msg')->name('admin.vendors.messages');

    Route::get('admin/subadmin/messages', 'VendorController@msg')->name('subadmin.vendors.messages');
    Route::get('admin/admin_notification', 'VendorController@admin_notification')->name('admin.admin_notification');
    Route::get('admin/subadmin/admin_notification', 'VendorController@admin_notification')->name('subadmin.admin_notification');
    Route::post('admin/vendors/updatevendorlist', 'VendorController@updatevendorlist')->name('admin.vendors.updatevendorlist');
    Route::post('admin/vendors/create1', 'VendorController@create1')->name('admin.vendors.create1');
    Route::post('admin/vendors/chooseplan', 'VendorController@chooseplan')->name('admin.vendors.chooseplan');

    Route::get('admin/password/reset', 'LoginController@ResetPasswordForm')->name('admin.resetpassword');
    Route::post('admin/password/reset', 'LoginController@ResetPassword')->name('admin.resetpassword');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
    Route::get('staff/logout', 'LoginController@staff_logout')->name('staff.logout');
    Route::get('subadmin/logout', 'LoginController@subadmin_logout')->name('subadmin.logout');

    Route::post('admin/transReport', 'ReportController@admin_gen_trans_report')->name('admin.transReport');
    Route::get('admin/subAdmin/create', 'EmployeeController@subadmin_create')->name('subadmin.subadmin_create');
    Route::get('admin/subAdmin/list', 'EmployeeController@subadmin_index')->name('subadmin.subadmin_index');
    Route::get('admin/subAdmin/{id}/show', 'EmployeeController@subadmin_show')->name('subadmin.show');

    Route::get('admin/subAdmin/{id}/edit', 'EmployeeController@subadmin_edit')->name('subadmin.edit');

    Route::post('admin/subAdmin/{id}/update', 'EmployeeController@subadmin_update')->name('subadmin.update');
    Route::put('admin/subAdmin/{id}/update', 'EmployeeController@subadmin_update')->name('subadmin.update');

    Route::delete('admin/subAdmin/destroy/{id}', 'EmployeeController@subadmin_destroy')->name('subadmin.destroy');
    Route::post('admin/subAdmin/store', 'EmployeeController@subadmin_store')->name('subadmin.store');
});

Route::namespace('Vendor')->group(function () {
    Route::get('merchant/login', 'LoginController@showVendorLoginForm')->name('vendor.login');
    Route::post('merchant/login', 'LoginController@login')->name('vendor.login');

    Route::post('vendor/dashboard', 'RegisterController@send_msg')->name('vendor.add.msg');
    Route::get('vendor/register', 'RegisterController@showVendorRegister')->name('vendor.register');
    Route::get('vendor/register/form/{id}', 'RegisterController@showVendorRegisterForm')->name('vendor.register.form');
    Route::get('vendor/register/payment', 'RegisterController@VendorRegisterPayment')->name('vendor.register.payment');
    Route::post('vendor/register/payment', 'RegisterController@VendorRegisterPaymentProcess')->name('vendor.register.payment');
    Route::post('vendor/register/contact', 'RegisterController@VendorRegisterContact')->name('vendor.register.contact');
    Auth::routes(['verify' => true]);
    Route::post('vendor/register', 'RegisterController@register')->name('vendor.register');
    Route::post('vendor/create-account', 'RegisterController@create_account')->name('vendor.create-account');
    Route::get('merchant/otp', 'RegisterController@send_otp')->name('otp');
    Route::post('merchant/otp', 'RegisterController@verify_otp')->name('otp');
    Route::get('merchant/verify-email', 'RegisterController@verify_email')->name('verify-email');
    Route::post('merchant/verify-email', 'RegisterController@verification')->name('verify-email');
    Route::get('register/confirm/resend/{id}', 'ResendVerificationController@resendVerification');
    //Route::get('register/confirm/resend/{id}','Auth\ResendVerification@resendVerification');
    Route::get('vendor/password/reset', 'LoginController@ResetPasswordForm')->name('vendor.resetpassword');
    Route::post('vendor/password/reset', 'LoginController@ResetPassword')->name('vendor.resetpassword');
    Route::get('vendor/logout', 'LoginController@logout')->name('vendor.logout');
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
    Route::namespace('Admin')->group(function () {
        //Permisstion for superadmin
        Route::group(['middleware' => ['role:superadmin, guard:employee']], function () {

            Route::resource('banners', 'HomePageSetting\BannerController');
            Route::get('banners/approve/{id}', 'HomePageSetting\BannerController@approve')->name('banners.approve');
            Route::get('banners/unapprove/{id}', 'HomePageSetting\BannerController@unapprove')->name('banners.unapprove');
            Route::resource('features', 'HomePageSetting\FeatureController');
            Route::get('features/approve/{id}', 'HomePageSetting\FeatureController@approve')->name('features.approve');
            Route::get('features/unapprove/{id}', 'HomePageSetting\FeatureController@unapprove')->name('features.unapprove');
            Route::resource('blog', 'Blog\BlogController');
            Route::resource('testimonial', 'Testimonial\TestimonialController');




            Route::namespace('Products')->group(function () {
                Route::resource('products', 'ProductController');
                Route::get('remove-image-product', 'ProductController@removeImage')->name('product.remove.image');
                Route::get('remove-image-thumb', 'ProductController@removeThumbnail')->name('product.remove.thumb');
                Route::get('approve/{id}', 'ProductController@productApprove')->name('products.update.approve');
                Route::get('unapprove/{id}', 'ProductController@productUnapprove')->name('products.update.unapprove');
            });
            /*Excel import export*/
            Route::get('export', 'ImportExportController@export')->name('export');
            Route::get('import', 'ImportExportController@importExportView')->name('import');
            Route::post('import', 'ImportExportController@import')->name('import');

            Route::namespace('Orders')->group(function () {
                Route::resource('orders', 'OrderController');
                Route::resource('order-status', 'OrderStatusController');
                Route::get('orders/{id}/invoice', 'OrderController@generateInvoice')->name('orders.invoice.generate');
                Route::get('order/transaction_report', 'OrderController@transaction')->name('orders.transaction_report');
                Route::get('orders/transaction_reportt/{id}', 'OrderController@vendortransactionn')->name('orders.transaction_reportt');

                //Route::get('order/transactionHistory', 'OrderController@transactionHistory')->name('orders.transactionHistory');
                Route::get('order/transaction-History', 'OrderController@transactionHistory')->name('orders.transaction-History');
                Route::get('orders/transaction-Historyy/{id}', 'OrderController@transactionHistoryy')->name('orders.transaction-Historyy');


                Route::get('orders/transaction_reportt/{id}/release', 'OrderController@releaseAmount')->name('release_amount');
            });
            Route::resource('product_reviews', 'ProductRatings\ProductRatingController');
            Route::namespace('Categories')->group(function () {
                Route::resource('categories', 'CategoryController');
                Route::get('remove-image-category', 'CategoryController@removeImage')->name('category.remove.image');



                Route::get('categories/type/{id}', 'CategoryController@type')->name('categories.type');
                Route::get('business_type/create', 'CategoryController@business_type_create')->name('business_type.create');
                Route::post('business_type/store', 'CategoryController@business_type_store')->name('business_type.store');
                Route::get('business_type/list', 'CategoryController@business_type_index')->name('business_type.index');

                Route::get('business_type/edit/{id}', 'CategoryController@business_type_edit')->name('business_type.edit');
                Route::delete('business_type/destroy/{id}', 'CategoryController@business_type_destroy')->name('business_type.destroy');
                Route::put('business_type/update/{id}', 'CategoryController@business_type_update')->name('business_type.update');
            });

            Route::resource('attributes', 'Attributes\AttributeController');
            Route::resource('attributes.values', 'Attributes\AttributeValueController');
            Route::resource('brands', 'Brands\BrandController');
            Route::resource('footers', 'Footers\FooterController');


            // Route::resource('productratings', 'ProductRatings\ProductRatingController');
            Route::resource('product_reviews', 'ProductRatings\ProductRatingController');
            Route::get('productratings/approve/{id}', 'ProductRatings\ProductRatingController@productRatingApprove')->name('productratings.update.approve');
            Route::get('productratings/unapprove/{id}', 'ProductRatings\ProductRatingController@productRatingUnapprove')->name('productratings.update.unapprove');

            Route::post('productratings/multipleapprove', 'ProductRatings\ProductRatingController@productRatingMultipleApprove')->name('productratings.multipleapprove');

            Route::post('productratings/multipleunapprove', 'ProductRatings\ProductRatingController@productRatingMultipleUnpprove')->name('productratings.multipleunapprove');

            Route::get('productratings/destroy/{id}', 'ProductRatings\ProductRatingController@destroy')->name('productratings.destroy');
        });
        Route::get('/staff', 'DashboardController@staff_index')->name('staff_dashboard');
        Route::get('/subadmin', 'DashboardController@index')->name('subadmin_dashboard');

        Route::get('/staff/profile', 'EmployeeController@staff_profile')->name('staff_profile');
        Route::get('/subadmin/profile', 'EmployeeController@staff_profile')->name('subadmin_profile');
        Route::get('/staff/customer', 'Customers\CustomerController@customer_index')->name('customers.list');

        Route::post('/staff/customer', 'Customers\CustomerController@customer_index')->name('customers.list');
        Route::get('/staff/customer/create', 'Customers\CustomerController@customer_create')->name('customers.create_customer');
        Route::post('/staff/customer/create', 'Customers\CustomerController@customer_create')->name('customers.create_customer');
        Route::post('/staff/customer-account', 'RegisterController@customer_account')->name('customer-account');
        Route::get('/staff/customer/{id}', 'Customers\CustomerController@show_customer')->name('customers.show_customer');
        Route::get('/customer/{id}', 'Customers\CustomerController@show_customer')->name('customers.show_customers');
        Route::put('/staff/profile', 'EmployeeController@staffUpdateProfile')->name('staffs.profile.staff_update');
        Route::put('/subadmin/profile', 'EmployeeController@staffUpdateProfile')->name('subadmin.profile.subadmin_update');


        //Permisstion for superadmin|staff
        Route::group(['middleware' => ['role:superadmin|staff|admin|subadmin, guard:employee']], function () {

            Route::get('/', 'DashboardController@index')->name('dashboard');


            Route::post('/vendors/add', 'VendorController@vendoradd')->name('vendors.add');

            Route::get('/clients', 'VendorController@clients')->name('manage.client');
            Route::get('/clients/{id}/show', 'VendorController@clientShow')->name('client.show');
            Route::get('/clients/{id}/edit', 'VendorController@clientEdit')->name('client.edit');
            Route::post('/clients/{id}/update', 'VendorController@clientUpdate')->name('client.update');
            Route::post('/vendors/add', 'VendorController@vendoradd')->name('vendors.add');
            Route::get('profile', 'EmployeeController@getProfile')->name('staffs.profile');

            Route::put('profile', 'EmployeeController@updateProfile')->name('staffs.profile.update');
            Route::get('/staffVendorCreate', 'VendorController@staffVendorCreate')->name('staff.staffVendorCreate');
            Route::post('/staffVendorSave', 'VendorController@staffVendorSave')->name('staff.staffVendorSave');
            Route::post('/staffVendorAdd', 'VendorController@staffVendorAdd')->name('staff.staffVendorAdd');
            Route::get('/staffVendorList', 'VendorController@staffVendorList')->name('staff.staffVendorList');
            Route::get('/staffVendorShow/{id}', 'VendorController@staffVendorShow')->name('staff.staffVendorShow');
            Route::post('/staff/updateStaffVendorList', 'VendorController@updateStaffVendorList')->name('staff.updateStaffVendorList');
        });

        Route::resource('vendors', 'VendorController');
        Route::get('merchant/list', 'VendorController@index')->name('merchant.list');
        Route::get('merchant/show/{id}', 'VendorController@show')->name('merchant.show');
        Route::get('vendors/{id}/profile', 'VendorController@getProfile')->name('profile');
        Route::put('vendors/{id}/profile', 'VendorController@updateProfile')->name('profile.update');
        Route::get('vendors/approve/{id}', 'VendorController@vendorApprove')->name('vendors.update.approve');
        Route::get('vendors/unapprove/{id}', 'VendorController@vendorUnapprove')->name('vendors.update.unapprove');

        //Permisstion for superadmin
        Route::group(['middleware' => ['role:superadmin, guard:employee']], function () {
            Route::resource('staffs', 'EmployeeController');
            Route::resource('roles', 'Roles\RoleController');
            Route::resource('permissions', 'Permissions\PermissionController');
            //Route::post('staffs/{id}/edit', 'EmployeeController@update')->name('admin.staffs.update');
            // Route::post('admin/vendors/choose', 'VendorController@chooseplan')->name('admin.vendors.create1');
            Route::get('users/approve/{id}', 'EmployeeController@employeeApprove')->name('staffs.update.approve');
            Route::get('users/unapprove/{id}', 'EmployeeController@employeeUnapprove')->name('staffs.update.unapprove');

            Route::resource('addresses', 'Addresses\AddressController');

            Route::resource('countries', 'Countries\CountryController');

            Route::resource('memberships', 'Memberships\MembershipController');
            Route::resource('taxes', 'Taxes\TaxController');
            Route::resource('membershipvarient', 'MembershipVarients\MembershipVarientController');

            Route::resource('countries.provinces', 'Provinces\ProvinceController');
            Route::resource('countries.provinces.cities', 'Cities\CityController');
            Route::resource('couriers', 'Couriers\CourierController');

            Route::namespace('Customers')->group(function () {
                Route::resource('customers', 'CustomerController');
                Route::resource('customers.addresses', 'CustomerAddressController');
            });

            Route::namespace('Subscription plan')->group(function () {
                Route::resource('subscription', 'SubscriptionController');
            });
        });
    });
});

/**
 * Frontend routes
 */

Auth::routes(['verify' => true]);
Route::namespace('Auth')->group(function () {

    // Route::get('/verify-email', [EmailVerificationController::class, 'show'])
    // ->middleware('auth')
    // ->name('verification.notice');

    Route::get('/email/verify', function () {
        return view('auth.verify-customer');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', 'RegisterController@verification')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return redirect('login')->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('cart/login', 'CartLoginController@showLoginForm')->name('cart.login');
    Route::post('cart/login', 'CartLoginController@login')->name('cart.login');
    Route::post('product/add_review', 'ProductController@add_review')->name('product.review');
    Route::get('logout', 'LoginController@logout');
    Route::get('emailVerifyByUser/{Id}', 'RegisterController@emailVerifyByUser')->name('register.emailVerifyByUser');
    Route::post('ResetPasswordUser', 'LoginController@ResetPasswordUser')->name('ResetPasswordUser');
    Route::post('account-type', 'RegisterController@account_type')->name('account-type');
    Route::get('account-type', 'RegisterController@account_type')->name('account-type');
    Route::post('create-account-form', 'RegisterController@create_account_form')->name('create-account-form');
    Route::get('create-account-form', 'RegisterController@create_account_form')->name('create-account-form');

    Route::post('customer-account', 'RegisterController@customer_account')->name('customer-account');
    Route::get('customer-account', 'RegisterController@customer_account')->name('customer-account');
    Route::get('customer-info', 'LoginController@customer_info')->name('customer-info');
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
        Route::get('checkout/execute', 'CheckoutController@executePayPalPayment')->name('checkout.execute');
        Route::post('checkout/execute', 'CheckoutController@charge')->name('checkout.execute');
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


Route::namespace('Admin')->group(function () {
    Route::middleware(['vendor'])->group(function () {
        // Route::get("vendor/report", function(){
        //     return View::make("vendor.report");
        // })->name('vendor.report');

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