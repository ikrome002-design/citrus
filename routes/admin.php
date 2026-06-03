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


Route::namespace('Admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login.get');
        Route::post('admin/login', 'LoginController@login')->name('login.post');
    });
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::namespace('Plans')->group(function () {
            Route::resource('plans', 'PlanController')->names([
                'index' => 'plans.index',
                'create' => 'plans.create',
                'store' => 'plans.store',
                'show' => 'plans.show',
                'edit' => 'plans.edit',
                'update' => 'plans.update',
                'destroy' => 'plans.destroy',
            ]);

            Route::resource('accountTypes', 'AccountTypeController')->names([
                'index' => 'account.types.index',
                'create' => 'account.types.create',
                'store' => 'account.types.store',
                'show' => 'account.types.show',
                'edit' => 'account.types.edit',
                'update' => 'account.types.update',
                'destroy' => 'account.types.destroy',
            ]);
            Route::resource('backOfficePlans', 'backOfficePlanController')->names([
                'index' => 'back.office.plans.index',
                'create' => 'back.office.plans.create',
                'store' => 'back.office.plans.store',
                'show' => 'back.office.plans.show',
                'edit' => 'back.office.plan.sedit',
                'update' => 'back.office.plans.update',
                'destroy' => 'back.office.plans.destroy',
            ]);
            Route::resource('branchPlans', 'BranchPlanController')->names([
                'index' => 'branch.plans.index',
                'create' => 'branch.plans.create',
                'store' => 'branch.plans.store',
                'show' => 'branch.plans.show',
                'edit' => 'branch.plans.edit',
                'update' => 'branch.plans.update',
                'destroy' => 'branch.plans.destroy',
            ]);
            Route::resource('teamLinkPlans', 'TeamLinkPlanController')->names([
                'index' => 'team.link.plans.index',
                'create' => 'team.link.plans.create',
                'store' => 'team.link.plans.store',
                'show' => 'team.link.plans.show',
                'edit' => 'team.link.plans.edit',
                'update' => 'team.link.plans.update',
                'destroy' => 'team.link.plans.destroy',
            ]);
        });

        Route::namespace('Subscriptions')->group(function () {
            Route::resource('planSubscriptions', 'PlanSubcriptionController')->names([
                'index' => 'plan.subscriptions.index',
                'create' => 'plan.subscriptions.create',
                'store' => 'plan.subscriptions.store',
                'show' => 'plan.subscriptions.show',
                'edit' => 'plan.subscriptions.edit',
                'update' => 'plan.subscriptions.update',
                'destroy' => 'plan.subscriptions.destroy',
            ]);
            Route::resource('backOfficeSubscriptions', 'backOfficeSubscriptionController')->names([
                'index' => 'back.office.subscriptions.index',
                'create' => 'back.office.subscriptions.create',
                'store' => 'back.office.plansubscriptions.store',
                'show' => 'back.office.subscriptions..show',
                'edit' => 'back.office.subscriptions.edit',
                'update' => 'back.office.subscriptions.update',
                'destroy' => 'back.office.subscriptions.destroy',
            ]);
            Route::resource('branchSubscriptions', 'BranchSubscriptionPlanController')->names([
                'index' => 'branch.subscriptions.index',
                'create' => 'branch.subscriptions.create',
                'store' => 'branch.subscriptions.store',
                'show' => 'branch.subscriptions.show',
                'edit' => 'branch.subscriptions.edit',
                'update' => 'branch.subscriptions.update',
                'destroy' => 'branch.subscriptions.destroy',
            ]);
            Route::resource('teamLinkSubscriptions', 'TeamLinkSubscriptionController')->names([
                'index' => 'team.link.subscriptions.index',
                'create' => 'team.link.subscriptions.create',
                'store' => 'team.link.subscriptions.store',
                'show' => 'team.link.subscriptions.show',
                'edit' => 'team.link.subscriptions.edit',
                'update' => 'team.link.subscriptions.update',
                'destroy' => 'team.link.subscriptions.destroy',
            ]);
        });

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
        Route::get('import', 'ImportExportController@importExportView')->name('import.get');
        Route::post('import', 'ImportExportController@import')->name('import.post');

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

        Route::get('/staff', 'DashboardController@staff_index')->name('staff_dashboard');
        Route::get('/subadmin', 'DashboardController@index')->name('subadmin_dashboard');

        Route::get('/staff/profile', 'EmployeeController@staff_profile')->name('staff_profile');
        Route::get('/subadmin/profile', 'EmployeeController@staff_profile')->name('subadmin_profile');
        Route::get('/staff/customer', 'Customers\CustomerController@customer_index')->name('customers.list.get');

        Route::post('/staff/customer', 'Customers\CustomerController@customer_index')->name('customers.list.post');
        Route::get('/staff/customer/create', 'Customers\CustomerController@customer_create')->name('customers.create_customer.get');
        Route::post('/staff/customer/create', 'Customers\CustomerController@customer_create')->name('customers.create_customer.post');
        Route::post('/staff/customer-account', 'RegisterController@customer_account')->name('customer-account');
        Route::get('/staff/customer/{id}', 'Customers\CustomerController@show_customer')->name('customers.show_customer');
        Route::get('/customer/{id}', 'Customers\CustomerController@show_customer')->name('customers.show_customers');
        Route::put('/staff/profile', 'EmployeeController@staffUpdateProfile')->name('staffs.profile.staff_update');
        Route::put('/subadmin/profile', 'EmployeeController@staffUpdateProfile')->name('subadmin.profile.subadmin_update');

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


        Route::resource('vendors', 'VendorController');
        Route::get('merchant/list', 'VendorController@index')->name('merchant.list');
        Route::get('merchant/show/{id}', 'VendorController@show')->name('merchant.show');
        Route::get('vendors/{id}/profile', 'VendorController@getProfile')->name('profile');
        Route::put('vendors/{id}/profile', 'VendorController@updateProfile')->name('profile.update');
        Route::get('vendors/approve/{id}', 'VendorController@vendorApprove')->name('vendors.update.approve');
        Route::get('vendors/unapprove/{id}', 'VendorController@vendorUnapprove')->name('vendors.update.unapprove');

        //Permisstion for superadmin
        Route::group(['middleware' => ['role:superadmin, guard:admin']], function () {
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

            Route::post('dashboard', 'RegisterController@reply_msg')->name('reply.msg.post');
            Route::post('subadmin/dashboard', 'RegisterController@reply_msg')->name('reply.msg');
            Route::get('messages', 'VendorController@msg')->name('vendors.messages.get');

            Route::get('subadmin/messages', 'VendorController@msg')->name('vendors.messages');
            Route::get('admin_notification', 'VendorController@admin_notification')->name('admin_notification.get');
            Route::get('subadmin/admin_notification', 'VendorController@admin_notification')->name('admin_notification');
            Route::post('vendors/updatevendorlist', 'VendorController@updatevendorlist')->name('vendors.updatevendorlist');
            Route::post('vendors/create1', 'VendorController@create1')->name('vendors.create1');
            Route::post('vendors/chooseplan', 'VendorController@chooseplan')->name('vendors.chooseplan');


            Route::get('logout', 'LoginController@logout')->name('logout');
            Route::get('staff/logout', 'LoginController@staff_logout')->name('staff.logout');

            Route::post('transReport', 'ReportController@admin_gen_trans_report')->name('transReport');
            Route::get('subAdmin/create', 'EmployeeController@subadmin_create')->name('subadmin_create');
            Route::get('subAdmin/list', 'EmployeeController@subadmin_index')->name('subadmin_index');
            Route::get('subAdmin/{id}/show', 'EmployeeController@subadmin_show')->name('show');

            Route::get('subAdmin/{id}/edit', 'EmployeeController@subadmin_edit')->name('edit');

            Route::post('subAdmin/{id}/update', 'EmployeeController@subadmin_update')->name('update.post');
            Route::put('subAdmin/{id}/update', 'EmployeeController@subadmin_update')->name('update.put');

            Route::delete('subAdmin/destroy/{id}', 'EmployeeController@subadmin_destroy')->name('destroy');
            Route::post('subAdmin/store', 'EmployeeController@subadmin_store')->name('store');
        });
    });
});
