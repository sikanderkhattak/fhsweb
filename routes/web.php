<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderImageController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ManagingpartnersController;




Route::get('/', function () {

    return view('welcome');

});



Route::get('/dashboard', function () {
   

    return view('dashboard');

    

})->middleware(['auth'])->name('dashboard');

Route::get('users','App\Http\Controllers\UserController@index')->middleware(['auth']);

Route::get('/my-profile','App\Http\Controllers\UserController@update_profile')->middleware(['auth']);

route::post('/user_update_profile','App\Http\Controllers\UserController@update_profile_store')->middleware(['auth']);

Route::get('user_add','App\Http\Controllers\UserController@create')->middleware(['auth']);

Route::post('user_store','App\Http\Controllers\UserController@store')->middleware(['auth']);

Route::post('user_edit','App\Http\Controllers\UserController@edit')->middleware(['auth']);

route::post('user_update','App\Http\Controllers\UserController@update')->middleware(['auth']);

route::get('/change-password','App\Http\Controllers\UserController@change_password')->middleware(['auth']);

route::post('/user-change-password','App\Http\Controllers\UserController@change_password_store')->middleware(['auth']);

route::post('schedules','App\Http\Controllers\ScheduleController@index')->name('schedules.index')->middleware(['auth']);




Route::get('roles','App\Http\Controllers\RoleController@index')->middleware(['auth']);

route::get('role_add','App\Http\Controllers\RoleController@create')->middleware(['auth']);

route::post('role_store','App\Http\Controllers\RoleController@store')->middleware(['auth']);

route::get('role-permissions/{id}','App\Http\Controllers\RoleController@show')->middleware(['auth']);

route::get('role-edit/{id}','App\Http\Controllers\RoleController@edit')->middleware(['auth']);

route::post('role-update','App\Http\Controllers\RoleController@update')->middleware(['auth']);


route::get('permissions','App\Http\Controllers\PermissionController@index')->middleware(['auth']);

Route::get('permission_add','App\Http\Controllers\PermissionController@create')->middleware(['auth']);

Route::post('permission_store','App\Http\Controllers\PermissionController@store')->middleware(['auth']);

route::get('user-forgot-password','App\Http\Controllers\PatientResetPasswordController@index');
route::post('user-change-password','App\Http\Controllers\PatientResetPasswordController@sendlink')->name('user.password.email');
route::get('/user/resetPassword/{_token}','App\Http\Controllers\UserResetPasswordController@changePassword');
route::post('/user/updatepassword','App\Http\Controllers\UserResetPasswordController@updatepassword')->name('user.password.update');
Route::resource('slider', SliderImageController::class);
Route::resource('schedules', ScheduleController::class);




require __DIR__.'/auth.php';








Route::get('/roles11','App\Http\Controllers\PermissionController@Permission');





Route::get('user/verify/{token}', 'App\Http\Controllers\UserController@verifyUser');





Route::resource('slider_images', SliderImageController::class);


Route::get('slider_images', [SliderImageController::class, 'index'])->name('slider.index');
Route::get('slider_images-create', [SliderImageController::class, 'create'])->name('slider.create');
Route::post('slider_images/store', [SliderImageController::class, 'store'])->name('slider_images.store');
Route::get('slider_images/edit/{id}', [SliderImageController::class, 'edit'])->name('slider_images.edit');
Route::put('slider_images/update/{id}', [SliderImageController::class, 'update'])->name('slider_images.update');


Route::resource('blogs', BlogController::class);

Route::get('/index', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/create', [BlogController::class, 'create'])->name('blogs.create');
Route::post('blogs-store', [BlogController::class, 'store'])->name('blogs-store');
Route::prefix('admin')->name('admin.')->group(function() {
 Route::resource('blogs', BlogController::class);});
Route::post('blogs-update/{id}', [BlogController::class, 'update'])->name('blogs.update');
   


Route::resource('managingpartners', ManagingpartnersController::class);

Route::get('/index', [ManagingpartnersController::class, 'index'])->name('managingpartners.index');
Route::get('/create', [ManagingpartnersController::class, 'create'])->name('managingpartners.create');
Route::post('managingpartners-store', [ManagingpartnersController::class, 'store'])->name('managingpartners-store');
Route::prefix('admin')->name('admin.')->group(function(){Route::resource('blogs', ManagingpartnersController::class);});
Route::post('managingpartners-update/{id}', [ManagingpartnersController::class, 'update'])->name('managingpartners.update');
   

