<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Customer; 
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function get($identifier) {
        $roles = Role::where('identifier', $identifier)->get(); 

        return $roles; 
    }

    public function add(Request $request) {
        if(!$request->filled('name') || !$request->filled('color')) {
            return redirect()->back()->with('error', 'All arguments must to be filled'); 
        }

        $created = Role::create([
            'identifier' => $request->input('identifier'), 
            'role' => $request->input('name'), 
            'color' => $request->input('color')
        ]); 

        if($created) {
            return redirect()->back(); 
        } else {
            return redirect()->back()->with('error', 'Error while deleting customer role'); 
        }
    }

    public function delete($roleId) {
        $deleted = Role::where('id', $roleId)->delete(); 

        if($deleted) {
            return redirect()->back(); 
        } else {
            return redirect()->back()->with('error', 'Error while deleting customer role'); 
        }
    } 
}
