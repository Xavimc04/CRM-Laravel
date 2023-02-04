<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>Ticket | CRM</title>
    </head>
    <body>
        @include('/components/sidebar')    

        <div class="middle">
            <div class="container">
                <h1><span class="material-icons purple">radio_button_checked</span>  Ticket #{{ $ticket->id }}</h1>
                <h3>Customer: <a class="purple">{{ $customer->name }}</a></h3>

                @if (Session::has('error'))
                    <div class="error">{{ Session::get('error') }}</div>
                @endif
                
                <div class="flexbox">
                    <div class="left">
                        <div class="contactInfo">
                            <div class="title">Contact information</div>
                            <div class="description">Identifier: {{ $customer->identifier }}</div>
                            <div class="description">Name: {{ $customer->name }}</div>
                            <div class="description">CP: {{ $customer->phoneNumber }}</div>
                            <div class="description">Email: {{ $customer->email }}</div>

                            <div class="buttonActions"> 
                                <button onclick="window.location.href = '/customers/{{ $customer->identifier }}'">View profile</button>
                            </div>
                        </div>

                        <div class="ticketInfo">
                            <div class="title">{{ $ticket->title }}</div>
                            <div class="description">{{ $ticket->description }}</div>

                            <div class="title">Subscribers</div>

                            <div class="subs">
                                @foreach ($ticket->subs as $sub)
                                    <div class="sub">{{ $sub }}</div>
                                @endforeach
                            </div>

                            <div class="title">Queue</div>
                            <div class="description">{{ $ticket->queue != null ? $ticket->queue : 'Non queued' }}</div>

                            <div class="title">Status</div>
                            <div class="description">{{ $ticket->solved ? 'Solved' : 'Pending...' }}</div>

                            <div class="description">Creation Date: <span class="purple">{{ $ticket->created_at }}</span></div>
                            <div class="description">Last update: <span class="purple">{{ $ticket->updated_at }}</span></div>
                        
                            <div class="buttonActions">   
                                <form method="POST" action="{{ route('handleTicketState') }}">
                                    @csrf 

                                    <input type="hidden" name="ticketId" value="{{ $ticket->id }}">
                                    <input type="submit" value="{{ $ticket->solved ? 'Reopen' : 'Solve' }}">
                                </form>

                                <form method="POST" action="{{ route('subtiket') }}">
                                    @csrf 

                                    <input type="hidden" name="ticketId" value="{{ $ticket->id }}">
                                    <input type="submit" value="Subscribe">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="right"> 
                        <div class="commentContainer">
                            @if ($ticket->notes != null)
                                @foreach ($ticket->notes as $note)
                                    <div class="note {{ $note->sender == Auth::user()->name ? 'self' : 'target' }}">
                                        <div class="note-sender">{{ $note->sender }} <span>{{ $note->date }}</span></div>
                                        <div class="note-content">{{ $note->content }}</div>
                                        <div class="note-hour">Sent at {{ $note->hours }}</div>
                                    </div>
                                @endforeach
                            @else 
                                <div class="note target">No comments to display</div>
                            @endif
                        </div>

                        <form class="createComment" method="POST" action="{{ route('createComment') }}">
                            @csrf 

                            <input type="text" name="content" placeholder="New comment...">
                            <input type="hidden" name="ticketId" value="{{ $ticket->id }}">
                            <button type="submit"><span class="material-icons">send</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <style>
        .note {
            margin-top: 20px;  
            max-width: 500px;
            padding: 10px; 
            border-radius: 3px;  
            margin-bottom: 20px; 
        }

        .self {  
            align-self: flex-end;
            margin-right: 20px; 
            background: rgb(82, 82, 82); 
            color: whitesmoke; 
        }

        .target { 
            align-self: flex-start;
            margin-left: 20px; 
            background: rgb(109, 124, 212); 
            color: white; 
        }

        .note-sender {
            font-size: 1.2rem; 
        }

        .note-sender span {
            opacity: .6;
            margin-left: 5px; 
            font-size: .9rem; 
        }

        .note-content {
            margin-top: 15px; 
        }

        .note-hour {
            margin-top: 15px; 
            opacity: .6;
        }

        .flexbox .right {
            width: 55%; 
            height: 100%; 
        } 

        .flexbox .right .commentContainer {
            background: whitesmoke; 
            border-radius: 3px; 
            height: 600px; 
            overflow-y: scroll; 
            -ms-overflow-style: none; 
            scrollbar-width: none; 
            display: flex; 
            flex-direction: column; 
            align-items: flex-start;
        }

        .flexbox .right .commentContainer::-webkit-scrollbar {
            display: none;
        }

        .flexbox .right .createComment {
            background: whitesmoke; 
            border-radius: 3px; 
            margin-top: 30px;  
            display: flex; 
            align-content: center; 
            justify-content: space-between; 
        }

        .createComment input {
            width: 80%; 
            padding: 10px 15px; 
            font-family: 'Nunito', sans-serif;
            background: transparent; 
            border: none; 
            font-size: 1.1rem; 
        }

        .createComment input:focus {
            outline: none; 
        }

        .createComment button { 
            margin-top: 5px; 
            border: none; 
            font-family: 'Nunito', sans-serif; 
            border-radius: 5px; 
            color: rgb(109, 124, 212); 
            transition: .5s;    
            background: transparent; 
            display: flex; 
            justify-content: center; 
            align-content: center; 
        }

        .createComment button span {
            font-size: 1.8rem; 
        }

        .buttonActions {
            margin-top: 30px;   
            margin-left: 2%;  
            width: 96%; 
            display: flex; 
            flex-direction: row; 
            flex-wrap: wrap; 
        }

        .buttonActions form input {
            margin-top: 5px; 
            width: 150px; 
            border: none; 
            font-family: 'Nunito', sans-serif; 
            border-radius: 5px; 
            background: rgb(109, 124, 212); 
            transition: .5s;   
            color: white;  
            padding: 10px 0px; 
            margin-right: 20px; 
        }

        .buttonActions button {
            margin-top: 5px; 
            width: 150px; 
            border: none; 
            font-family: 'Nunito', sans-serif; 
            border-radius: 5px; 
            background: rgb(109, 124, 212); 
            transition: .5s;   
            color: white;  
            padding: 10px 0px; 
            margin-right: 20px; 
        }

        .buttonActions button:hover {
            transition: .5s; 
            box-shadow: 0px 0px 5px rgb(109, 124, 212); 
        }

        .error {
            color: rgb(232, 76, 76); 
            margin-top: 20px; 
        }

        .subs { 
            margin-top: 10px;  
            display: flex;  
            flex-direction: row;
            flex-wrap: wrap;  
            padding: 5px 10px;  
            margin-bottom: 20px; 
        }

        .sub { 
            border-radius: 3px;
            color: white;  
            padding: 5px 10px; 
            margin-right: 10px;  
            background: skyblue; 
            margin-top: 5px; 
            display: flex;
            justify-content: center; 
            align-content: center; 
            transition: .4s;
        }

        .sub:hover {
            cursor: pointer; 
            background: gray; 
            color: white; 
            opacity: .7;
            transition: .4s; 
        }

        .flexbox {
            width: 100%;
            display: flex; 
            justify-content: space-between;   
            margin-top: 40px; 
        }

        .flexbox .left {
            width: 40%;  
            display: flex; 
            flex-direction: column;  
        }

        .flexbox .left .contactInfo {
            background: whitesmoke;
            border-radius: 5px; 
            padding-bottom: 20px; 
        }

        .flexbox .left .ticketInfo {
            margin-top: 15px; 
            background: whitesmoke;
            border-radius: 5px; 
            padding-bottom: 20px; 
        }

        .title {
            padding: 0px 15px;  
            font-size: 1.2rem; 
            font-weight: 900; 
            margin-top: 20px; 
        }

        .description {
            margin-top: 20px; 
            padding: 0px 15px;  
        }

        .middle { 
            display: flex; 
            justify-content: center;
        } 

        .container {   
            width: 60%;  
            padding-bottom: 50px; 
        } 

        .purple {
            color: rgb(109, 124, 212); 
        }

        @media screen and (max-width: 1300px) {
            .middle {
                display: block; 
            }

            .container { 
                position: absolute; 
                left: 55%; 
                transform: translate(-50%);  
                z-index: -1; 
                width: 70%;    
            } 

            .flexbox {
                flex-direction: column;  
                width: 100%; 
            }

            .flexbox .left {
                width: 100%;  
            }

            .flexbox .right {
                margin-top: 50px; 
                width: 100%;  
            }
        }
    </style>
</html>