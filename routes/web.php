<?php

use App\Http\Controllers\CreationPanelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Middleware\PreventBackHistoryMiddleware;

// Rutas para la autenticación
Route::prefix('/')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Grupo de rutas con middleware para prevenir el historial de retroceso
Route::middleware([PreventBackHistoryMiddleware::class])->group(function () {
    // Rutas protegidas por autenticación
    Route::middleware('auth')->group(function () {
        // Ruta al dashboard principal
        Route::get('/dashboard', function () {
            return view('layout.homePage');
        })->name('dashboard');

        // Ruta a otro dashboard
        Route::get('/dashboard2', [UserController::class, 'layout'])->name('home');

        // Rutas relacionadas con el perfil del usuario
        Route::prefix('profile')->group(function () {
            Route::get('/index', [UserController::class, 'index_profile'])->name('profileEdit');
            Route::put('/update', [UserController::class, 'profile_update'])->name('user.profileUpdate');
        });

        // Rutas relacionadas con el inventario de libros
        Route::prefix('inventory')->group(function () {
            Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
            Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');
            Route::get('/index', [InventoryController::class, 'index'])->name('inventory.index');
            Route::get('/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
            Route::put('/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
            Route::post('/{bookId}/descarted', [InventoryController::class, 'descarted'])->name('inventory.descarted');
            Route::get('/export', [InventoryController::class, 'exportInventario'])->name('export.inventory');
            Route::post('/import', [InventoryController::class, 'importInventario'])->name('import.inventory');
        });

        //Rutas relacionadas con el panel de creacion
        Route::prefix('panel')->group(function() {
            //Editorial
            Route::get('/editorial', [CreationPanelController::class, 'newEditorial'])->name('panel.editorial');
            //Athor
            Route::get('/author', [CreationPanelController::class, 'newAuthor'])->name('panel.author');
            //Clasificación
            Route::get('/classification', [CreationPanelController::class, 'newClassification'])->name('panel.classification');
            Route::put('/store/classification', [CreationPanelController::class, 'storeClassification'])->name('store.classification');
            Route::put('/{classificationId}/classification', [CreationPanelController::class, 'updateClassification'])->name('update.classification');


        });

        // Rutas relacionadas con libros descartados
        Route::get('/listing_discards', [InventoryController::class, 'listing_discards'])->name('listing.discards');

        // Rutas relacionadas con libros donados
        Route::get('/listing_donated', [InventoryController::class, 'listing_donated'])->name('listing.donated');
    });
});
