<?php

use App\Http\Controllers\DonationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DiscardedBookController;
use App\Http\Controllers\InvenotryController;
use App\Http\Middleware\PreventBackHistoryMiddleware as PreventBackHistoryMiddleware;



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

Route::prefix('/')->group(function () {
    // Rutas para el login
    Route::get('/' , [AuthController::class, 'login'])->name('login');
    Route::post('/' , [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/logout' , [AuthController::class, 'logout'])->name('logout');

});


Route::group(['middleware' => PreventBackHistoryMiddleware::class], function () {
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('layout.homePage');
        })->name('dashboard');
    });


    Route::get('/dashboard2' , [UserController::class, 'layout'])->name('home');

    //user
    Route::get('/profile_Index', [UserController::class,'index_profile'])->name('profileEdit');
    Route::put('/update_profile', [UserController::class,'profile_update'])->name('user.profileUpdate');

    // donations
    Route::get('donations_Create', [DonationsController::class,'create'])->name('donations.create');
    Route::post('/donatios_store', [DonationsController::class, 'store'])->name('donations.store');
    Route::get('/donations_listing', [DonationsController::class, 'index' ])->name('donations.index');
    Route::get('donations/{donation}/edit', [DonationsController::class, 'edit'])->name('donations.edit');
    Route::put('donations/{donation}', [DonationsController::class, 'update'])->name('donations.update');
    Route::post('/restore/{id}', [DonationsController::class, 'restore'])->name('restore.book');
    Route::get('/table_donations', [DonationsController::class, 'index_table' ])->name('donations.table');
    Route::get('/export-donations', [DonationsController::class, 'exportDonations'])->name('export.donations');
    Route::post('/import-donations', [DonationsController::class, 'importDonations'])->name('import.donations');

    //descartar libro
    Route::get('/roleOut_index', [DiscardedBookController::class, 'index_discard'])->name('roleOut.index');
    Route::post('/discard/{id}', [DiscardedBookController::class, 'discard'])->name('discard.book');
    Route::delete('discardedBook/{discardedBook}', [DiscardedBookController::class, 'destroy'])->name('discard.destroy');
    Route::get('/table_discards', [DiscardedBookController::class, 'index_table' ])->name('discards.table');
    Route::get('/export-discards', [DiscardedBookController::class, 'exportDiscards'])->name('export.discard');
    Route::post('/import-discard', [DiscardedBookController::class, 'importDiscards'])->name('import.discard');

    // Inventario libros
    Route::get('inventory_create', [InvenotryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory_store', [InvenotryController::class, 'store'])->name('inventory.store');
    Route::get('/index_inventory', [InvenotryController::class, 'index'])->name('inventory.index');
    Route::get('inventories/{inventory}/edit', [InvenotryController::class, 'edit'])->name('inventory.edit');
    Route::put('inventories/{inventory}', [InvenotryController::class, 'update'])->name('inventory.update');
    Route::delete('inventory/{invenotry}', [InvenotryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/export-inventory', [InvenotryController::class, 'exportInventario'])->name('export.inventory');
    Route::post('/import-inventory', [InvenotryController::class, 'importInventario'])->name('import.inventory');
    Route::post('/donations/{id}/send-to-inventory', [DonationsController::class, 'send_to_inventory'])->name('donations.send_to_inventory');

});
