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

                                <form method="POST" action="{{ route('subtiket') }}">
                                    @csrf 

                                    <input type="hidden" name="ticketId" value="{{ $ticket->id }}">
                                    <input class="sub" type="submit" value="Add to ticket">
                                </form>
                            </div>

                            <div class="title">Queue</div>
                            <div class="description">{{ $ticket->queue != null ? $ticket->queue : 'Non queued' }}</div>

                            <div class="title">Status</div>
                            <div class="description">{{ $ticket->solved ? 'Solved' : 'Pending...' }}</div>

                            <div class="description">Creation Date: <span class="purple">{{ $ticket->created_at }}</span></div>
                            <div class="description">Last update: <span class="purple">{{ $ticket->updated_at }}</span></div>
                        
                            <div class="buttonActions">
                                <button>{{ $ticket->solved ? 'Reopen' : 'Solve' }}</button> 
                                <button>Follow ticket</button>
                            </div>
                        </div>
                    </div>

                    <div class="right">
                        Here it's the right side. 
                    </div>
                </div>
            </div>
        </div>
    </body>

    <style>
        .buttonActions {
            margin-top: 30px;   
            margin-left: 2%;  
            width: 96%; 
            display: flex; 
            flex-direction: row; 
            flex-wrap: wrap; 
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
 
        .flexbox .right {
            width: 55%; 
            background: gray; 
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