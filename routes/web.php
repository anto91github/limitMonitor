<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WindowApproveController;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
});

Route::get('/about', function () {
    return view('about');
});

/**
 * Auth Routes
 */
Auth::routes(['verify' => false]);


Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::middleware('auth')->group(function () {
        /**
         * Home Routes
         */
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        /**
         * Role Routes
         */    
        Route::resource('roles', RolesController::class)->middleware(['must-it']);
        /**
         * Permission Routes
         */    
        Route::resource('permissions', PermissionsController::class);
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index')->middleware(['must-it']);
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });

        /**
         * Forms
         */
        Route::get('/form-client-limit', [App\Http\Controllers\ClientLimitController::class,'index'])->name('formclientlimit.index')->middleware(['must-rm']);
        Route::get('/form-client-limit-search', [App\Http\Controllers\ClientLimitController::class,'autocomplete'])->name('formclientlimit.autocomplete');
        Route::post('/form-client-limit', [App\Http\Controllers\ClientLimitController::class,'store'])->name('formclientlimit.store');
        Route::get('/form-client-limit/{client}/edit', [App\Http\Controllers\ClientLimitController::class, 'edit'])->name('formclientlimit.edit');

        Route::get('/form-client-order', [App\Http\Controllers\ClientOrderController::class,'index'])->name('formclientorder.index')->middleware(['must-dcm']);
        Route::get('/form-client-order-getsett', [App\Http\Controllers\ClientOrderController::class,'getsett'])->name('formclientorder.getsett');
        Route::post('/form-client-order', [App\Http\Controllers\ClientOrderController::class,'store'])->name('formclientorder.store');
        /**
         * Windows
         */
        Route::group(['prefix' => 'window-approve'], function() {
            Route::get('/', [App\Http\Controllers\WindowApproveController::class, 'index'])->name('window-approve.index')->middleware(['must-rm-or-rmwolmt']);
            Route::patch('/update/{orderId}', [WindowApproveController::class, 'changeStatus']);
        });
         

        Route::group(['prefix' => 'window-order'], function() {
            Route::get('/',[App\Http\Controllers\WindowOrderController::class, 'index'])->name('window.index');
        });

        Route::get('/client-position', [App\Http\Controllers\ClientPositionController::class, 'index'])->name('client-position.index');
        Route::get('/client-transactions', [App\Http\Controllers\ClientTransactionController::class, 'index'])->name('client.transactions');
        Route::get('/trade-transactions', [App\Http\Controllers\TradeTransactionController::class, 'index'])->name('trade.transactions');
        Route::put('/client-position/{client}/delete', [App\Http\Controllers\ClientPositionController::class, 'delete'])->name('clientposition.delete');
        
    });
});
