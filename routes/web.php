<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public contact routes (anyone can view the list)
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

// Protected contact routes (only authenticated users) - MUST come before the {contact} route
Route::middleware(['auth'])->group(function () {
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

// Public contact detail route (anyone can view individual contacts) - MUST come after specific routes
Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');

// Opcional: redirecionar a raiz para a lista de contatos
Route::get('/', function () {
    return redirect()->route('contacts.index');
});
