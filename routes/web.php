<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\FileUploadController;
use App\Http\Controllers\admin\PlanController;
use App\Http\Controllers\admin\PlanOrderController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\SitePrivilegeController;
use App\Http\Controllers\admin\StorePrivilegeController;
use App\Http\Controllers\admin\StoresController;
use App\Http\Controllers\admin\ThemeController as AdminThemeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\store\AddonsController;
use App\Http\Controllers\store\AdminsController;
use App\Http\Controllers\store\BrancheController;
use App\Http\Controllers\store\CouponsController;
use App\Http\Controllers\store\EditsController;
use App\Http\Controllers\store\ExpenseController;
use App\Http\Controllers\store\OrderController as StoreOrderController;
use App\Http\Controllers\store\PlanController as StorePlanController;
use App\Http\Controllers\store\ProductCategoriesController;
use App\Http\Controllers\store\ProductsController;
use App\Http\Controllers\store\SaucesController;
use App\Http\Controllers\store\SizeController;
use App\Http\Controllers\store\StoreAdminController;
use App\Http\Controllers\store\StoreSettingsController;
use App\Http\Controllers\store\StorePaymentMethodController;
use App\Http\Controllers\store\TablesController;
use App\Http\Controllers\store\ThemeController;
use App\Http\Controllers\store\WaiterCallController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\visitor\CartController;
use App\Http\Controllers\visitor\OrderController;
use App\Http\Controllers\visitor\ProductController;
use App\Http\Controllers\visitor\StoreController;
use App\Http\Controllers\visitor\TableController;
use App\Http\Controllers\visitor\WaiterCallController as VisitorWaiterCallController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware', ['guest']], function () {
    Route::get('/register', [UsersController::class, 'registerPage']);
    Route::post('/register', [UsersController::class, 'register'])->name('register');
    Route::get('/login', [UsersController::class, 'loginPage'])->name('login');
    Route::post('/login', [UsersController::class, 'login']);
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'statistics']);
        Route::get('/new-stores', [AdminController::class, 'dashboard']);
        Route::middleware('siteRole:view_store')->group(function () {
            Route::get('stores/show/{id}', [StoresController::class, 'show']);
        });
        Route::middleware(['siteRole:update_store'])->group(function () {
            Route::post('store/approve/{id}', [AdminController::class, 'approve']);
            Route::post('store/change_status', [StoresController::class, 'change_status']);
            Route::post('store/info', [StoresController::class, 'get_info']);
            Route::get('store/update_plan/{id}', [StoresController::class, 'edit_plan']);
            Route::post('store/update_plan/{id}', [StoresController::class, 'update_plan']);
            
        });
        Route::middleware(['siteRole:update_store_privilege'])->group(function () {
            Route::get('stores/privileges', [StorePrivilegeController::class, 'index']);
        });
        Route::middleware(['siteRole:create_store_privilege'])->group(function () {
            Route::get('stores/privileges/add', [StorePrivilegeController::class, 'create']);
            Route::post('stores/privileges/add', [StorePrivilegeController::class, 'store']);
        });
        Route::middleware('siteRole:update_store_privilege')->group(function () {
            Route::get('stores/privileges/update/{id}', [StorePrivilegeController::class, 'edit']);
            Route::post('stores/privileges/update/{id}', [StorePrivilegeController::class, 'update']);
        });
        Route::delete('stores/privileges/delete/{id}', [StorePrivilegeController::class, 'destroy'])->middleware('siteRole:delete_store_privilege');
        Route::get('plans', [PlanController::class, 'index']);
        Route::get('plans/add', [PlanController::class, 'create'])->name('plans.create');
        Route::post('plans/add', [PlanController::class, 'store']);
        Route::get('plans/update/{id}', [PlanController::class, 'edit'])->name('plans.update');
        Route::post('plans/update/{id}', [PlanController::class, 'update']);
        Route::delete('plans/delete/{id}', [PlanController::class, 'destroy']);

        Route::middleware('siteRole:view_plan_order')->group(function () {
            Route::get('plans/orders', [PlanOrderController::class, 'index']);
            Route::get('plans/orders/{id}', [PlanOrderController::class, 'show']);
        });
        Route::middleware('siteRole:update_plan_order')->group(function () {
            Route::post('plans/orders/approve/{id}', [PlanOrderController::class, 'approve']);
            Route::post('plans/orders/decline/{id}', [PlanOrderController::class, 'decline']);
        });
        Route::middleware('siteRole:delete_plan_order')->group(function () {
            Route::delete('plans/orders/delete/{id}', [PlanOrderController::class, 'destroy']);
        });
        Route::middleware('siteRole:view_site_privilege')->group(function () {
            Route::get('/site_privileges', [SitePrivilegeController::class, 'index']);
        });
        Route::middleware('siteRole:create_site_privilege')->group(function () {
            Route::get('/site_privilege/create', [SitePrivilegeController::class, 'create']);
            Route::post('/site_privilege/create', [SitePrivilegeController::class, 'store']);
        });
        Route::middleware('siteRole:update_site_privilege')->group(function () {
            Route::get('site_privilege/update/{id}', [SitePrivilegeController::class, 'edit']);
            Route::post('site_privilege/update/{id}', [SitePrivilegeController::class, 'update']);
        });
        Route::delete('site_privilege/delete/{id}', [SitePrivilegeController::class, 'destroy']);
        Route::middleware('siteRole:view_admin')->group(function () {
            Route::get('admins', [AdminController::class, 'index'])->name('admin.admins');
        });
        Route::middleware('siteRole:create_admin')->group(function () {
            Route::get('admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
            Route::post('admins/create', [AdminController::class, 'store'])->name('admin.admins.create');
        });
        Route::middleware('siteRole:update_admin')->group(function () {
            Route::get('admins/update/{id}', [AdminController::class, 'edit'])->name('admin.admins.update');
            Route::post('admins/update/{id}', [AdminController::class, 'update'])->name('admin.admins.update');
        });
        Route::delete('admins/delete/{id}', [AdminController::class, 'destroy']);
        Route::middleware('siteRole:view_theme')->group(function () {
            Route::get('themes', [AdminThemeController::class, 'index'])->name('admin.themes');
        });
        Route::middleware('siteRole:create_theme')->group(function () {
            Route::get('themes/create', [AdminThemeController::class, 'create']);
            Route::post('themes/create', [AdminThemeController::class, 'store']);
        });
        Route::middleware('siteRole:update_theme')->group(function () {
            Route::get('themes/update/{id}', [AdminThemeController::class, 'edit']);
            Route::post('themes/update/{id}', [AdminThemeController::class, 'update']);
        });
        Route::delete('themes/delete/{id}', [AdminThemeController::class, 'destroy'])->middleware('delete_theme');
        Route::middleware('siteRole:update_settings')->group(function(){
            Route::get('settings',[SettingController::class,'index'])->name('admin.settings');
            Route::post('settings/update',[SettingController::class,'update']);
            Route::get('privacy_terms',[SettingController::class,'privacy_terms']);
            Route::post('privacy_terms',[SettingController::class,'update_privacy_terms']);
        });
        Route::get('statistics',[AdminController::class,'statistics']);
        Route::post('filter_orders',[AdminController::class,'filter_by_date']);
        Route::get('store_sheet',[AdminController::class,'get_sheet']);
        Route::middleware('siteRole:view_question')->group(function(){
            Route::get('questions',[QuestionController::class,'index']);
        });
        Route::middleware('siteRole:create_question')->group(function(){
            Route::get('questions/create',[QuestionController::class,'create']);
            Route::post('questions/create',[QuestionController::class,'store']);
            
        });
        Route::middleware('siteRole:update_question')->group(function(){
            Route::get('questions/update/{id}',[QuestionController::class,'edit']);
            Route::post('questions/update/{id}',[QuestionController::class,'update']);
        });
        Route::post('ckeditor/upload',[FileUploadController::class,'ckupload'])->name('ckeditor.upload');
        Route::delete('questions/delete/{id}',[QuestionController::class,'destroy'])->middleware('siteRole:delete_question');
    });
});
Route::middleware('auth')->group(function () {

    Route::get('store/create', [StoreAdminController::class, 'addStore'])->name('store.create');
    Route::post('store/create', [StoreAdminController::class, 'create']);
});
Route::middleware('auth', 'approved', 'check_sub')->group(function () {
    Route::group(['prefix' => 'store'], function () {
        Route::post('/uploadImage', [StoreAdminController::class, 'uploadPhoto']);
        Route::get('/dashboard', [StoreSettingsController::class, 'statistics'])->name('store.dashboard');
        Route::get('/inventory', [StoreAdminController::class, 'inventory'])->name('store.inventory');
        Route::get('stores', [StoreAdminController::class, 'stores'])->name('store.stores');
        Route::middleware('storeRole:create_category')->group(function () {
            Route::get('categories/add', [ProductCategoriesController::class, 'create']);
            Route::post('categories/add', [ProductCategoriesController::class, 'store']);
        });
        Route::get('print_qr', [StoreAdminController::class, 'print_qr']);
        Route::get('tables/print_qr/{id}', [TablesController::class, 'print_qr']);
        Route::delete('categories/delete/{id}', [ProductCategoriesController::class, 'destroy']);
        Route::middleware('storeRole:update_category')->group(function () {
            Route::get('categories/update/{id}', [ProductCategoriesController::class, 'edit'])->name('store.categories.update');
            Route::post('categories/update/{id}', [ProductCategoriesController::class, 'update']);
        });
        Route::middleware('storeRole:create_product')->group(function () {
            Route::get('products/add', [ProductsController::class, 'add']);
            Route::post('products/add', [ProductsController::class, 'create']);
            Route::get('addons/add', [AddonsController::class, 'add']);
            Route::post('addons/add', [AddonsController::class, 'create']);
            Route::post('edits/add', [EditsController::class, 'create']);
            Route::post('sauces/add', [SaucesController::class, 'create']);
            Route::post('sizes/add',[SizeController::class,'store']);
        });
        Route::middleware('storeRole:update_product')->group(function () {
            Route::get('products/update/{id}', [ProductsController::class, 'edit'])->name('store.products.update');
            Route::post('products/update/{id}', [ProductsController::class, 'update']);
            Route::get('addons/update/{id}', [AddonsController::class, 'edit'])->name('store.addons.update');
            Route::post('addons/update/{id}', [AddonsController::class, 'update']);
        });
        Route::delete('products/delete/{id}', [ProductsController::class, 'delete'])->middleware('storeRole:delete_product');
        Route::middleware('storeRole:delete_product')->group(function () {
            Route::delete('addons/delete/{id}', [AddonsController::class, 'delete']);
            Route::delete('edits/delete/{id}', [EditsController::class, 'delete']);
            Route::delete('sauces/delete/{id}', [SaucesController::class, 'delete']);
        });

        Route::get('settings', [StoreAdminController::class, 'settings']);
        Route::post('/products/uploadImage', [ProductsController::class, 'uploadPhoto']);
        Route::middleware('storeRole:update_store')->group(function () {
            Route::post('update_info', [StoreAdminController::class, 'updateInfo']);
            Route::post('change_status', [StoreAdminController::class, 'change_status']);
            Route::post('create_theme', [StoreSettingsController::class, 'create']);
            Route::post('settings/update_days',[StoreSettingsController::class,'update_days']);
            Route::post('update_order_settings',[StoreSettingsController::class,'update_order_settings']);
        });
        Route::get('add_payment_method', [StorePaymentMethodController::class, 'add']);
        Route::post('create_payment_method', [StorePaymentMethodController::class, 'create']);
        Route::get('edit_payment_method/{id}', [StorePaymentMethodController::class, 'edit']);
        Route::post('update_payment_method/{id}', [StorePaymentMethodController::class, 'update']);
        Route::delete('delete_payment_method/{id}', [StorePaymentMethodController::class, 'delete']);

        Route::middleware('storeRole:delete_store')->group(function () {
            Route::get('delete/{id}', [StoreAdminController::class, 'delete_check']);
            Route::delete('delete/{id}', [StoreAdminController::class, 'delete']);
        });
        Route::get('tables', [TablesController::class, 'index'])->middleware('storeRole:view_table');
        Route::middleware('storeRole:create_table')->group(function () {
            Route::get('tables/add', [TablesController::class, 'add']);
            Route::post('tables/add', [TablesController::class, 'create']);
        });
        Route::middleware('storeRole:update_table')->group(function () {
            Route::get('tables/update/{id}', [TablesController::class, 'edit']);
            Route::post('tables/update/{id}', [TablesController::class, 'update']);
        });
        Route::delete('tables/delete/{id}', [TablesController::class, 'delete'])->middleware('storeRole:delete_table');
        Route::get('coupons', [CouponsController::class, 'index'])->middleware('storeRole:view_coupon');
        Route::middleware('storeRole:create_coupon')->group(function () {
            Route::get('coupons/add', [CouponsController::class, 'create']);
            Route::post('coupons/add', [CouponsController::class, 'store']);
        });
        Route::middleware('storeRole:update_coupon')->group(function () {

            Route::get('coupons/update/{id}', [CouponsController::class, 'edit']);
            Route::post('coupons/update/{id}', [CouponsController::class, 'update']);
        });
        Route::delete('coupons/delete/{id}', [CouponsController::class, 'destroy'])->middleware('storeRole:delete_coupon');

        Route::get('branches', [BrancheController::class, 'index'])->middleware('storeRole:view_branch');
        Route::middleware('storeRole:create_branch')->group(function () {
            Route::get('branches/add', [BrancheController::class, 'create']);
            Route::post('branches/add', [BrancheController::class, 'store']);
        });
        Route::middleware('storeRole:update_branch')->group(function () {

            Route::get('branches/update/{id}', [BrancheController::class, 'edit']);
            Route::post('branches/update/{id}', [BrancheController::class, 'update']);
        });
        Route::delete('branches/delete/{id}', [BrancheController::class, 'destroy'])->middleware('storeRole:delete_branch');

        Route::middleware('storeRole:view_expense')->group(function () {
            Route::get('expenses', [ExpenseController::class, 'index']);
        });
        Route::middleware('storeRole:create_expense')->group(function () {
            Route::get('expenses/add', [ExpenseController::class, 'create']);
            Route::post('expenses/add', [ExpenseController::class, 'store']);
        });
        Route::middleware('storeRole:update_expense')->group(function () {
            Route::get('expenses/update/{id}', [ExpenseController::class, 'edit']);
            Route::post('expenses/update/{id}', [ExpenseController::class, 'update']);
        });
        Route::middleware('storeRole:view_user')->group(function () {
            Route::get('users', [AdminsController::class, 'index']);
        });
        Route::middleware('storeRole:create_user')->group(function () {
            Route::get('admins/create', [AdminsController::class, 'create'])->name('store.admins.create');
            Route::post('admins/create', [AdminsController::class, 'store'])->name('store.admins.create');
        });
        Route::middleware('storeRole:update_user')->group(function () {
            Route::get('admins/update/{id}', [AdminsController::class, 'edit'])->name('store.admins.update');
            Route::post('admins/update/{id}', [AdminsController::class, 'update'])->name('store.admins.update');
        });
        Route::delete('admins/delete/{id}', [AdminsController::class, 'destroy'])->middleware('storeRole:delete_user');
        Route::middleware('storeRole:view_order')->group(function () {
            Route::get('orders', [StoreOrderController::class, 'index']);
            Route::get('orders/{id}', [StoreOrderController::class, 'get_order']);
        });
        Route::middleware('storeRole:update_order')->group(function () {
            Route::post('orders/accept/{id}', [StoreOrderController::class, 'accept']);
            Route::post('orders/deny/{id}', [StoreOrderController::class, 'deny']);
            Route::post('orders/set_paid/{id}', [StoreOrderController::class, 'set_paid']);
            Route::post('orders/on_delivery/{id}', [StoreOrderController::class, 'on_delivery']);
            Route::post('orders/completed/{id}', [StoreOrderController::class, 'completed']);
        });
        Route::middleware('planRole:tables')->group(function () {
            Route::get('waiter_call', [WaiterCallController::class, 'index']);
            Route::get('check_waiter_call', [WaiterCallController::class, 'check']);
            Route::post('set_completed', [WaiterCallController::class, 'set_completed']);
            Route::delete('waiter_call/delete/{id}', [WaiterCallController::class, 'destroy']);
        });
        Route::middleware('storeRole:view_theme')->group(function () {
        });
        Route::middleware('storeRole:create_theme')->group(function () {
            Route::get('/themes/create', [ThemeController::class, 'create']);
            Route::post('/themes/create', [ThemeController::class, 'store']);
        });
        Route::middleware('storeRole:update_theme')->group(function () {
            Route::get('themes/update/{id}', [ThemeController::class, 'edit']);
            Route::post('themes/update/{id}', [ThemeController::class, 'update']);
            Route::post('themes/activate',[ThemeController::class,'activate']);
        });
        Route::middleware('storeRole:delete_theme')->group(function () {
            Route::delete('themes/delete/{id}', [ThemeController::class, 'destroy']);
        });
        Route::delete('expenses/delete/{id}', [ExpenseController::class, 'destroy'])->middleware('storeRole:delete_expense');
    
        Route::get('statistics',[StoreSettingsController::class,'statistics']);
        Route::post('filter_orders',[StoreSettingsController::class,'filter_by_date']);
        Route::get('store_sheet',[StoreSettingsController::class,'get_sheet']);
    });
    
});
Route::middleware('auth')->group(function(){
    Route::group(['prefix'=>'store'],function(){
        
    
    Route::middleware('storeRole:view_plan')->group(function () {
        Route::get('plans', [StorePlanController::class, 'index']);
        Route::get('plans/details/{id}', [StorePlanController::class, 'plan_details']);
    });
    Route::middleware('storeRole:modify_plan')->group(function () {
        Route::post('plans/confirm_order', [StorePlanController::class, 'confirm_payment']);
        Route::get('plans/confirm_payment/{id}',[StorePlanController::class,'submit_payment']);
        Route::get('plans/method_details/{id}', [StorePlanController::class, 'method_details']);
        Route::post('plans/confirm_payment/{id}', [StorePlanController::class, 'store_payment']);
        Route::get('plans/paypal_payment/{id}', [StorePlanController::class, 'paypal_payment']);
    });
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard']);
    Route::get('store/my_stores', [StoreAdminController::class, 'my_stores']);
    Route::get('store/create', [StoreAdminController::class, 'create_store']);
    Route::post('store/switch', [StoreAdminController::class, 'switch_store']);
    Route::get('store/pending', function () {
        return view('store.pending');
    });
    Route::get('store/deactivated', function () {
        get_locale();
        return view('store.deactivated');
    })->middleware('storeStatus:deactivated');
    Route::get('store/sub_end', function () {
        get_locale();
        return view('store.check_plan');
    })->middleware('storeStatus:sub_end');
    Route::get('/logout', [UsersController::class, 'logout']);
});
Route::get('/store/{id}', [StoreController::class, 'intro']);
Route::get('/store/menu/{id}', [StoreController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::get('/', [HomeController::class,'index']);
Route::get('/changeTheme/{theme}',[HomeController::class,'changeTheme']);
Route::post('add_to_cart', [CartController::class, 'store']);
Route::post('table/add_to_cart', [CartController::class, 'store_table']);
Route::get('cart', [CartController::class, 'index']);
Route::get('table/cart', [CartController::class, 'table_cart']);
Route::delete('cart/delete/{id}', [CartController::class, 'destroy']);
Route::get('orders/create/{store}', [OrderController::class, 'create'])->name('orders.create');
Route::get('table/orders/create/{store}', [OrderController::class, 'table_create'])->name('table.orders.create');
Route::post('table/orders/create/{store}', [OrderController::class, 'store_table_order'])->name('table.orders.create');
Route::post('orders/create/{store}', [OrderController::class, 'store'])->name('orders.create');
Route::post('check_coupon', [OrderController::class, 'check_coupon']);
Route::post('get_payment_info', [OrderController::class, 'get_payment_info']);
Route::get('store/{store}/tables/{table}', [TableController::class, 'index'])->name('store.table');
Route::get('menu', [TableController::class, 'menu']);
Route::get('lang/{locale}', [HomeController::class, 'switch_lang']);
Route::get('call_waiter',[VisitorWaiterCallController::class,'call_waiter']);
Route::post('cart/update/{id}',[CartController::class,'update_quantity']);
Route::get('instructions',[HomeController::class,'instructions']);
Route::get('privacy',[HomeController::class,'privacy']);
Route::get('terms',[HomeController::class,'terms']);
