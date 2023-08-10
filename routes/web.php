<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/employees', "EmployeeController@index")->name('employees');
Route::get('/employees/create', "EmployeeController@create")->name('employees.create');
Route::post('/employees/store','EmployeeController@store')->name('employees.store');
Route::get('/employees/{id}','EmployeeController@edit')->name('employees.edit');
Route::post('/employees/update/{id}','EmployeeController@update')->name('employees.update'); 
Route::get('/employees/show/{slug}', "EmployeeController@show")->name('employees.show');
Route::get('/employees/destroy/{id}', "EmployeeController@destroy")->name('employees.destroy');

Route::get('/search','EmployeeController@search');
Route::post('/upload_profile_image','EmployeeController@upload_profile_image')->name('employees.upload_profile_image');

//employee_vacation_requests
Route::get('/employee_vacation_requests', "EmployeeVacationRequestController@index")->name('employees.employee_vacation_requests');
Route::get('/employee_vacation_requests/create', "EmployeeVacationRequestController@create")->name('employee_vacation_requests.create');
Route::post('/employee_vacation_requests/store','EmployeeVacationRequestController@store')->name('employee_vacation_requests.store');
Route::get('/employee_vacation_requests/{id}','EmployeeVacationRequestController@edit')->name('employee_vacation_requests.edit');
Route::post('/employee_vacation_requests/update/{id}','EmployeeVacationRequestController@update')->name('employee_vacation_requests.update'); 
Route::get('/employee_vacation_requests/show/{slug}', "EmployeeVacationRequestController@show")->name('employee_vacation_requests.show');
Route::get('/employee_vacation_requests/destroy/{id}', "EmployeeVacationRequestController@destroy")->name('employee_vacation_requests.destroy');
 
//Official holidays
Route::get('/countryofficialholidays', "CountryOfficialHolidaysDatesController@index")->name('countryofficialholidays');
Route::get('/countryofficialholidays/create', "CountryOfficialHolidaysDatesController@create")->name('countryofficialholidays.create');
Route::post('/countryofficialholidays/store','CountryOfficialHolidaysDatesController@store')->name('countryofficialholidays.store');