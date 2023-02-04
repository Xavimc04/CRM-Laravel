<?php

namespace App\Http\Controllers;
use App\Models\Ticket; 
use App\Models\Customer; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function get() {
        $tickets = DB::table('tickets')->simplePaginate(30); 
        return view('tickets', compact('tickets')); 
    }

    public function filter(Request $request) {
        if($request->has('filter')){
            $tickets = DB::table('tickets')->where(
                'customerId', 'like', '%' . $request->input('filter') . '%')
                ->orWhere(
                    'id', 'like', '%' . $request->input('filter') . '%'
                )
                ->simplePaginate(40);
            
            return view('tickets', compact('tickets')); 
        } 
    }

    public function createComment(Request $request) {
        if(!$request->filled('content')) {
            return redirect()->back(); 
        }

        $ticket = Ticket::where('id', $request->input('ticketId'))->first(); 

        if($ticket) {
            $TEMP_NOTES = []; 

            if($ticket->notes != null) {
                $TEMP_NOTES = json_decode($ticket->notes); 
            }

            array_push($TEMP_NOTES, [
                "content" => $request->input('content'), 
                "sender" => Auth::user()->name, 
                "date" => date('d/m/y'), 
                "hours" => date('h:m')
            ]); 

            $ticket->notes = json_encode($TEMP_NOTES); 
            $ticket->update(); 
        }

        return redirect()->back();
    }

    public function alterTicketState(Request $request) {
        if(!$request->input('ticketId')) {
            return redirect()->back(); 
        }

        $ticket = Ticket::where('id', $request->input('ticketId'))->first(); 

        if($ticket) {
            $ticket->solved = !$ticket->solved; 
            $ticket->update();  
        } 

        return redirect()->back(); 
    }

    public function subToTicket(Request $request) {
        if(!$request->input('ticketId')) {
            return redirect()->back(); 
        }

        $ticket = Ticket::where('id', $request->input('ticketId'))->first(); 
        $TEMP = json_decode($ticket->subs, true); 

        foreach($TEMP as $sub) {
            if($sub == Auth::user()->name) {
                return redirect()->back(); 
            }
        }

        array_push($TEMP, Auth::user()->name); 
        $ticket->subs = json_encode($TEMP);
        $ticket->update(); 

        return redirect()->back(); 
    }

    public function getTicket($ticketId) {
        $ticket = Ticket::where('id', $ticketId)->first(); 

        if(!$ticket) {
            return redirect()->back(); 
        }

        $ticket->subs = json_decode($ticket->subs); 
        $ticket->notes = json_decode($ticket->notes); 
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
}