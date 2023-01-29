<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User; 
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // @ Route get
    public function get() { 
        return view('auth/register'); 
    }

    // @ Logout
    public function logout() {
        Auth::logout(); 
        return redirect('/'); 
    }

    // @ Login
    public function validateCredentials(Request $request) {
        if( Auth::attempt([
            'email' => $request->input('email'), 
            'password' => $request->input('password')
        ])) {
            $request->session()->regenerate(); 

            return redirect()->intended('/'); 
        };
        
        return redirect()->back()->with('type', 'error')->with('message', 'This email or password does not exist')->onlyInput('email');
    }
    
    // @ Creating account
    public function create(Request $request) {   
        if(!$request->filled('email') || !$request->filled('name') || !$request->filled('password') || !$request->filled('repeated')){
            return redirect()->back()->with('type', 'error')->with('message', 'The fields must be filled in')->withInput(); 
        }

        if($request->input('password') != $request->input('repeated')){
            return redirect()->back()->with('type', 'error')->with('message', 'Password doesn\'t match')->withInput(); 
        }

        $isEmailInUse = User::where('email', $request->input('email'))->first(); 
        $isNameInUse = User::where('name', $request->input('name'))->first(); 

        if($isNameInUse) {
            return redirect()->back()->with('type', 'error')->with('message', 'Username already in use')->withInput(); 
        }

        if($isEmailInUse) {
            return redirect()->back()->with('type', 'error')->with('message', 'Email already in use')->withInput(); 
        }
        
        try {
            $created = User::create([
                'name'     => $request->input('name'), 
                'email'    => $request->input('email'), 
                'password' => Hash::make($request->input('password'))
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
