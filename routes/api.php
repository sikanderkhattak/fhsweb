<?php



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;



/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

*/

Route::post('/login', 'App\Http\Controllers\API\Auth\UserController@login');

Route::post('/signup', 'App\Http\Controllers\API\Auth\UserController@register');
route::post('/forgetPassword', 'App\Http\Controllers\API\Auth\UserController@forget_password');




Route::middleware(['auth:sanctum'])->group(function ()  {

    Route::post('/details', 'App\Http\Controllers\API\Auth\UserController@details');
     Route::post('/update_profile', 'App\Http\Controllers\API\Auth\UserController@update_profile');
    route::post('/change_password', 'App\Http\Controllers\API\Auth\UserController@change_password');
     

});




Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
       Artisan::call('config:clear');
    return "Cache is cleared";
});




Route::get('user/verify/{token}', 'App\Http\Controllers\API\Auth\UserController@verify');

