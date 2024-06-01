<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('testing', 'BackendController@testing');

Route::get('/', 'FrontendController@index');
Route::redirect('/index', '/');

Route::get('/modules', 'FrontendController@modules');
Route::get('/module-details/{slug}', 'FrontendController@moduledetails');
Route::get('/module-chapter/{slug}/{id}', 'FrontendController@modulechapter');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', 'FrontendController@logout');
});

Route::group(['middleware' => ['guest']], function() {
    Route::get('/signup', 'FrontendController@signup');
    Route::post('/signup/post', 'FrontendController@signuppost');
    Route::get('/signup/verify/{code}', 'FrontendController@signupverify');
    Route::post('/signup/verify/post', 'FrontendController@signupverifypost');
    Route::get('/signin/verify/{code}', 'FrontendController@signinverify');
    Route::post('/signin/verify/post', 'FrontendController@signinverifypost');
    Route::get('/signin', 'FrontendController@login');
    Route::post('/signin/post', 'FrontendController@signinpost');
});


Route::group(['middleware' => ['auth.admin']], function() {
    Route::group(['prefix'=>'manage/console/'], function () {
    	Route::get('/dashboard',[
            'as' => 'dashboard',
            'uses' => 'BackendController@dashboard'
        ]);

        Route::get('/logout',[
            'as' => 'logout',
            'uses' => 'BackendController@logout'
        ]);

        Route::get('/myprofile',[
            'as' => 'myprofile',
            'uses' => 'BackendController@myprofile'
        ]);

        Route::post('/savemyprofile',[
            'as' => 'savemyprofile',
            'uses' => 'BackendController@savemyprofile'
        ]);

        Route::get('/changepassword',[
            'as' => 'changepassword',
            'uses' => 'BackendController@changepassword'
        ]);

        Route::post('/savechangepassword',[
            'as' => 'savechangepassword',
            'uses' => 'BackendController@savechangepassword'
        ]);

    });


    //Users
    Route::resource('users', 'UserController');
    Route::get('user/view',[
        'as' => 'userview',
        'uses' => 'UserController@userview'
    ]);

    //Online Users
    Route::get('online/users', 'UserController@onlineusers');
    Route::get('online/users/view',[
        'as' => 'onlineuserview',
        'uses' => 'UserController@onlineuserview'
    ]);

    // faq
    Route::get('faq/create', [ 'as' => 'faq.create', 'uses' => 'MasterController@faqcreate']);
    Route::post('faq/save', [ 'as' => 'faq.save', 'uses' => 'MasterController@faqsave']);
    Route::get('faqs', ['as' => 'faq.view', 'uses' => 'MasterController@faqview']);
    Route::get('faq/view', [ 'as' => 'faq.list', 'uses' => 'MasterController@faqlist']);
    Route::get('faq/edit/{id}', [ 'as' => 'faq.edit', 'uses' => 'MasterController@faqedit']);
    Route::post('faq/update', [ 'as' => 'faq.update', 'uses' => 'MasterController@faqupdate']);

    Route::get('admin/module/create', [ 'as' => 'module.create', 'uses' => 'ModuleController@modulecreate']);
    Route::get('admin/modules', ['as' => 'modules.view', 'uses' => 'ModuleController@moduleview']);
    Route::get('admin/module/view', [ 'as' => 'modules.list', 'uses' => 'ModuleController@modulelist']);
    Route::post('admin/module/save', [ 'as' => 'admin.module.save', 'uses' => 'ModuleController@modulesave']);
    Route::get('admin/module/edit/{id}', [ 'as' => 'admin.module.edit', 'uses' => 'ModuleController@moduleedit']);
    Route::post('admin/module/update', [ 'as' => 'admin.module.update', 'uses' => 'ModuleController@moduleupdate']);
    Route::post('admin/module/chapter/add', [ 'as' => 'admin.module.chapter.add', 'uses' => 'ModuleController@addmodulechapter']);

   
    //Blogs
    Route::group(['prefix' => 'blogs/'], function(){
        //Posts
        Route::get('/post/view',[
            'as' => 'viewpost',
            'uses' => 'BlogController@viewpost'
        ]);

        Route::get('/getpost',[
            'as' => 'getpost',
            'uses' => 'BlogController@getpost'
        ]);

        Route::get('/post/add',[
            'as' => 'addpost',
            'uses' => 'BlogController@addpost'
        ]);

        Route::post('/post/save',[
            'as' => 'savepost',
            'uses' => 'BlogController@savepost'
        ]);

        Route::get('/post/edit/{id}',[
            'as' => 'editpost',
            'uses' => 'BlogController@editpost'
        ]);

        Route::post('/post/update',[
            'as' => 'updatepost',
            'uses' => 'BlogController@updatepost'
        ]);

        Route::get('/post/delete',[
            'as' => 'deletepost',
            'uses' => 'BlogController@deletepost'
        ]);
    });

    //Media Module
        Route::resource('media', 'MediaController');
        Route::post('medias/status',[
            'as' => 'media.status',
            'uses' => 'MediaController@updatemediastatus'
        ]);

        Route::get('medias/template',[
            'as' => 'media.template',
            'uses' => 'MediaController@mediatemplate'
        ]);

        Route::get('medias/data/search',[
            'as' => 'media.data.search',
            'uses' => 'MediaController@searchmediadata'
        ]);

        Route::post('medias/upload',[
            'as' => 'media.upload',
            'uses' => 'MediaController@mediaupload'
        ]);

    //Cms

    Route::get('cms/page/template/{id}',[
        'as' => 'cms.page.template',
        'uses' => 'CmsController@cmspagetemplate'
    ]);

    Route::get('cms/page/content/{id}',[
        'as' => 'cms.page.content',
        'uses' => 'CmsController@cmspagecontent'
    ]);

    // Route::get('cms/page/addcopycontent/{id}',[
    //     'as' => 'cms.page.addcopycontent',
    //     'uses' => 'CmsController@addcmspagecopycontent'
    // ]);

    Route::get('cms/page',[
        'as' => 'cms.page',
        'uses' => 'CmsController@cmspage'
    ]);

    Route::post('cms/page/contenttemplate',[
        'as' => 'cms.page.contenttemplate',
        'uses' => 'CmsController@contenttemplate'
    ]);

    Route::post('cms/page/contenttemplate/updateposition',[
        'as' => 'cms.page.contenttemplate.updateposition',
        'uses' => 'CmsController@contenttemplateposition'
    ]);

    Route::post('cms/page/addcustomfields',[
        'as' => 'cms.page.addcustomfields',
        'uses' => 'CmsController@addcustomfields'
    ]);

    Route::post('cms/page/addcustomfieldssection',[
        'as' => 'cms.page.addcustomfieldssection',
        'uses' => 'CmsController@addcustomfieldssection'
    ]);

    Route::post('cms/page/removecustomfieldssection',[
       'as' => 'cms.page.removecustomfieldssection',
        'uses' => 'CmsController@removecustomfieldssection'
    ]);

    Route::post('cms/page/editcustomfieldssingle',[
       'as' => 'cms.page.editcustomfieldssingle',
        'uses' => 'CmsController@editcustomfieldssingle'
    ]);

    Route::post('cms/page/removecustomfieldssingle',[
       'as' => 'cms.page.removecustomfieldssingle',
        'uses' => 'CmsController@removecustomfieldssingle'
    ]);

    Route::post('cms/page/content/update',[
        'as' => 'cms.page.content.update',
        'uses' => 'CmsController@cmscontentupdate'
    ]);


    Route::get('/getdashboardinfo', 'BackendController@getdashboardinfo');

});

Route::group(['middleware' => ['guest']], function() {
    Route::group(['prefix'=>'manage/console/'], function () {

    	Route::get('/login',[
            'as' => 'login',
            'uses' => 'BackendController@login'
        ]);

        Route::post('/savelogin',[
            'as' => 'savelogin',
            'uses' => 'BackendController@savelogin'
        ]);

        Route::post('/loginwithotp',[
            'as' => 'loginwithotp',
            'uses' => 'BackendController@loginwithotp'
        ]);
    });
});