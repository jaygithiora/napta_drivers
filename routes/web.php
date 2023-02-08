<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Account\HomeController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\UsersController;
use App\Http\Controllers\Account\PermitController;
use App\Http\Controllers\Account\VehicleController;
use App\Http\Controllers\Account\CountryController;
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

Route::get('/', [IndexController::class, 'index']);
Route::get('index/search/countries', [IndexController::class, 'searchCountries']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('datatable/vehicles', [VehicleController::class, 'getVehicles']);
Route::post('vehicles/add', [VehicleController::class, 'addVehicle']);

Route::get('/vehicles/make', [VehicleController::class, 'vehicleMake']);
Route::get('datatable/vehicles/make', [VehicleController::class, 'getVehiclesMake']);
Route::post('vehicles/make/add', [VehicleController::class, 'addVehicleMake']);
Route::get('search/vehicles/make', [VehicleController::class, 'searchVehiclesMake']);

Route::get('/vehicles/models', [VehicleController::class, 'vehicleModels']);
Route::get('datatable/vehicles/models', [VehicleController::class, 'getVehiclesModel']);
Route::post('vehicles/model/add', [VehicleController::class, 'addVehicleModel']);
Route::get('search/vehicles/model', [VehicleController::class, 'searchVehiclesModel']);


Route::get('/vehicles/owners', [VehicleController::class, 'vehicleOwners']);

Route::get('/permits', [PermitController::class, 'permits']);

Route::get('/countries', [CountryController::class, 'countries']);
Route::get('datatable/countries', [CountryController::class, 'getCountries']);
Route::post('countries/add', [CountryController::class, 'addCountry']);
Route::get('search/countries', [CountryController::class, 'searchCountries']);

Route::controller(UsersController::class)->prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::get('/datatable/users', [UsersController::class, 'getUsers']);
    Route::post('/add', [UsersController::class, 'addUser']);

    Route::get('/roles', [UsersController::class, 'roles']);
    Route::get('/datatable/roles', [UsersController::class, 'getRoles']);
    Route::post('/roles/add', [UsersController::class, 'addRole']);

    Route::get('/roles/view/{id}', [UsersController::class, 'viewRole']);
    Route::get('/permissions/search', [UsersController::class, 'searchPermissions']);
    Route::get('datatables/role/permissions/{id}', [UsersController::class, 'getRolePermissions']);
    Route::post('/role/permissions/add', [UsersController::class, 'addRolePermissions']);
});

Route::controller(ProfileController::class)->prefix('profile')->group(function () {
    Route::get('/','index');
    Route::post('/update/name', 'editProfileName');
    Route::post('/change/password', 'changePassword');
});

