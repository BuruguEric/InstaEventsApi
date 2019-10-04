<?php

use App\Http\Controllers\CoreLogs;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

////////////////////////// CMS Hospital routes ////////////////////////////////////

//Main (Home) Page
Route::get('/','Home@index');

//Theme Error Page For Front-end

//Default Error Page
Route::get('error','CoreErrors@index'); //Default Error Page
Route::get('error/permission', ['uses' =>'CoreErrors@open'])->name('error/permission'); //Custom Error Page

//Administrator
Route::get('dashboard','CoreMains@index');

//Users
Route::get('users', 'CoreUsers@index')->name('users'); //Manage
Route::get('users/open/{value}', ['uses' =>'CoreUsers@open'])->name('users/open'); //Create New (Access OPEN)
Route::match(['get','post'],'users/edit/{value}', ['uses' =>'CoreUsers@edit'])->name('users/edit'); //Edit
Route::match(['get','post'],'users/valid/{value}', ['uses' =>'CoreUsers@valid'])->name('users/valid'); //Validate & Multiple (bulk)

//Blogs

//Blog Tags

//Blog Categories

//Pages

//Settings
Route::get('settings/open/{value}', ['uses' =>'CoreSettings@open'])->name('settings/open'); //Settings
Route::match(['get','post'],'settings/valid/{value}', ['uses' =>'CoreSettings@valid'])->name('settings/valid'); //Settings Update

//Levels
Route::get('level', 'CoreLevels@index')->name('level'); //Manage
Route::get('level/open/{value}', ['uses' =>'CoreLevels@open'])->name('level/open'); //Create New (Access OPEN)
Route::match(['get','post'],'level/edit/{value}', ['uses' =>'CoreLevels@edit'])->name('level/edit'); //Edit
Route::match(['get','post'],'level/valid/{value}', ['uses' =>'CoreLevels@valid'])->name('level/valid'); //Validate & Multiple (bulk)

//Login
Route::get('admin', 'CoreLogs@index')->name('admin'); //Login Page
Route::match(['get','post'],'admin/{value}', ['uses' =>'CoreLogs@valid'])->name('admin/valid'); //Login Verification

//Sub Profile

//AutoFields
Route::get('autofields', 'CoreAutoFields@index')->name('autofields'); //Manage
Route::get('autofields/open/{value}', ['uses' =>'CoreAutoFields@open'])->name('autofields/open'); //Create New (Access OPEN)
Route::match(['get','post'],'autofields/edit/{value}', ['uses' =>'CoreAutoFields@edit'])->name('autofields/edit'); //Edit
Route::match(['get','post'],'autofields/valid/{value}', ['uses' =>'CoreAutoFields@valid'])->name('autofields/valid'); //Validate & Multiple (bulk)

//Extensions

//CustomFields
Route::get('customfields', 'CoreCustomFields@index')->name('customfields'); //Manage
Route::get('customfields/open/{value}', ['uses' =>'CoreCustomFields@open'])->name('customfields/open'); //Create New (Access OPEN)
Route::match(['get','post'],'customfields/edit/{value}', ['uses' =>'CoreCustomFields@edit'])->name('customfields/edit'); //Edit
Route::match(['get','post'],'customfields/valid/{value}', ['uses' =>'CoreCustomFields@valid'])->name('customfields/valid'); //Validate & Multiple (bulk)

//Inheritance
Route::get('inheritances', 'CoreInheritance@index')->name('inheritances'); //Manage
Route::get('inheritances/open/{value}', ['uses' =>'CoreInheritance@open'])->name('inheritances/open'); //Create New (Access OPEN)
Route::match(['get','post'],'inheritances/edit/{value}', ['uses' =>'CoreInheritance@edit'])->name('inheritances/edit'); //Edit
Route::match(['get','post'],'inheritances/valid/{value}', ['uses' =>'CoreInheritance@valid'])->name('inheritances/valid'); //Validate & Multiple (bulk)

/////////////////////////// CONTROLS //////////////////////////


/////////////////////////// EXTENSIONS //////////////////////////

//Extension Doctors
Route::get('doctors', 'ExtensionDoctorsAccount@index')->name('doctors'); //Manage
Route::get('doctors/open/{value}', ['uses' =>'ExtensionDoctorsAccount@open'])->name('doctors/open'); //Create New (Access OPEN)
Route::match(['get','post'],'doctors/edit/{value}', ['uses' =>'ExtensionDoctorsAccount@edit'])->name('doctors/edit'); //Edit
Route::match(['get','post'],'doctors/valid/{value}', ['uses' =>'ExtensionDoctorsAccount@valid'])->name('doctors/valid'); //Validate & Multiple (bulk)

Route::get('owners', 'ExtensionOwnersAccount@index')->name('owners'); //Manage
Route::get('owners/open/{value}', ['uses' =>'ExtensionOwnersAccount@open'])->name('owners/open'); //Create New (Access OPEN)
Route::match(['get','post'],'owners/edit/{value}', ['uses' =>'ExtensionOwnersAccount@edit'])->name('owners/edit'); //Edit
Route::match(['get','post'],'owners/valid/{value}', ['uses' =>'ExtensionOwnersAccount@valid'])->name('owners/valid'); //Validate & Multiple (bulk)

/////////////////////////END IN-BUILT ROUTES ///////////////////
