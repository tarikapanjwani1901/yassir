<?php
include_once 'web_builder.php';
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('500', function () {
        return abort(404);
    });
Route::get('404', function () {
        return abort(404);
    });  

Route::get('listing?s_key=&s_city=&s_category', function () {
        return abort(404);
    });        
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Cache cleared</h1>';
});
Route::get('down', function(){
    return Artisan::call('down');
});
Route::get('site/live', function(){
    return Artisan::call('up');
}); 
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');       
    return '<h1>Cache cleared</h1>';
});
Route::post('/visitors_search_data', 'HomePageController@visitors_search_data');
Route::get('/autocomplete/fetch', 'HomePageController@fetch')->name('autocomplete.fetch');
Route::pattern('slug', '[a-z0-9- _]+');
Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {
Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('lockscreen');
Route::get('login', 'AuthController@getSignin')->name('login');
Route::get('signin', 'AuthController@getSignin')->name('signin');
Route::post('signin', 'AuthController@postSignin')->name('postSignin');
Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
Route::get('login2', function () {
    return view('admin/login2');
});
Route::get('register2', function () {
    return view('admin/register2');
});
Route::post('register2', 'AuthController@postRegister2')->name('register2');
Route::get('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm')->name('forgot-password-confirm');
Route::post('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm');
Route::get('logout', 'AuthController@getLogout')->name('logout');
Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
});
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('generator_builder');
    Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
    Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');
    Route::post('modelCheck', 'ModelcheckController@modelCheck');
    Route::get('/', 'JoshController@showHome')->name('dashboard');
    Route::post('crop_demo', 'JoshController@crop_demo')->name('crop_demo');
    Route::get('log_viewers', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index')->name('log-viewers');
    Route::get('log_viewers/logs', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs')->name('log_viewers.logs');
    Route::delete('log_viewers/logs/delete', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete')->name('log_viewers.logs.delete');
    Route::get('log_viewers/logs/{date}', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show')->name('log_viewers.logs.show');
    Route::get('log_viewers/logs/{date}/download', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download')->name('log_viewers.logs.download');
    Route::get('log_viewers/logs/{date}/{level}', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel')->name('log_viewers.logs.filter');
    Route::get('log_viewers/logs/{date}/{level}/search', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@search')->name('log_viewers.logs.search');
    Route::get('log_viewers/logcheck', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@logCheck')->name('log-viewers.logcheck');
    Route::get('activity_log/data', 'JoshController@activityLogData')->name('activity_log.data');
});
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    Route::post('mdelete','OTPListingController@mdelete');
    Route::group([ 'prefix' => 'users'], function () {
        Route::get('data', 'UsersController@data')->name('users.data');
        Route::get('{user}/delete', 'UsersController@destroy')->name('users.delete');
        Route::get('{user}/confirm-delete', 'UsersController@getModalDelete')->name('users.confirm-delete');
        Route::get('{user}/restore', 'UsersController@getRestore')->name('restore.user');
        //Route::post('{user}/passwordreset', 'UsersController@passwordreset')->name('passwordreset');
        Route::post('passwordreset', 'UsersController@passwordreset')->name('passwordreset');
    });
    Route::get('manage_invoice', 'UsersController@manage_invoice');
    Route::get('invoice_detail', 'UsersController@invoice_detail');
    Route::get('manage_invoice/edit/{id}', 'UsersController@get_invoice');
    Route::post('manage_invoice/edit/{id}', 'UsersController@add_invoice');
    Route::get('manage_invoice/delete/{id}', 'UsersController@delete_invoice');
    Route::get('brochure', 'BrochureController@index');
    Route::get('brochure/{id}', 'BrochureController@get_data');
    Route::get('invoice/{id}', 'UsersController@invoice');
    Route::resource('users', 'UsersController');
            Route::get('all_vendor', 'UsersController@all_vendor');   
            Route::get('all_sales', 'UsersController@all_sales');
            Route::get('all_customer', 'UsersController@all_customer');
    Route::get('deleted_users',['before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'])->name('deleted_users');
    Route::group(['prefix' => 'groups'], function () {
        Route::get('{group}/delete', 'GroupsController@destroy')->name('groups.delete');
        Route::get('{group}/confirm-delete', 'GroupsController@getModalDelete')->name('groups.confirm-delete');
        Route::get('{group}/restore', 'GroupsController@getRestore')->name('groups.restore');
    });
    Route::resource('groups', 'GroupsController');
    Route::group(['prefix' => 'blog'], function () {
        Route::get('{blog}/delete', 'BlogController@destroy')->name('blog.delete');
        Route::get('{blog}/confirm-delete', 'BlogController@getModalDelete')->name('blog.confirm-delete');
        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
        Route::post('{blog}/storecomment', 'BlogController@storeComment')->name('storeComment');
    });
    Route::resource('blog', 'BlogController');
    Route::group(['prefix' => 'blogcategory'], function () {
        Route::get('{blogCategory}/delete', 'BlogCategoryController@destroy')->name('blogcategory.delete');
        Route::get('{blogCategory}/confirm-delete', 'BlogCategoryController@getModalDelete')->name('blogcategory.confirm-delete');
        Route::get('{blogCategory}/restore', 'BlogCategoryController@getRestore')->name('blogcategory.restore');
    });
    Route::resource('blogcategory', 'BlogCategoryController');
    Route::group(['prefix' => 'file'], function () {
        Route::post('create', 'FileController@store')->name('store');
        Route::post('createmulti', 'FileController@postFilesCreate')->name('postFilesCreate');
        Route::delete('delete', 'FileController@delete')->name('delete');
    });
    Route::group(['prefix' => 'news'], function () {
        Route::get('data', 'NewsController@data')->name('news.data');
        Route::get('{news}/delete', 'NewsController@destroy')->name('news.delete');
        Route::get('{news}/confirm-delete', 'NewsController@getModalDelete')->name('news.confirm-delete');
    });
    Route::resource('news', 'NewsController');
    Route::get('crop_demo', function () {
        return redirect('admin/imagecropping');
    });
    Route::get('laravel_chart', 'ChartsController@index')->name('laravel_chart');
    Route::get('database_chart', 'ChartsController@databaseCharts')->name('database_chart');
    Route::get('datatables', 'DataTablesController@index')->name('index');
    Route::get('datatables/data', 'DataTablesController@data')->name('datatables.data');
    Route::get('jtable/index', 'JtableController@index')->name('index');
    Route::post('jtable/store', 'JtableController@store')->name('store');
    Route::post('jtable/update', 'JtableController@update')->name('update');
    Route::post('jtable/delete', 'JtableController@destroy')->name('delete');
    Route::get('selectfilter', 'SelectFilterController@index')->name('selectfilter');
    Route::get('selectfilter/find', 'SelectFilterController@filter')->name('selectfilter.find');
    Route::post('selectfilter/store', 'SelectFilterController@store')->name('selectfilter.store');
    Route::get('editable_datatables', 'EditableDataTablesController@index')->name('index');
    Route::get('editable_datatables/data', 'EditableDataTablesController@data')->name('editable_datatables.data');
    Route::post('editable_datatables/create', 'EditableDataTablesController@store')->name('store');
    Route::post('editable_datatables/{id}/update', 'EditableDataTablesController@update')->name('update');
    Route::get('editable_datatables/{id}/delete', 'EditableDataTablesController@destroy')->name('editable_datatables.delete');
    Route::get('custom_datatables', 'CustomDataTablesController@index')->name('index');
    Route::get('custom_datatables/sliderData', 'CustomDataTablesController@sliderData')->name('custom_datatables.sliderData');
    Route::get('custom_datatables/radioData', 'CustomDataTablesController@radioData')->name('custom_datatables.radioData');
    Route::get('custom_datatables/selectData', 'CustomDataTablesController@selectData')->name('custom_datatables.selectData');
    Route::get('custom_datatables/buttonData', 'CustomDataTablesController@buttonData')->name('custom_datatables.buttonData');
    Route::get('custom_datatables/totalData', 'CustomDataTablesController@totalData')->name('custom_datatables.totalData');
    Route::post('task/create', 'TaskController@store')->name('store');
    Route::get('task/data', 'TaskController@data')->name('data');
    Route::post('task/{task}/edit', 'TaskController@update')->name('update');
    Route::post('task/{task}/delete', 'TaskController@delete')->name('delete');
    Route::group(['prefix' => 'testimonials'], function () {
        Route::get('testimonials', 'TestimonialController@data');
        Route::get('add', 'TestimonialController@add');
        Route::post('add', 'TestimonialController@addTestimonail');
        Route::get('edit/{id}', 'TestimonialController@editTestimonail');
        Route::post('edit/{id}', 'TestimonialController@editPostTestimonail');
        Route::post('delete/{id}', 'TestimonialController@delete');
    });
    Route::get('testimonial_search','TestimonialController@manage_testimonial');
    Route::resource('testimonials', 'TestimonialController');
    Route::group(['prefix' => 'categories'], function () {
        Route::get('add', 'CategoryController@add');
        Route::post('add', 'CategoryController@add');
        Route::get('edit/{id}/{lid}', 'CategoryController@edit');
        Route::post('edit/{id}/{lid}', 'CategoryController@editPost');
        Route::post('delete/{id}/{lid}', 'CategoryController@delete');
        Route::post('delete/{id}/{lid}', 'CategoryController@delete');
        Route::post('categories_delimage','CategoryController@categories_delimage');
    });
    Route::resource('categories', 'CategoryController');
    Route::get('review','ReviewController@get');
    Route::get('visitor_records','ReviewController@visitor_records');
    Route::post('review/delete/{id}','ReviewController@delete_review');
    Route::get('report','ReportController@get');
    Route::post('report','ReportController@getdata');
    Route::post('report_details','ReportController@details');
    Route::get('edit_report/{id}','ReportController@edit');
    Route::post('edit_report/{id}','ReportController@update');
    Route::get('delete_report/{id}','ReportController@delete');
    Route::get('report/add','ReportController@showvendor');
    Route::post('report/add','ReportController@add');
    Route::get('report/add/sub','ReportController@sub_cat_ajax');
    Route::get('report/add/vendor','ReportController@vendor_ajax');
    // Route::get('report/add/otplisting','ReportController@otplisting_ajax');
    Route::get('report/add/vendorlist','ReportController@vendorlisting_data');
    //Product Group Management : STARTS
    Route::group(['prefix' => 'product'], function () {
        Route::get('add', 'ProductController@show');
        Route::post('add', 'ProductController@store');
        Route::get('edit/{id}', 'ProductController@edit');
        Route::post('edit/{id}', 'ProductController@update');
        Route::post('delete/{id}', 'ProductController@destroy');
        Route::get('category', 'ProductCategoryController@index');
        Route::get('category/add','ProductCategoryController@show');
        Route::post('category/add','ProductCategoryController@store');
        Route::get('category/edit/{id}','ProductCategoryController@edit');
        Route::post('category/edit/{id}','ProductCategoryController@update');
        Route::post('category/delete/{id}','ProductCategoryController@destroy');
        Route::get('product_searchh','ProductCategoryController@manage_product_cat');
        Route::post('product_del_image','ProductCategoryController@product_del_image');
        Route::post('product_delimage','ProductController@product_delimage');
    });
    Route::resource('product', 'ProductController');
      Route::get('product_search', 'ProductController@manage_product');
    //Product Group Management : ENDS
    // Inquiry Listing
    Route::get('inquirylisting', 'InquiryController@index');
    Route::post('inquirylisting', 'InquiryController@index');
    Route::post('export_inquirylisting','InquiryController@export');
    //Vendor Listing
    Route::group(['prefix' => 'vendorlisting'], function () {
        Route::post('/', 'InquiryController@index');
        Route::get('add', 'VendorListingController@show');
        Route::post('add', 'VendorListingController@create');
        Route::get('edit/{id}', 'VendorListingController@edit');
        Route::post('edit/{id}', 'VendorListingController@update');
        Route::post('delete/{id}', 'VendorListingController@destroy');
        Route::get('getProductCategory', 'VendorListingController@getProductCategory');
        Route::post('del_image','VendorListingController@del_image');
         
        Route::post('del_extravideo','VendorListingController@del_extravideo');

        Route::post('del_video','VendorListingController@del_video');
        Route::post('url_name','VendorListingController@check_url');
    });

    Route::post('vendorlisting/active_property/{id}','VendorListingController@active_property');
    Route::post('vendorlisting/inactive_property/{id}','VendorListingController@inactive_property'); 

    Route::resource('vendorlisting', 'VendorListingController');
    Route::get('slider_image','SliderImageController@slider');
    Route::post('slider_image','SliderImageController@add_slider');
    // OTP Listing
    Route::get('otplisting', 'OTPListingController@index');
    Route::post('otplisting', 'OTPListingController@index');
    Route::get('otplisting/audio/{id}', 'OTPListingController@upload_audio');
    Route::post('otplisting/audio/{id}', 'OTPListingController@add_audio');
    Route::get('otplisting/update', 'OTPListingController@update');
    Route::post('export_otplisting','OTPListingController@export');
    Route::get('public/uploads/audio/{id}','OTPListingController@audio');

    //Testimonials
    //Route::get('testimonial', 'TestimonialController@allTestimonial');
    // System Report
    Route::get('del_audio/{id}/{lid}','OTPListingController@del_audio');
    Route::get('del_audios/{id}','OTPListingController@del_audios');
    
    Route::get('edit_audios/{id}','OTPListingController@edit_audios');
    Route::post('edit_audios/{id}','OTPListingController@update_audios');


    Route::get('edit_audio/{id}/{lid}','OTPListingController@edit_audio');
    Route::post('edit_audio/{id}/{lid}','OTPListingController@update_audio');

    Route::get('otrlisting', 'OTRListingController@index');
    Route::get('system_keyword','SystemKeywordController@report');
    Route::post('system_keyword','SystemKeywordController@add_report');
    Route::get('numbers','SystemKeywordController@manage_numbers');
    Route::post('numbers','SystemKeywordController@add_numbers');
    Route::get('search','FileController@manage_city');
    Route::get('managescitys','FileController@index');
    Route::get('managescitys/create_cities','FileController@create_cities');
    //Route::post('managescitys/create_cities','UsersController@add_cities');
    Route::post('managescitys/delete/{id}','FileController@delete_city');
    Route::post('managescitys/active_city/{id}','FileController@active_city');
    Route::post('managescitys/inactive_city/{id}','FileController@inactive_city');
    Route::get('area','TaskController@manage_city');
    Route::get('managesareas','TaskController@index');
    Route::get('managesareas/create_cities','TaskController@create_cities');
    //Route::post('managescitys/create_cities','UsersController@add_cities');
    Route::post('managesareas/delete/{id}','TaskController@delete_city');
    Route::post('managesareas/active_city/{id}','TaskController@active_city');
    Route::post('managesareas/inactive_city/{id}','TaskController@inactive_city');
    // CMS
    Route::get('manage_cms','CmsController@index');
    Route::get('manage_cms/add','CmsController@create_cms');
    Route::post('manage_cms/add','CmsController@add_cms');
    Route::get('manage_cms/edit/{id}', 'CmsController@edit_cms');
    Route::post('manage_cms/edit/{id}', 'CmsController@update_cms');
    //skill labor
    Route::get('skill_search','ReviewController@manage_skill');
     Route::get('deleted_skilllabor', 'ReviewController@deleted_skilllabor');
    Route::get('skill_labors','ReviewController@index');
    Route::get('skill_labors/delete/{id}', 'ReviewController@delete_skill');
    Route::get('skill_labors/restore/{id}', 'ReviewController@restore_skill');
    Route::get('skill_labors/add', 'ReviewController@create_skill');
    Route::post('skill_labors/add', 'ReviewController@add_skill');
    Route::get('skill_labors/edit/{id}', 'ReviewController@edit_skill');
    Route::post('skill_labors/edit/{id}', 'ReviewController@update_skill');
    Route::post('add_image','SliderImageController@add');

    Route::get('contact_detail','ContactPageController@index');
    Route::get('add_contact_detail','ContactPageController@create');
    Route::post('add_contact_detail','ContactPageController@add_contact');
    Route::get('edit_contact_detail/{id}','ContactPageController@edit_contact');
    Route::post('edit_contact_detail/{id}','ContactPageController@update_contact');

    Route::get('general_setting','GeneralsettingController@index');
    Route::get('edit_general_setting/{id}','GeneralsettingController@edit_setting');
    Route::post('edit_general_setting/{id}','GeneralsettingController@update_setting');

     Route::get('manage_property_list','PropertyController@index');
    Route::get('manage_property_list/add', 'PropertyController@create_property');
    Route::post('manage_property_list/add', 'PropertyController@add_property');
   
    Route::post('manage_property_list/delete/{id}','PropertyController@delete_property');
    Route::get('manage_property_list/edit/{id}', 'PropertyController@edit_property');
    Route::post('manage_property_list/edit/{id}', 'PropertyController@update_property');

    //Manage Product Listing
    Route::get('manage_product_list','ProductListingController@index');
    Route::get('manage_product_list/add', 'ProductListingController@create_property');
    Route::post('manage_product_list/add', 'ProductListingController@add_property');
    
    Route::post('manage_product_list/delete/{id}','ProductListingController@delete');
    Route::get('manage_product_list/edit/{id}', 'ProductListingController@edit_property');
    Route::post('manage_product_list/edit/{id}', 'ProductListingController@update_property');

    Route::get('manage_popular_categories','Popular_CategoriesController@index');
    Route::get('manage_popular_categories/add', 'Popular_CategoriesController@create_popular');
    Route::post('manage_popular_categories/add', 'Popular_CategoriesController@add_popular');   
    Route::post('manage_popular_categories/delete/{id}','Popular_CategoriesController@delete');
    Route::get('manage_popular_categories/edit/{id}', 'Popular_CategoriesController@edit_popular');
    Route::post('manage_popular_categories/edit/{id}', 'Popular_CategoriesController@update_popular');
	
	Route::group(['prefix' => 'state'], function () {
        Route::get('states', 'StateController@data');
        Route::get('add', 'StateController@add');
        Route::post('add', 'StateController@addState');
        Route::get('edit/{id}', 'StateController@editState');
        Route::post('edit/{id}', 'StateController@editPostState');
        Route::post('delete/{id}', 'StateController@delete');
    });
    Route::get('state_search','StateController@state_search');
    Route::resource('state', 'StateController');
	
	//cities
	
	
	Route::group(['prefix' => 'cities'], function () {
        Route::get('cities', 'CitiesController@data');
        Route::get('add', 'CitiesController@add');
        Route::post('add', 'CitiesController@addCities');
        Route::get('edit/{id}', 'CitiesController@editCities');
        Route::post('edit/{id}', 'CitiesController@editPostCities');
        Route::post('delete/{id}', 'CitiesController@delete');
    });
    Route::get('cities_search','CitiesController@search_cities');
    Route::resource('cities', 'CitiesController');

	Route::group(['prefix' => 'sub_cities'], function () {
        Route::get('sub_cities', 'SubCitiesController@data');
        Route::get('add', 'SubCitiesController@add');
        Route::post('add', 'SubCitiesController@addSubCities');
        Route::get('edit/{id}', 'SubCitiesController@editSubCities');
        Route::post('edit/{id}', 'SubCitiesController@editPostSubCities');
        Route::post('delete/{id}', 'SubCitiesController@delete');
    });
    Route::get('sub_cities_search','SubCitiesController@search_sub_cities');
    Route::resource('sub_cities', 'SubCitiesController');
	
	
	
	Route::group(['prefix' => 'areas'], function () {
        Route::get('areas', 'AreasController@data');
        Route::get('add', 'AreasController@add');
        Route::post('add', 'AreasController@addAreas');
        Route::get('edit/{id}', 'AreasController@editAreas');
        Route::post('edit/{id}', 'AreasController@editPostAreas');
        Route::post('delete/{id}', 'AreasController@delete');
    });
    Route::get('areas_search','AreasController@search_areas');
    Route::resource('areas', 'AreasController');
	
	
	Route::get('getState','CitiesController@getStateByCountry');
	Route::get('getCity','CitiesController@getCityByState');
	Route::get('getSubCity','CitiesController@getSubCityByCity');
	
    
	
});
# Remaining pages will be called from below controller method
# in real world scenario, you may be required to define all routes manually
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('{name?}', 'JoshController@showView');
});

    


#FrontEndController
Route::get('login', 'FrontEndController@getLogin')->name('login');
Route::post('login', 'FrontEndController@postLogin')->name('login');
Route::get('register', 'FrontEndController@getRegister')->name('register');
Route::post('register','FrontEndController@postRegister')->name('register');
Route::get('becomevendor', 'FrontEndController@getVRegister')->name('vregister');
Route::post('becomevendor','FrontEndController@postVRegister')->name('vregister');
 Route::get('quickquote', 'FrontEndController@view');
 Route::post('quickquote','FrontEndController@sendMail');
Route::get('activate/{userId}/{activationCode}','FrontEndController@getActivate')->name('activate');
Route::get('forgot-password','FrontEndController@getForgotPassword')->name('forgot-password');
Route::post('forgot-password', 'FrontEndController@postForgotPassword');
Route::get('/forgot-password/email', 'FrontEndController@postForgotPasswordemail');
Route::get('what_we_do',function (){
    return view('What_We_Do');
});
Route::get('cookies_policy',function (){
    return view('Cookies_Policy');
});
Route::get('partner',function (){
    return view('Partner');
});
Route::get('blogs',function (){
    return view('Blogs');
});
#Social Logins
Route::get('facebook', 'Admin\FacebookAuthController@redirectToProvider');
Route::get('facebook/callback', 'Admin\FacebookAuthController@handleProviderCallback');
Route::get('linkedin', 'Admin\LinkedinAuthController@redirectToProvider');
Route::get('linkedin/callback', 'Admin\LinkedinAuthController@handleProviderCallback');
Route::get('google', 'Admin\GoogleAuthController@redirectToProvider');
Route::get('google/callback', 'Admin\GoogleAuthController@handleProviderCallback');
//Route::get('twitter', 'Admin\TwitterAuthController@redirectToProvider');
//Route::get('twitter/callback', 'Admin\TwitterAuthController@handleProviderCallback');
# Forgot Password Confirmation
Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
Route::get('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@getForgotPasswordConfirm')->name('forgot-password-confirm');
# My account display and update details
Route::group(['middleware' => 'user'], function () {
    Route::put('my-account', 'FrontEndController@update');
    Route::get('my-account', 'FrontEndController@myAccount')->name('my-account');
});
Route::get('logout', 'FrontEndController@getLogout')->name('logout');
# contact form
Route::post('contact', 'FrontEndController@postContact')->name('contact');
#frontend views
Route::get('/', 'HomePageController@view');
/*Route::get('/', ['as' => 'home', function () {
    return view('home');
}]);*/
Route::get('blog','BlogController@index')->name('blog');
Route::get('blog/{slug}/tag', 'BlogController@getBlogTag');
Route::get('blogitem/{slug?}', 'BlogController@getBlog');
Route::post('blogitem/{blog}/comment', 'BlogController@storeComment');
//news
Route::get('news', 'NewsController@index')->name('news');
Route::get('news/{news}', 'NewsController@show')->name('news.show');
Route::get('getareas','ServicesDetailController@getCityList');
Route::get('/', [ 'as' => 'homepage', 'uses' => 'HomePageController@view' ]);
Route::get('/about', [ 'as' => 'about', 'uses' => 'AboutController@view' ]);
Route::get('/privacy-policy', [ 'as' => 'about', 'uses' => 'AboutController@view1']);
Route::get('/terms_of_use', [ 'as' => 'terms_of_use', 'uses' => 'AboutController@view2']);
Route::get('/services', [ 'as' => 'services', 'uses' => 'AboutController@view3']);
Route::group(['prefix'=>'services','as'=>'services.'], function(){
    Route::get('/properties', ['as' => 'properties', 'uses' => 'ServicesController@view']);
    Route::get('/consultancy', ['as' => 'consultancy', 'uses' => 'ServicesController@view']);
    Route::get('/contractor', ['as' => 'contractor', 'uses' => 'ServicesController@view']);
    Route::get('/material', ['as' => 'material', 'uses' => 'ServicesController@view']);
    Route::get('/skill labour', ['as' => 'skill labour', 'uses' => 'ServicesController@view']);
});
//Contact us
Route::post('/contact-us', [ 'as' => 'contactus', 'uses' => 'ContactUsController@sendMail']);
Route::get('services/detail', ['as' => 'servicedetail', 'uses' => 'ServicesDetailController@view']);
Route::get('/contact-us', [ 'as' => 'contactus', 'uses' => 'ContactUsController@view' ]);
Route::get('/login', [ 'as' => 'login', 'uses' => 'LoginController@view' ]);
Route::get('/signup', [ 'as' => 'signup', 'uses' => 'SignUpController@view' ]);
//search all content
Route::get('listing', [ 'as' => 'listing', 'uses' => 'ListingController@listing' ]);
Route::get('detail/{listingid}/', [ 'as' => 'detail', 'uses' => 'ListingController@detaillisting' ]);
Route::get('detail/{listingid}/{listingname}', [ 'as' => 'detail', 'uses' => 'ListingController@listingProduct' ]);
Route::get('allproducts/{listingid}/', [ 'as' => 'detail', 'uses' => 'ListingController@all_product_detaillisting' ]);
Route::post('detail/{listingid}/', [ 'as' => 'detail', 'uses' => 'ListingController@sendMail' ]);
Route::get('/otp/{lemail}/{lid}', [ 'as' => 'detail', 'uses' => 'ListingController@otpMail' ]);
Route::get('/otpverified/{otpval}/{lid}', [ 'as' => 'detail', 'uses' => 'ListingController@otpVerification' ]);
Route::get('wishlist','WishListController@index');
Route::get('product_detail/{vl_id}/{id}', 'ListingController@product_detail');
Route::get('category_products/{vl_id}/{id}', 'ListingController@category_products');
Route::get('skill_labour_detail/{vl_id}/{id}', 'ListingController@skill_detail');
//Ajax Call
Route::get('getType','ServicesDetailController@getTypeListAjax');
Route::get('getSelectionInfo','HomePageController@getSelectionInfoAjax');
Route::get('otpAdd/add/{name}/{phone}/{l_id}','HomePageController@updateUserOTPInfoAjax');
Route::get('otpVerify/{otp}/{phone}/{l_id}','HomePageController@updateUserOTPVerifyAjax');
Route::get('updateCount','HomePageController@updateViewedCountAjax');
Route::get('{name?}', 'FrontEndController@showFrontEndView');
Route::post('otradd_form','HomePageController@updateUserOTRInfo');
Route::post('check_phone','HomePageController@check_phone');
//areas
# End of frontend views