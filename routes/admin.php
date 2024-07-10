<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->group(function () {
    Route::get('/', 'Admin\DashboardController@getDashboard')->name('dashboard');

    // Module Users
    Route::get('/users/{status}', 'Admin\UserController@getUsers')->name('users_list');
    Route::get('/user/{id}/edit', 'Admin\UserController@getUserEdit')->name('user_edit');
    Route::post('/user/{id}/edit', 'Admin\UserController@postUserEdit')->name('user_edit');
    Route::get('/user/{id}/banned', 'Admin\UserController@getUserBanned')->name('user_banned');
    Route::get('/user/{id}/permissions', 'Admin\UserController@getUserPermissions')->name('user_permissions');
    Route::post('/user/{id}/permissions', 'Admin\UserController@postUserPermissions')->name('user_permissions');

    // Module Carousels
    Route::get('/carousels', 'Admin\CarouselsController@getHome')->name('carousels');
    Route::post('/carousel/add', 'Admin\CarouselsController@postCarouselAdd')->name('carousel_add');
    Route::get('/carousel/{id}/edit', 'Admin\CarouselsController@getCarouselEdit')->name('carousel_edit');
    Route::post('/carousel/{id}/edit', 'Admin\CarouselsController@postCarouselEdit')->name('carousel_edit');
    Route::get('/carousel/{id}/delete', 'Admin\CarouselsController@getCarouselDelete')->name('carousel_delete');

    // Module Artists
    Route::get('/artists/{slug}', 'Admin\ArtistController@getHome')->name('artists');
    Route::get('/artist/add', 'Admin\ArtistController@getArtistAdd')->name('artist_add');
    Route::post('/artist/add', 'Admin\ArtistController@postArtistAdd')->name('artist_add');
    Route::get('/artist/{id}/edit', 'Admin\ArtistController@getArtistEdit')->name('artist_edit');
    Route::post('/artist/{id}/edit', 'Admin\ArtistController@postArtistEdit')->name('artist_edit');
    Route::get('/artist/{id}/show', 'Admin\ArtistController@getArtistShow')->name('artists');
    Route::get('/artist/{id}/delete', 'Admin\ArtistController@getArtistDelete')->name('artist_delete');

    // Module Tags
    Route::get('/tags', 'Admin\TagController@getHome')->name('tags');
    Route::post('/tag/add', 'Admin\TagController@postTagAdd')->name('tag_add');
    Route::get('/tag/{id}/edit', 'Admin\TagController@getTagEdit')->name('tag_edit');
    Route::post('/tag/{id}/edit', 'Admin\TagController@postTagEdit')->name('tag_edit');
    Route::get('/tag/{id}/delete', 'Admin\TagController@getTagDelete')->name('tag_delete');

    // Module Category
    Route::get('/categories', 'Admin\CategoryController@getHome')->name('categories');
    Route::post('/category/add', 'Admin\CategoryController@postCategoryAdd')->name('category_add');
    Route::get('/category/{id}/edit', 'Admin\CategoryController@getCategoryEdit')->name('category_edit');
    Route::post('/category/{id}/edit', 'Admin\CategoryController@postCategoryEdit')->name('category_edit');
    Route::get('/category/{id}/delete', 'Admin\CategoryController@getCategoryDelete')->name('category_delete');

    // Module Technics
    Route::get('/technics', 'Admin\TechnicController@getHome')->name('technics');
    Route::post('/technic/add', 'Admin\TechnicController@postTechnicAdd')->name('technic_add');
    Route::get('/technic/{id}/edit', 'Admin\TechnicController@getTechnicEdit')->name('technic_edit');
    Route::post('/technic/{id}/edit', 'Admin\TechnicController@postTechnicEdit')->name('technic_edit');
    Route::get('/technic/{id}/delete', 'Admin\TechnicController@getTechnicDelete')->name('technic_delete');

    // Module CorporateArea
    Route::get('/company', 'Admin\CorporateAreaController@getHome')->name('company');
    Route::get('/company/{slug}', 'Admin\CorporateAreaController@getCompanyEdit')->name('company_edit');
    Route::post('/company/{slug}/edit', 'Admin\CorporateAreaController@postCompanyEdit')->name('company_edit');

    // Module Article
    Route::get('/articles/{slug}', 'Admin\ArticleController@getHome')->name('articles');
    Route::get('/article/add', 'Admin\ArticleController@getArticleAdd')->name('article_add');
    Route::post('/article/add', 'Admin\ArticleController@postArticleAdd')->name('article_add');
    Route::get('/article/{id}/edit', 'Admin\ArticleController@getArticleEdit')->name('article_edit');
    Route::post('/article/{id}/edit', 'Admin\ArticleController@postArticleEdit')->name('article_edit');
    Route::get('/article/{id}/delete', 'Admin\ArticleController@getArticleDelete')->name('article_delete');
    Route::get('/article/{id}/restore', 'Admin\ArticleController@getArticleRestore')->name('article_delete');
    Route::post('/article/{id}/gallery/add/{gallery}', 'Admin\ArticleController@postArticleGalleryAdd')->name('article_edit');
    Route::get('/article/{slug}/gallery/{id}/delete', 'Admin\ArticleController@getArticleGalleryDelete')->name('article_edit');

    // Module News
    Route::get('/news/{slug}', 'Admin\NewController@getHome')->name('news');
    Route::get('/new/add', 'Admin\NewController@getNewAdd')->name('new_add');
    Route::post('/new/add', 'Admin\NewController@postNewAdd')->name('new_add');
    Route::get('/new/{id}/edit', 'Admin\NewController@getNewEdit')->name('new_edit');
    Route::post('/new/{id}/edit', 'Admin\NewController@postNewEdit')->name('new_edit');
    Route::get('/new/{id}/show', 'Admin\NewController@getNewShow')->name('news');
    Route::get('/new/{id}/delete', 'Admin\NewController@getNewDelete')->name('new_delete');
    Route::get('/new/{id}/restore', 'Admin\NewController@getNewRestore')->name('new_delete');
    Route::post('/new/{id}/gallery/add/{gallery}', 'Admin\NewController@postNewGalleryAdd')->name('new_edit');
    Route::get('/new/{slug}/gallery/{id}/delete', 'Admin\NewController@getNewGalleryDelete')->name('new_edit');

    // Module Projects
    Route::get('/projects/{slug}', 'Admin\ProjectController@getHome')->name('projects');
    Route::get('/project/add', 'Admin\ProjectController@getProjectAdd')->name('project_add');
    Route::post('/project/add', 'Admin\ProjectController@postProjectAdd')->name('project_add');
    Route::get('/project/{id}/edit', 'Admin\ProjectController@getProjectEdit')->name('project_edit');
    Route::post('/project/{id}/edit', 'Admin\ProjectController@postProjectEdit')->name('project_edit');
    Route::get('/project/{id}/show', 'Admin\ProjectController@getProjectShow')->name('projects');
    Route::get('/project/{id}/delete', 'Admin\ProjectController@getProjectDelete')->name('project_delete');
    Route::get('/project/{id}/restore', 'Admin\ProjectController@getProjectRestore')->name('project_delete');
    Route::post('/project/{id}/gallery/add/{gallery}', 'Admin\ProjectController@postProjectGalleryAdd')->name('project_edit');
    Route::get('/project/{slug}/gallery/{id}/delete', 'Admin\ProjectController@getProjectGalleryDelete')->name('project_edit');

    // Module Projects
    Route::get('/massive_modifications', 'Admin\MassiveController@getHome')->name('massives');
    Route::post('/upload-csv', 'Admin\MassiveController@uploadCsv')->name('massive_add');
    Route::post('/upload-avatars', 'Admin\MassiveController@uploadAvatars')->name('massive_add');
    Route::post('/upload-massive', 'Admin\MassiveController@uploadMassiveArticle')->name('massive_add');
});
