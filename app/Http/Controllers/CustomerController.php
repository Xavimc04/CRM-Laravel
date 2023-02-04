<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request; 

class CustomerController extends Controller
{
    // @ Get view with customer list
    public function get() { 
        $customers = Customer::all();
        return view('home', compact('customers')); 
    } 

    // @ Get filtered customers
    public function filter(Request $request) { 
        if($request->has('filter')){
            $customers = Customer::where(
                'name', 'like', '%' . $request->input('filter') . '%')
                ->orWhere(
                    'identifier', 'like', '%' . $request->input('filter') . '%'
                )->orWhere(
                    'phoneNumber', 'like', '%' . $request->input('filter') . '%'
                )->orWhere(
                    'email', 'like', '%' . $request->input('filter') . '%'
                )
            ->get();
            
            return view('home', compact('customers')); 
        }  
    }

    public function handleState(Request $request) {
        $doesExist = Customer::where('identifier', $request->input('identifier'))->first(); 

        if($doesExist) {
            $doesExist->active = !$doesExist->active; 
            $doesExist->update();
            
            return redirect()->back(); 
        } else {
            return redirect()->back()->with('error', 'An internal error has been appeared, this user does not exist...');
        }
    }

    // @ Customer create
    public function create(Request $request) { 
        if(
            !$request->filled('identifier') 
            || !$request->filled('name') 
            || !$request->filled('dob') 
            || !$request->filled('phone')
            || !$request->filled('email')
        ) {
            return redirect()->back()->with('error', 'The fields must be filled in')->withInput(); 
        }

        if(Customer::where('email', $request->input('email'))->first() || Customer::where('identifier', $request->input('identifier'))->first()) {
            return redirect()->back()->with('error', 'Email or identifier already in use')->withInput(); 
        } 
        
        try {
            $created = Customer::create([
                'name'        => $request->input('name'), 
                'identifier'  => $request->input('identifier'), 
                'dateOfBirth' => $request->input('dob'),   
                'phoneNumber' => $request->input('phone'),  
                'email'       => $request->input('email'),  
                'created_at'  => date('d-m-Y'),
            ]); 
            
            if($created){
                $request->session()->regenerate(); 

                return redirect()->intended('/'); 
            }
        } catch(Exception $err) {
            return $err; 
        }
    }

    // @ Single customer 
    public function getCustomer($identifier) { 
        $customer = Customer::where('identifier', $identifier)->first();
        $roles = Role::where('identifier', $identifier)->get(); 
        $tickets = Ticket::where('customerId', $identifier)->get(); 

        if(!$customer) {
            return redirect('/'); 
        }

        return view('customer', compact('customer', 'roles', 'tickets')); 
    }
}