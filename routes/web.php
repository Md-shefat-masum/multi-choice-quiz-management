<?php

use Illuminate\Support\Facades\Auth;
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

Route::redirect('/', '/login');;

Auth::routes();
Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => '/admin', 'middleware' => ['admin'], 'namespace' => 'Admin'], function () {
        Route::get('/', 'AdminController@index');

        Route::get('/candidate-list', 'AdminController@candidate_list');
        Route::get('/candidates', 'AdminController@candidates');
        Route::post('/candidate/{user}/delete', 'AdminController@delete');
        Route::get('/candidate/{user}/accept', 'AdminController@accept');
        Route::get('/candidate/{user}/reject', 'AdminController@reject');
        Route::post('/get-user-submission/{quiz}/{render_html}/{user}', 'AdminController@get_user_submission');

        Route::group(['prefix' => 'quiz'], function () {
            Route::get('/', 'QuizController@index')->name('quiz_index');
            Route::get('/details/{quiz}', 'QuizController@details')->name('quiz_details');
            Route::get('/question-append/{quiz}', 'QuizController@question_append')->name('quiz_question_append');
            Route::get('/create', 'QuizController@create')->name('quiz_create');
            Route::post('/store', 'QuizController@store')->name('quiz_store');
            Route::post('/attach-quiz-question-store', 'QuizController@attach_quiz_question_store')->name('attach_quiz_question_store');
            Route::get('/edit/{quiz}', 'QuizController@edit')->name('quiz_edit');
            Route::post('/update', 'QuizController@update')->name('quiz_update');
            Route::post('/soft-delete', 'QuizController@soft_delete')->name('quiz_soft_delete');
            Route::post('/delete', 'QuizController@delete')->name('quiz_delete');
        });

        Route::group(['prefix' => 'question'], function () {
            Route::get('/', 'QuestionController@index')->name('question_index');
            Route::get('/json', 'QuestionController@json')->name('question_json');
            Route::post('/json-by-id', 'QuestionController@json_by_id')->name('question_json_by_id');
            Route::get('/single-question/{id}', 'QuestionController@find_single_question')->name('question_find_single_question');
            Route::get('/create', 'QuestionController@create')->name('question_create');
            Route::post('/store', 'QuestionController@store')->name('question_store');
            Route::get('/edit/{question}', 'QuestionController@edit')->name('question_edit');
            Route::post('/update', 'QuestionController@update')->name('question_update');
            Route::post('/soft-delete', 'QuestionController@soft_delete')->name('question_soft_delete');
            Route::post('/delete', 'QuestionController@delete')->name('question_delete');
        });
    });

    Route::group(['prefix' => '/user', 'middleware' => ['user'], 'namespace' => 'User'], function () {
        Route::get('/', 'UserController@index');
        Route::post('/get-quiz/{quiz}', 'UserController@get_quiz')->name('user_get_quiz');
        Route::post('/get-quiz-result/{quiz}', 'UserController@get_quiz_result')->name('user_get_quiz_result');
        Route::post('/submit-quiz', 'UserController@submit_quiz')->name('user_submit_quiz');

        Route::get('/t/{id}/{q}', 'UserController@user_quiz_submission');
    });

    Route::get('/user-details-modal/{user}','User\UserController@user_details_modal')->name('user_details_modal');
    Route::get('/user-info-get/{user}','User\UserController@user_information_get')->name('user_information_get');
    Route::post('/user-info-update/{user}','User\UserController@user_information_update')->name('user_information_update');
});

Route::get('/data-reload', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true]);
    // \Illuminate\Support\Facades\Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations', '--force' => true]);
    // \Illuminate\Support\Facades\Artisan::call('passport:install');
    return redirect('/');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
