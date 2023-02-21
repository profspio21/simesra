<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Outlet Kitchen
    Route::delete('outlet-kitchens/destroy', 'OutletKitchenController@massDestroy')->name('outlet-kitchens.massDestroy');
    Route::resource('outlet-kitchens', 'OutletKitchenController');

    // Rm Category
    Route::delete('rm-categories/destroy', 'RmCategoryController@massDestroy')->name('rm-categories.massDestroy');
    Route::resource('rm-categories', 'RmCategoryController');

    // Raw Material
    Route::delete('raw-materials/destroy', 'RawMaterialController@massDestroy')->name('raw-materials.massDestroy');
    Route::resource('raw-materials', 'RawMaterialController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::resource('products', 'ProductController');

    // Sales
    Route::get('sales/list','SalesController@list')->name('sales.list');
    Route::delete('sales/destroy', 'SalesController@massDestroy')->name('sales.massDestroy');
    Route::resource('sales', 'SalesController');

    // Order
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrderController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});