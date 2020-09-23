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

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
/*
|--------------------------------------------------------------------------
| admin routes
|--------------------------------------------------------------------------
*/
Route::get('/a51a86dc336dac898799feb272cdc9e85cdf97ae56959345b1f955e15ec532cb', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/a51a86dc336dac898799feb272cdc9e85cdf97ae56959345b1f955e15ec532cb', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('admin/register', 'Auth\AdminRegisterController@showRegistrationForm')->name('admin.register');
Route::post('admin/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');

Route::prefix('admin')->middleware('auth:admin')->group(function(){
    // Registrar usuario
    Route::get('/register-user', 'Auth\RegisterController@showRegistrationForm')->name('register.user');
    Route::post('/register-user', 'Auth\RegisterController@register')->name('register');

    // Registro de actividad
    Route::get('/activity-log', 'AdminController@admin_activity_log')->name('admin.activity.log');
    Route::get('/activity-log/all', 'AdminController@admin_activity_log_all')->name('admin.activity.log.all');
    Route::get('/activity-log/user/{id}', 'AdminController@admin_activity_log_user')->name('admin.activity.log.user');


    // Cambiar contraseña administrador
    Route::get('/change-password/{id}', 'AdminController@admin_edit_password')->name('admin.change.password');
    Route::put('/change-password/{id}', 'AdminController@admin_update_password')->name('admin.change.password.submit');

    // Rutas Polizas
    Route::get('/index-policies', 'PoliciesController@index_admin')->name('index.policies');
    Route::get('/index-policy/{id}', 'PoliciesController@show_admin')->name('policy.price.view');
    Route::get('/admin-exportpdf/{id}', 'PoliciesController@admin_exportpdf')->name('admin.policy.export.pdf');
    Route::get('/edit-policy/{id}', 'PoliciesController@admin_edit')->name('admin.edit.policy');
    Route::put('/edit-policy/{id}', 'PoliciesController@admin_update')->name('admin.update.policy');
    Route::put('/renew-policy/{id}', 'PoliciesController@admin_renew')->name('admin.renew.policy');
    Route::get('/register-policy', 'PoliciesController@create_admin')->name('register.policy');
    Route::post('/register-policy', 'PoliciesController@store_admin')->name('register.policy.submit');
    Route::get('/register-policy/search', 'PoliciesController@search')->name('policy.search.vehicle');
    Route::delete('/delete-policy/{id}', 'PoliciesController@admin_destroy')->name('delete.user');
    Route::put('/renew-policy-price/{id}', 'PoliciesController@admin_price_renew')->name('admin.renew.price');

    // Rutas Usuarios
    Route::get('/index-users', 'AdminController@index_users')->name('index.users');
    Route::get('/index-user/{id}', 'AdminController@show_user')->name('index.show.user');
    Route::get('/edit-user/{id}', 'AdminController@edit')->name('admin.edit.user');
    Route::get('/edit-user/password/{id}', 'AdminController@edit_password')->name('admin.edit.user.password');
    Route::put('/edit-user/password/{id}', 'AdminController@update_password')->name('admin.edit.user.password.submit');
    Route::put('/edit-user/{id}', 'AdminController@update')->name('admin.update.user');
    Route::delete('/delete-user/{id}', 'AdminController@destroy')->name('admin.delete.user');
    
    // Rutas Usuarios administradores
    Route::get('/index-admins', 'AdminController@index_users_admins')->name('index.users.admins');
    Route::get('/index-admin/{id}', 'AdminController@show_admin')->name('index.show.admins');
    Route::get('/edit-admin/{id}', 'AdminController@edit_admin')->name('admin.edit.admin');
    Route::put('/edit-admin/{id}', 'AdminController@update_admin')->name('admin.update.admin');
    Route::delete('/delete-admin/{id}', 'AdminController@destroy_admin')->name('admin.delete.admin');
    // Cambiar contraseña administrador
    Route::get('/change-password/{id}', 'AdminController@admin_edit_password')->name('admin.change.password');
    Route::put('/change-password/{id}', 'AdminController@admin_update_password')->name('admin.change.password.submit');
    // Registrar administrador
    Route::get('/register', 'Auth\AdminRegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');

    // Rutas precios 
    Route::get('/index-prices', 'PricesController@index_admin')->name('index.prices');
    Route::get('/index-price/{id}', 'PricesController@show_admin')->name('index.show.price');
    Route::get('/edit-price/{id}', 'PricesController@admin_edit')->name('admin.edit.price');
    Route::put('/edit-price/{id}', 'PricesController@admin_update')->name('admin.update.price');
    Route::get('/register-price', 'PricesController@create')->name('register.price');
    Route::post('/register-price', 'PricesController@store')->name('register.price.submit');
    Route::delete('/delete-price/{id}', 'PricesController@destroy')->name('delete.price');
    
    // Rutas Oficinas
    Route::get('/index-offices', 'OfficesController@index')->name('index.offices');
    Route::get('/register-office', 'OfficesController@create')->name('register.office');
    Route::post('/register-office', 'OfficesController@store')->name('register.office.submit');
    Route::get('/register-office/search-municipio', 'OfficesController@search_municipio')->name('office.search.municipio');
    Route::get('/register-office/search-parroquia', 'OfficesController@search_parroquia')->name('office.search.parroquia');
    Route::get('/edit-office/{id}', 'OfficesController@admin_edit')->name('admin.edit.office');
    Route::put('/edit-office/{id}', 'OfficesController@admin_update')->name('admin.update.office');
    Route::delete('/delete-office/{id}', 'OfficesController@destroy')->name('delete.office');    


    // Rutas Vehiculos
    Route::get('/index-vehicles', 'VehicleController@index_admin')->name('index.vehicles');
    Route::get('/register-vehicle', 'VehicleController@create_admin')->name('register.vehicle');
    Route::post('/register-vehicle', 'VehicleController@store_admin')->name('register.vehicle.submit');
    Route::get('/edit-vehicle/{id}', 'VehicleController@admin_edit')->name('admin.edit.vehicle');
    Route::put('/edit-vehicle/{id}', 'VehicleController@admin_update')->name('admin.update.vehicle');
    Route::delete('/delete-vehicle/{id}', 'VehicleController@destroy')->name('delete.vehicle');

    /*Registrar tipo de vehiculo*/
    Route::get('/index-types', 'VehicleTypesController@index_admin')->name('index.vehicle.types');
    Route::get('/register-type', 'VehicleTypesController@create_admin')->name('register.type');
    Route::post('/register-type', 'VehicleTypesController@store_admin')->name('register.type.submit');
    Route::get('/edit-type/{id}', 'VehicleTypesController@edit_admin')->name('edit.vehicle.type');
    Route::put('/edit-type/{id}', 'VehicleTypesController@update_admin')->name('update.vehicle.type');
    Route::delete('/delete-type/{id}', 'VehicleTypesController@destroy')->name('delete.type');

    /* Registrar clase */
    Route::get('/index-classes', 'VehicleClassesController@index_admin')->name('index.vehicle.classes');
    Route::get('/register-class', 'VehicleClassesController@create_admin')->name('register.class');
    Route::post('/register-class', 'VehicleClassesController@store_admin')->name('register.class.submit');
    Route::get('/edit-class/{id}', 'VehicleClassesController@edit_admin')->name('edit.class');
    Route::put('/edit-class/{id}', 'VehicleClassesController@update_admin')->name('edit.class.submit');
    Route::delete('/delete-class/{id}', 'VehicleClassesController@destroy')->name('delete.class');

    //Rutas Pagos
    Route::get('/index-payments', 'PaymentsController@index_admin')->name('index.payments');  
    Route::get('/index-payment/{id}', 'PaymentsController@show_admin')->name('index.show.payment');  
    Route::post('/register-payment/{id}', 'PaymentsController@store_admin')->name('register.payment.submit');
    Route::put('/update-payment/{id}', 'PaymentsController@update')->name('payment.bill');



    // Ruta dashboard admin
    Route::get('/a51a86dc336dac898799feb272cdc9e85cdf97ae56959345b1f955e15ec532cb', 'AdminController@index')->name('admin');
});

/*
|--------------------------------------------------------------------------
| user routes
|--------------------------------------------------------------------------
*/
Route::prefix('user')->middleware('auth')->group(function(){
    // Rutas Vehiculos  
	Route::get('/index-vehicles', 'VehicleController@index')->name('user.index.vehicles');
	Route::get('/register-vehicle', 'VehicleController@create')->name('user.register.vehicle');
    Route::post('/register-vehicle', 'VehicleController@store')->name('user.register.vehicle.submit');
    /* Registrar tipo de vehiculo */
    Route::get('/index-types', 'VehicleTypesController@index')->name('user.index.vehicle.types');
    Route::get('/register-type', 'VehicleTypesController@create')->name('user.register.type');
    Route::post('/register-type', 'VehicleTypesController@store')->name('user.register.type.submit');
    Route::get('/edit-type/{id}', 'VehicleTypesController@edit')->name('user.edit.vehicle.type');
    Route::put('/edit-type/{id}', 'VehicleTypesController@update')->name('user.update.type');

    //Rutas Polizas
    Route::get('/index-policies', 'PoliciesController@index')->name('user.index.policies');
    Route::get('/index-policy/{id}', 'PoliciesController@show')->name('user.show.policy');
    Route::get('/user-exportpdf/{id}', 'PoliciesController@user_exportpdf')->name('user.policy.export.pdf');
    Route::get('/register-policy', 'PoliciesController@create')->name('user.register.policy');
    Route::post('/register-policy', 'PoliciesController@store')->name('user.register.policy.submit');
    Route::put('/renew-policy/{id}', 'PoliciesController@renew')->name('user.renew.policy');    
    Route::put('/renew-policy-price/{id}', 'PoliciesController@admin_price_renew')->name('admin.renew.price');

    //Rutas Precios
    Route::get('/index-prices', 'PricesController@index')->name('user.index.prices');
    Route::get('/index-price/{id}', 'PricesController@show')->name('user.index.show.price');

    //Rutas Pagos
    Route::get('/index-payments', 'PaymentsController@index')->name('user.index.payments');

    //Rutas Cambiar contraseña
    Route::put('/change-password/{id}', 'ChangeUsersPassword@update_password')->name('user.change.password.submit');

    //Rutas Registro de Actividad
    Route::get('/activity-log/{id}', 'DashboardController@activity_log')->name('user.activity.log');
    Route::get('/search-municipio', 'OfficesController@search_municipio')->name('office.search.municipio.user');
    Route::get('/search-parroquia', 'OfficesController@search_parroquia')->name('office.search.parroquia.user');


});

//Consultas AJAX
Route::get('/register-policy/search', 'PoliciesController@search')->name('policy.search.vehicle');
Route::get('/register-policy/price-select', 'PoliciesController@price_select')->name('policy.price.select');
Route::get('/register-policy/price-view', 'PoliciesController@price_view')->name('policy.price.view');  

// Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('/', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');