<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

/*Home*/
Route::get('/', 'Blog\HomeController@getHome');

Route::post('/visita', 'VisitaController@store')->name('post_visita');

//Routes Auth
Route::get('/login',                                'ConnectController@getLogin')                   ->name('login');
Route::post('/login',                               'ConnectController@postLogin')                  ->name('login');
Route::get('/login/{driver}',                        'ConnectController@redirectToProvider')         ->name('redirectToProvider');
Route::get('/login/{driver}/callback',               'ConnectController@handleProviderCallback')     ->name('handleProviderCallback');
Route::get('/recover',                              'ConnectController@getRecover')                 ->name('recovery');
Route::post('/recover',                             'ConnectController@postRecover')                ->name('recovery');
Route::get('/reset',                                'ConnectController@getReset')                   ->name('reset');
Route::post('/reset',                               'ConnectController@postReset')                  ->name('reset');
Route::get('/register',                             'ConnectController@getRegister')                ->name('register');
Route::post('/register',                            'ConnectController@postRegister')               ->name('register');
Route::get('/logout',                               'ConnectController@getLogout')                  ->name('logout');
Route::get('/verification',                         'ConnectController@getVerification')                 ->name('verification');
Route::post('/verification',                        'ConnectController@postVerification')                ->name('verification');

/*User-actions*/
Route::get('/account/edit',                         'UserController@getAccountEdit')                ->name('account_edit');
Route::post('/account/avatar/edit',                 'UserController@postAccountAvatar')             ->name('account_avatar_edit');
Route::get('/account/avatar/deleted/{id}',          'Blog\HomeController@postDeletedAvatar')        ->name('account_avatar_edit');
Route::post('/account/password/edit',               'UserController@postPasswordEdit')              ->name('account_password_edit');
Route::post('/account/info/edit',                   'UserController@postInfoEdit')                  ->name('account_info_edit');
Route::get('/user-profile/{id}',                    ['uses' => 'UserController@user_profile',                           'as'=> 'user-profile']);
Route::get('/user-edit/{id}',                       ['uses' => 'UserController@user_edit',                              'as'=> 'user-edit']);
Route::post('/user-edit/{id}',                      ['uses' => 'UserController@user_edit',                              'as'=> 'user-edit']);
Route::post('/user-delete/{id}',                      ['uses' => 'UserController@user_delete',                              'as'=> 'user-delete']);

/*SERVICES*/
Route::get('/politicas/{slug}',                       ['uses' => 'Blog\HomeController@getAboutUs',   'as'=> 'politicas',]);

/*Articles*/
Route::get('/seccion/{category}',                         'Blog\HomeController@getCategories')                 ->name('articles');
Route::get('/seccion/{category}/{id}',                  'Blog\HomeController@getModule')                 ->name('article');

// APIS GET SEARCH
Route::get('/categories/search',                        'Blog\ApiController@getCategorySearch')          ->name('getCategorySearch');
Route::get('/tags/search',                              'Blog\ApiController@getTagSearch')          ->name('getTagSearch');

Route::post('/descargar-contacto',                  'Blog\HomeController@pdf_contacto')             ->name('pdf.contacto');

Route::get('/autocomplete', 'Blog\HomeController@findsubcategories');

Route::get('/technic/change-status/{id}',              'Blog\HomeController@changeTechnicStatus');

Route::get('/articles/exportar-excel', 'Blog\HomeController@exportarExcel')->name('articles.exportExcel');

