<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Service; 

class ServiceController extends Controller
{
    public function get() {
        $services = Service::all(); 
        return view('services', compact('services')); 
    }

    public function create(Request $request) {
        if(!$request->filled('name') || !$request->filled('price')) {
            return redirect()->back()->with('error', 'All params need to be filled to create any package'); 
        }

        $doesExist = Service::where('name', $request->input('name'))->first(); 

        if(!$doesExist) {
            $created = Service::create([
                'name'     => $request->input('name'), 
                'price'    => $request->input('price'),  
            ]); 

            if($created) {
                return redirect('/services'); 
            } else {
                return redirect()->back()->with('error', 'Error while creating package'); 
            }
        } else {
            return redirect()->back()->with('error', 'This package already exist'); 
        }
    }
}
