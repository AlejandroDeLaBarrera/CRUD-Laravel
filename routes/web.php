<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::resource('customers', CustomerController::class);
    });
});

// Endpoint para obtener customers relacionados con hobbie
Route::get('hobbies/{id}/customers', function($id) {
    $customers = App\Models\Customer::whereHas('hobbies', function ($query) use ($id) {
        $query->where('hobbies.id', $id);
    })->get(['name', 'surname']);

    return response()->json($customers);
});

require __DIR__.'/auth.php';
