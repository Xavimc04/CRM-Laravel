<?php

use Illuminate\Support\Facades\Route;  
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController; 
use App\Http\Controllers\ServiceController; 
use App\Http\Controllers\RoleController; 
use App\Http\Controllers\TicketController; 

// @ Only authorized
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [CustomerController::class, 'get'])->name('main');       
    Route::post('/customer-create', [CustomerController::class, 'create'])->name('customer-create'); 
    Route::post('/filter', [CustomerController::class, 'filter'])->name('filter'); 

    Route::get('/customers/{identifier}', function($identifier) {
        $customer = new CustomerController(); 
        return $customer->getCustomer($identifier); 
    })->name('single-customer'); 

    Route::post('/customers/handleState', [CustomerController::class, 'handleState'])->name('handle-customer-state'); 

    Route::post('/role/create', [RoleController::class, 'add'])->name('role-create'); 

    Route::post('/roles/delete/${roleId}', function($roleId) {
        $role = new RoleController(); 
        return $role->delete($roleId); 
    })->name('role-delete'); 

    Route::get('/tickets', [TicketController::class, 'get'])->name('tickets'); 
    Route::post('/tickets/filter', [TicketController::class, 'filter'])->name('filter-tickets'); 

    Route::post('tickets/subscribers/add', [TicketController::class, 'subToTicket'])->name('subtiket');
    Route::post('tickets/state/toggle', [TicketController::class, 'alterTicketState'])->name('handleTicketState');
    Route::post('tickets/comment/add', [TicketController::class, 'createComment'])->name('createComment');

    Route::get('/tickets/{ticketId}', function($ticketId) {
        $ticket = new TicketController(); 
        return $ticket->getTicket($ticketId); 
    })->name('get-ticket'); 

    Route::post('/ticket/create', [TicketController::class, 'createNewTicket'])->name('create-ticket');

    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');

    Route::get('/services', [ServiceController::class, 'get'])->name('services'); 
    Route::post('/services', [ServiceController::class, 'create'])->name('create-package'); 
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