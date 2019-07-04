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
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity']], function () {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@show',
    ]);
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    // Da su dung thu muc symbol link public/storage/... nen khong dung route nay
    // Route::get('images/profile/{id}/avatar/{image}', [
    //     'uses' => 'ProfilesController@userProfileAvatar',
    // ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('php', 'AdminDetailsController@listPHPInfo');
    Route::get('routes', 'AdminDetailsController@listRoutes');

    // crawler
    Route::get('steal', 'CrawlerController@steal');

    // upload images by links list
    Route::get('uploadimages', 'CrawlerController@uploadImages');
    Route::post('uploadimages', 'CrawlerController@uploadImagesAction');

    // sitemap
    Route::get('gensitemap', 'UtilityController@gensitemap');

    // clear all cache & views
    Route::get('clearallstorage', 'UtilityController@clearallstorage');

    // config
    Route::resource('configs', 'ConfigsController');

    // ads
    Route::group(['prefix' => 'ads'], function () {
        Route::post('updateStatus', 'AdsController@updateStatus');
    });
    Route::resource('ads', 'AdsController');

    // posttags
    Route::group(['prefix' => 'posttags'], function () {
        Route::post('updateStatus', 'PostTagsController@updateStatus');
    });
    Route::resource('posttags', 'PostTagsController');

    // posttypes
    Route::group(['prefix' => 'posttypes'], function () {
        Route::post('updateStatus', 'PostTypesController@updateStatus');
    });
    Route::resource('posttypes', 'PostTypesController');

    // postseries
    Route::group(['prefix' => 'postseries'], function () {
        Route::post('updateStatus', 'PostSeriesController@updateStatus');
    });
    Route::resource('postseries', 'PostSeriesController');

    // postchaps
    Route::group(['prefix' => 'postchaps'], function () {
        Route::post('callUpdatePosition', 'PostChapsController@callUpdatePosition');
        Route::post('callUpdateStatus', 'PostChapsController@callUpdateStatus');
        Route::post('callDelete', 'PostChapsController@callDelete');
        Route::post('updateStatus', 'PostChapsController@updateStatus');
    });
    Route::resource('postchaps', 'PostChapsController');
    
    // posts
    Route::group(['prefix' => 'posts'], function () {
        Route::post('callUpdateType', 'PostsController@callUpdateType');
        Route::post('callUpdateStatus', 'PostsController@callUpdateStatus');
        Route::post('callDelete', 'PostsController@callDelete');
        Route::post('updateStatus', 'PostsController@updateStatus');
    });
    Route::resource('posts', 'PostsController');

});


// Homepage Route
Route::get('contact', 'WelcomeController@contact');

Route::post('paging', 'WelcomeController@paging');

Route::post('rating', 'WelcomeController@rating');

Route::post('contact', 'WelcomeController@send');

Route::get('sitemap.xml', 'WelcomeController@sitemap');

Route::get('livesearch', 'WelcomeController@livesearch');

Route::get('search', 'WelcomeController@search');

Route::get('/', 'WelcomeController@welcome')->name('welcome');

Route::get('anh-dep', 'WelcomeController@picture');

Route::get('truyen-tranh', 'WelcomeController@manga');

Route::get('chu-de/{slug}', 'WelcomeController@seri');

Route::get('tag/{slug}', 'WelcomeController@tag');

Route::get('the-loai/{slug}', 'WelcomeController@type');

Route::get('{slug1}/{slug2}', 'WelcomeController@page2');

Route::get('{slug}', 'WelcomeController@page');
