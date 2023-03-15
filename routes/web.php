<?php

use App\Http\Controllers\Account\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Account\HomeController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\UsersController;
use App\Http\Controllers\Account\CountryController;
use App\Http\Controllers\Auth\RegisterDriverController;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Account\DriverController;
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
Route::controller(IndexController::class)->group(function(){
    Route::get('/', 'index');
    Route::get('find/drivers', 'drivers');
    Route::get('get/drivers', 'getDrivers');
    Route::get('index/search/countries', 'searchCountries');
    Route::get('index/search/vehicle_types', 'searchVehicleTypes');
});
    
Route::get('register/driver', [RegisterDriverController::class, 'index']);
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('search/countries', [CountryController::class, 'searchCountries']);

Route::controller(DriverController::class)->prefix('drivers')->group(function () {
    Route::get('/', 'drivers');
    Route::get('/datatable', 'getDrivers');
    Route::get('/view/{id}', 'driver');
    Route::get('/requests', 'driverRequests');
    Route::get('document/uploads/{id}', 'viewDocumentUpload');
    Route::post('review', 'driverReview');
    Route::get('/datatable/reviews/{id}', 'getDriverReviews');
});
Route::controller(DocumentController::class)->prefix('documents')->group(function(){
    Route::get('upload/{id}', 'viewDocumentsUpload');
    Route::get('all_documents', 'documents');
    Route::get('datatable/all_documents', 'getDocuments');
    Route::get('my_documents', 'myDocuments');
    Route::get('datatable/my_documents/{id}', 'getMyDocuments');
    Route::post('review', 'documentReview');
});

Route::controller(UsersController::class)->prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::get('/datatable/users', [UsersController::class, 'getUsers']);
    Route::post('/add', [UsersController::class, 'addUser']);

    Route::get('/roles', [UsersController::class, 'roles']);
    Route::get('/datatable/roles', [UsersController::class, 'getRoles']);
    Route::post('/roles/add', [UsersController::class, 'addRole']);
    Route::get('search/roles', [UsersController::class, 'searchRoles']);

    Route::get('/roles/view/{id}', [UsersController::class, 'viewRole']);
    Route::get('/permissions/search', [UsersController::class, 'searchPermissions']);
    Route::get('datatables/role/permissions/{id}', [UsersController::class, 'getRolePermissions']);
    Route::post('/role/permissions/add', [UsersController::class, 'addRolePermissions']);
});
Route::controller(SettingsController::class)->prefix('settings')->group(function () {
    Route::get('/countries', [CountryController::class, 'countries']);
    Route::get('/datatable/countries', [CountryController::class, 'getCountries']);
    Route::post('/countries/add', [CountryController::class, 'addCountry']);

    Route::get('/document_types', 'documentSettings');
    Route::post('document_type/add', 'addDocumentType');
    Route::get('/datatable/document_types', 'getDocumentTypes');
    Route::get('/document_types/view/{id}', 'viewDocumentType');
    Route::get('/document_types/datatable/view/roles/{id}', 'getDocumentTypeRoles');
    Route::post('/document_type/roles/add', 'addDocumentTypeRoles');

    Route::get('vehicle_types', 'vehicleTypes');
    Route::get('datatable/vehicle_types', 'getVehicleTypes');
    Route::post('vehicle_type/add', 'addVehicleType');

    Route::get('vehicle_types/view/{id}', 'viewVehicleType');

    Route::get('driver/vehicle_types', 'driverVehicleTypes');
    Route::get('driver/datatable/vehicle_types', 'getDriverVehicleTypes');
    Route::post('driver/vehicle_types/add', 'addDriverVehicleTypes');
});
Route::controller(ProfileController::class)->prefix('profile')->group(function () {
    Route::get('/','index');
    Route::post('/upload/picture', 'uploadProfilePicture');
    Route::post('/documents/upload', 'uploadDocuments');
    Route::get('/documents', 'getDocuments');
    Route::post('/documents/remove', 'removeDocument');
    Route::post('/update/name', 'editProfileName');
    Route::post('/change/password', 'changePassword');
});

