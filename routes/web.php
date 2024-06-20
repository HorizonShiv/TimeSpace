<?php

use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\ManageTeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AssetParametersController;
use App\Http\Controllers\LoginRegisterController;
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

Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/Login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/Register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::post('/logout', 'logout')->name('logout');
});


Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/index', function () {
        return view('index');
    })->name('index');

    Route::get('/Campaign', function () {
        return view('add-campaign');
    })->name('Campaign');

    Route::get('/Campaign-List', function () {
        return view('campaign-view');
    })->name('CampaignList');

    Route::get('/Campaign-details', function () {
        return view('campaign-details');
    })->name('CampaignDetails');

    Route::get('/customer', function () {
        return view('customer');
    })->name('customer');

    Route::get('/CampaignSummary', function () {
        return view('campaignSummery');
    })->name('CampaignSummary');


    Route::get('/manage-people', function () {
        return view('manage-people');
    })->name('manage-people');

    Route::get('/add-category', function () {
        return view('add-category');
    })->name('add-category');

    Route::get('/add-subCategory', function () {
        return view('add-subCategory');
    })->name('add-subCategory');


    Route::get('/category-information', function () {
        return view('category-information');
    })->name('category-information');



    Route::get('/fetch-advertisement-types/{categoryMasterId}', [AssetsController::class, 'fetchAdvertisementTypes']);

    Route::get('/', [CampaignController::class, 'index'])->name('index');
    Route::get('/Manage-people', [TeamController::class, 'managePeople'])->name('manage-people');

    Route::post('/Add-Category', [CategoryController::class, 'AddCategory'])->name('AddCategory');
    Route::post('/Add-Publisher', [CategoryController::class, 'AddPublisher'])->name('AddPublisher');
    Route::post('/Add-Type', [CategoryController::class, 'AddType'])->name('AddType');

    Route::get('/Assets/create/{id}', [AssetsController::class, 'AssetsSetup'])->name('assets-create');
    Route::get('/Flight/create/{id}', [FlightController::class, 'create'])->name('flight-create');

    Route::get('/Flight/edit/{id}', [FlightController::class, 'edit'])->name('flight-edit');
    Route::post('/Flight/update', [FlightController::class, 'update'])->name('flight-update');
    Route::post('/Flight/delete', [FlightController::class, 'delete'])->name('flight-delete');
    Route::post('/getFlightData', [FlightController::class, 'getFlightData'])->name('getFlightData');
    Route::post('/Flight/connection/delete', [FlightController::class, 'deleteConnection'])->name('flight-connection-delete');

    Route::get('/Campaign/show/{id}', [CampaignController::class, 'show'])->name('campaign-show');

    Route::post('/getInputFields', [AssetsController::class, 'getInputFields'])->name('getInputFields');
    Route::post('/getEditInputFields', [AssetsController::class, 'getEditInputFields'])->name('getEditInputFields');
    Route::post('/getPublisherAdType', [AssetsController::class, 'getPublisherAdType'])->name('getPublisherAdType');

    Route::post('/Assets/store', [AssetsController::class, 'store'])->name('assets-store');

    Route::get('/Assets/edit/{id}', [AssetsController::class, 'edit'])->name('assets-edit');
    Route::post('/Assets/update', [AssetsController::class, 'update'])->name('assets-update');



    Route::post('/imageUpdate', [CampaignController::class, 'imageUpdate'])->name('imageUpdate');
    Route::post('/imageUpdateTragetThumbnail', [CampaignController::class, 'imageUpdateTragetThumbnail'])->name('imageUpdateTragetThumbnail');


    Route::post('/getCategoryName', [CategoryController::class, 'getCategoryName'])->name('getCategoryName');
    Route::put('/Campaign/Assests/Store/{id}/{language}/{type}/{Adtype}', [AssetParametersController::class, 'AssetsStore'])->name('AssetsStore');


    Route::get('/Campaign/Assests/Manage/{id}/{language}/{type}/{flight_id}', [AssetParametersController::class, 'assetsManage'])->name('assetsManage');

    // Route::get('/redirectAwareness', 'App\Http\Controllers\CampaignController@redirectAwareness')->name('redirectAwareness');
    Route::get('/Campaign/Assests/Builder/{id}/{language}/{type}/{Adtype}/{AssetId}', [AssetParametersController::class, 'AssetsBuilder'])->name('AssetsBuilder');
    // Route::get('/redirectAssetsBuilder', 'App\Http\Controllers\CampaignController@redirectAssetsBuilder')->name('redirectAssetsBuilder');
    Route::get('/redirectCampaignSummery', 'App\Http\Con=trollers\CampaignController@redirectCampaignSummery')->name('redirectCampaignSummery');
    Route::get('/billingInformation', 'App\Http\Controllers\CompanyController@billingInformation')->name('billingInformation');






    Route::resource('Campaign', CampaignController::class);
    Route::resource('AssetParameters', AssetParametersController::class);
    Route::resource('User', UserController::class);
    Route::resource('Company', CompanyController::class);
    Route::resource('Flight', FlightController::class);
    Route::resource('Assets', AssetsController::class);
    Route::resource('ManageTeam', ManageTeamController::class);
    Route::resource('Team', TeamController::class);
    Route::resource('Category', CategoryController::class);
});
