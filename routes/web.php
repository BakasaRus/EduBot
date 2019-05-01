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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/bot', 'BotController')->name('bot');

Route::bind('mailing', function ($value) {
    return \App\Mailing::withTrashed()->where('id', $value)->first() ?? abort(404);
});

Route::bind('subscriber', function ($value) {
    return \App\Subscriber::withTrashed()->where('id', $value)->first() ?? abort(404);
});

Route::model('list', \App\MailingList::class);

Route::resource('subscribers', 'SubscriberController')->only([
    'index', 'show'
]);
Route::resource('lists', 'MailingListController');
Route::resource('mailings', 'MailingController');
Route::post('mailings/{mailing}/send', 'MailingController@send')->name('mailings.send');

Route::resource('tests', 'TestController');
Route::resource('questions', 'QuestionController');

Route::patch('tests/{test}/change', 'TestController@change')->name('tests.change');
Route::get('subscribers/{subscriber}/tests/{test}', 'TestResultController@index')->name('tests.results.index');