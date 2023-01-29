<?php

use Illuminate\Support\Facades\Route;  
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController; 

// @ Only authorized
Route::group(['middleware' => 'auth'], function() {
    // @ Customers
    Route::get('/', [CustomerController::class, 'get']);    
    Route::post('/', [CustomerController::class, 'create'])->name('customer-create');  

    // @ Logout
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
}); 

// @ Login
Route::get('/login', function() {
    if(Auth::check()) {
        return redirect('/'); 
    } else {
        return view('auth/login'); 
    }
})->name('login'); 

Route::post('/login', [AccountController::class, 'validateCredentials'])->name('validate-credentials'); 

// @ Register
Route::get('/register', [AccountController::class, 'get'])->name('register-redirect');   
Route::post('/register', [AccountController::class, 'create'])->name('register-account'); 