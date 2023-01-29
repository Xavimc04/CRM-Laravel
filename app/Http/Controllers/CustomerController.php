<?php

namespace App\Http\Controllers;
use App\Models\Customer;
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
        $customers = Customer::where('name', 'like', '%' . $request->input('filter') . '%')->get();

        return view('home', compact('customers')); 
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
            return redirect()->back()->with('message', 'The fields must be filled in')->withInput(); 
        }

        $canCreate = Customer::where('email', $request->input('email') || 'identifier', $request->input('identifier'))->first(); 

        if($canCreate) {
            return redirect()->back()->with('message', 'Email or identifier already in use')->withInput(); 
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
}
