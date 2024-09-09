<?php

use App\Http\Controllers\DonationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DiscardedBookController;
use App\Http\Controllers\InventoryController;
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

    // Inventario libros
    Route::get('inventory_create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory_store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/index_inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('inventories/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::post('inventory/{bookId}/descarted', [InventoryController::class, 'descarted'])->name('inventory.descarted');
    Route::get('/export-inventory', [InventoryController::class, 'exportInventario'])->name('export.inventory');
    Route::post('/import-inventory', [InventoryController::class, 'importInventario'])->name('import.inventory');
});
