<?php

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
// Home Page Route
Route::get('/', function () {
    return view('home');
});

Route:: view('about', 'about');

Route::get('contact', function(){
	return view('contact');
});

Route::get('features', function(){
	return view('features');
});




Route:: get('customers', 'CustomersController@index');
Route:: get('customers/create', 'CustomersController@create');

Route:: get('add-customers', function(){
	return view('internals/add-customers');
});

//Route for adding customers to table using Post
Route:: post('customer', 'CustomersController@store');
Route::get('customers/{customer}', 'CustomersController@show');
Route::get('customers/{customer}/edit', 'CustomersController@edit');
Route::patch('customers/{customer}', 'CustomersController@update');
Route::delete('customers/{customer}', 'CustomersController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');





Route::get('plans', function(){
	return view('users/plans');
});

Route::get('vote', function(){
	return view('users/vote');
});


Route:: get('admin', 'BatchAController@index');
Route:: get('admin/createBatchA', 'BatchAController@create');

/*Route::get('create-batchA', function(){
	return view('admin/createBatchA');
});*/

Route:: post('batchA', 'BatchAController@store');
Route::get('admin/{value}', 'BatchAController@show');
Route::get('admin/{value}/edit', 'BatchAController@edit');
Route::patch('admin/{value}', 'BatchAController@update');
Route::delete('admin/{value}', 'BatchAController@destroy');


//ROUTE FOR VOTERS
Route:: post('votesDetails', 'HomeController@votesDetails');


//PAYSTACK CONFIG
//Route:: get('user/vote', 'PaymentController@confirmDetails');
Route:: post('vote', 'PaymentController@confirmDetails');

//Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay'); 

Route::get('/verify/{reference}', 'VotersController@verify');
//Route::get('/verify/{reference}', 'AdminController@verify');


// Laravel 5.1.17 and above
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay'); 

Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
