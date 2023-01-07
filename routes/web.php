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

Route::get('/users', [UsersController::class, 'index']);
Route::get('/datatable/users', [UsersController::class, 'getUsers']);
Route::post('/users/add', [UsersController::class, 'addUser']);

Route::get('/users/roles', [UsersController::class, 'roles']);
Route::get('/datatable/roles', [UsersController::class, 'getRoles']);
Route::post('/users/roles/add', [UsersController::class, 'addRole']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::post('/profile/update/name', [ProfileController::class, 'editProfileName']);
Route::post('/profile/change/password', [ProfileController::class, 'changePassword']);
