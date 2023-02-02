<?php

namespace App\Http\Controllers;
use App\Models\Ticket; 
use App\Models\Customer; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function getAllTickets() {

    }

    public function getCustomerTickets() {

    }

    public function getFilteredTickets() {

    }

    public function subToTicket(Request $request) {
        if(!$request->input('ticketId')) {
            return redirect()->back(); 
        }

        $ticket = Ticket::where('id', $request->input('ticketId'))->first(); 
        $ticket->subs = json_decode($ticket->subs); 

        foreach($ticket->subs as $sub) {
            if($sub == Auth::user()->name) {
                return redirect()->back(); 
            }
        }

        $ticket->subs = array($ticket->subs); 
        array_push($ticket->subs, Auth::user()->name); 
        $ticket->subs = json_encode($ticket->subs);
        $ticket->update(); 

        return redirect()->back(); 
    }

    public function getTicket($ticketId) {
        $ticket = Ticket::where('id', $ticketId)->first(); 

        if(!$ticket) {
            return redirect()->back(); 
        }

        $ticket->subs = json_decode($ticket->subs); 
        $customer = Customer::where('identifier', $ticket->customerId)->first(); 

        if(!$customer) {
            return redirect()->back()->with('error', 'This ticket isnt assigned to any customer'); 
        }

        return view('ticket', compact('ticket', 'customer'));
    }

    public function createNewTicket(Request $request) {
        $customer = Customer::where('identifier', $request->input('customer'))->first(); 

        if(!$request->input('title') || !$request->input('content')) {
            return redirect()->back()->with('error', 'All arguments must to be filled')->withInput(); 
        }

        if($customer) {
            $subs = array(Auth::user()->name); 

            $created = Ticket::create([
                'customerId' => $request->input('customer'), 
                'title' => $request->input('title'), 
                'description' => $request->input('content'), 
                'subs' => json_encode($subs)
            ]); 

            if($created) {
                return redirect('/tickets/' . $created->id); 
            } else {
                return redirect()->back()->with('error', 'Error while creating the ticket...'); 
            }
        } else {
            return redirect()->back()->with('error', 'Invalid customer identifier'); 
        }
    }

    public function alterTicket() {
        
    }
}
