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
use App\Http\Controllers\notificationController;
use App\Http\Controllers\ManagePeopleController;
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

    //Yash's Routes check before modify or delete
    Route::get('/index', function () {
        return view('dashboard.index');
    })->name('index');

    Route::get('/Campaign', function () {
        return view('campaign.add');
    })->name('Campaign');

    Route::get('/Campaign-List', function () {
        return view('campaign.list');
    })->name('CampaignList');

    Route::get('/campaign.dashboard', function () {
        return view('campaign.dashboard');
    })->name('CampaignDetails');

    Route::get('/customer', function () {
        return view('customer.add');
    })->name('customer');

    Route::get('/CampaignSummary', function () {
        return view('campaign.summery');
    })->name('CampaignSummary');


    // Route::get('/manage-people', function () {
    //     return view('manage-people');
    // })->name('manage-people');

    Route::get('/add-category', function () {
        return view('add-category');
    })->name('add-category');

    Route::get('/add-subCategory', function () {
        return view('add-subCategory');
    })->name('add-subCategory');


    Route::get('/category-information', function () {
        return view('category-information');
    })->name('category-information');
    // End of Yash's route



    // For People Management
    Route::get('/manage-people', [ManagePeopleController::class, 'index'])->name('manage-people');
    Route::post('/manage-people/store', [ManagePeopleController::class, 'store'])->name('manage-people-store');

    // For Team Management
    // Route::get('/Manage-people', [TeamController::class, 'managePeople'])->name('manage-people');
    // Route::get('/create-team', [TeamController::class, 'create'])->name('create-team');

    //Category Management
    Route::post('/Add-Category', [CategoryController::class, 'AddCategory'])->name('AddCategory');
    Route::post('/Add-Publisher', [CategoryController::class, 'AddPublisher'])->name('AddPublisher');
    Route::post('/Add-Type', [CategoryController::class, 'AddType'])->name('AddType');

    //Flight Management
    Route::get('/flight/create/{id}', [FlightController::class, 'create'])->name('flight-create'); //Updated
    Route::get('/flight/edit/{id}', [FlightController::class, 'edit'])->name('flight-edit'); //Updated
    Route::post('/flight/update', [FlightController::class, 'update'])->name('flight-update'); //Updated
    Route::post('/flight/delete', [FlightController::class, 'delete'])->name('flight-delete'); //Updated
    Route::post('/getFlightData', [FlightController::class, 'getFlightData'])->name('getFlightData');
    Route::post('/flight/connection/delete', [FlightController::class, 'deleteConnection'])->name('flight-connection-delete'); //Updated
    Route::post('/flight/connection/category/delete', [FlightController::class, 'deleteConnectionCategory'])->name('flight-connection-category-delete'); //Updated

    //Assets Management
    Route::get('/asset/create/{id}', [AssetsController::class, 'AssetsSetup'])->name('assets-create'); //Updated
    Route::post('/getInputFields', [AssetsController::class, 'getInputFields'])->name('getInputFields');
    Route::post('/getEditInputFields', [AssetsController::class, 'getEditInputFields'])->name('getEditInputFields');
    Route::post('/getPublisherAdType', [AssetsController::class, 'getPublisherAdType'])->name('getPublisherAdType');
    Route::post('/asset/store', [AssetsController::class, 'store'])->name('assets-store');
    Route::get('/asset/edit/{id}', [AssetsController::class, 'edit'])->name('assets-edit'); //Updated
    Route::post('/asset/update', [AssetsController::class, 'update'])->name('assets-update'); //Updated
    Route::get('/fetch-advertisement-types/{categoryMasterId}', [AssetsController::class, 'fetchAdvertisementTypes']);

    //Campaign Managemnet
    Route::get('/', [CampaignController::class, 'index'])->name('index'); //Updated
    Route::get('/campaign/view/{id}', [CampaignController::class, 'show'])->name('campaign-show'); //Updated
    Route::post('/imageUpdate', [CampaignController::class, 'imageUpdate'])->name('imageUpdate'); //Updated
    Route::post('/imageUpdateTragetThumbnail', [CampaignController::class, 'imageUpdateTragetThumbnail'])->name('imageUpdateTragetThumbnail'); //Updated
    Route::post('/getCategoryName', [CategoryController::class, 'getCategoryName'])->name('getCategoryName'); //Updated

    //Asstes parameter Management
    Route::put('/campaign/asset/store/{id}/{language}/{type}/{Adtype}', [AssetParametersController::class, 'AssetsStore'])->name('AssetsStore'); //Updated
    Route::get('/campaign/asset/manage/{id}/{language}/{type}/{flight_id}', [AssetParametersController::class, 'assetsManage'])->name('assetsManage'); //Updated
    Route::get('/campaign/asset/build/{id}/{language}/{type}/{Adtype}/{AssetId}', [AssetParametersController::class, 'AssetsBuilder'])->name('AssetsBuilder'); //Updated

    // Notification
    Route::get('/notification', [notificationController::class, 'index'])->name('notification');


    //Yash's Routes check before modify or delete
    Route::get('/redirectsummery', 'App\Http\Controllers\CampaignController@redirectsummery')->name('redirectsummery');
    Route::get('/billingInformation', 'App\Http\Controllers\CompanyController@billingInformation')->name('billingInformation');
    Route::resource('campaign', CampaignController::class); //Updated
    Route::resource('AssetParameters', AssetParametersController::class);
    Route::resource('User', UserController::class);
    Route::resource('Company', CompanyController::class);
    Route::resource('flight', FlightController::class); //Updated
    Route::resource('assets', AssetsController::class); //Updated
    Route::resource('ManageTeam', ManageTeamController::class);
    Route::resource('Team', TeamController::class);
    Route::resource('Category', CategoryController::class);
    // End of Yash's route
});
