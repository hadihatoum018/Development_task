<?php

use Illuminate\Support\Facades\Route;

Route::get('{any}',function (){
    return view('vue');
})->where('any', '.*')->where('any', '^(?!api).*');

Route::group(['prefix'=>'api/v1'],function (){
    Route::post('/register',[\App\Http\Controllers\AuthController::class, 'registerAuth']);
    Route::post('/login',[\App\Http\Controllers\AuthController::class, 'loginAuth']);
    Route::get('/auth/check',[\App\Http\Controllers\AuthController::class, 'checkAuth']);
});
Route::group(['prefix'=>'api/v1','middleware'=>'auth'],function (){
    Route::get('/get/user/info',[\App\Http\Controllers\UserController::class, 'getUserInfo']);
    //Basic Info Navbar
    Route::get('/profile/info', [\App\Http\Controllers\UserController::class, 'getProfileInfo']);



    //Project
    Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'getProject']);
    Route::post('/add/project', [\App\Http\Controllers\ProjectController::class, 'addProject']);
    Route::get('/get/project/{id}', [\App\Http\Controllers\ProjectController::class, 'getSingleProject']);
    Route::put('/update/project', [\App\Http\Controllers\ProjectController::class, 'updateProject']);
    Route::delete('/delete/project/{id}', [\App\Http\Controllers\ProjectController::class, 'deleteProject']);

    //Profile
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'getProfile']);
    Route::post('/update/profile/pic',[\App\Http\Controllers\UserController::class, 'updateProfilePic']);
    Route::put('/update/profile', [\App\Http\Controllers\UserController::class, 'updateProfileInformation']);

    //Auth
    Route::get('/logout',[\App\Http\Controllers\AuthController::class, 'logout']);

});
