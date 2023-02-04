<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Customers | CRM</title> 
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    
    <body>
        @include('/components/sidebar') 

        <div class="middle">
            <div class="container">

                <!-- @ Search -->
                <div class="header">
                    <form method="POST" action="{{ route('filter-tickets') }}"> 
                        @csrf 
    
                        <div class="bar">
                            <span class="material-icons">search</span>
                            <input class="filter" type="text" name="filter" placeholder="Ticket Id, Customer identifier"> 
                        </div>
                    </form> 
                </div>

                <!-- @ Information/Refresh -->
                <div class="information">
                    <div>Tickets amount: {{ $tickets->count() }}</div>
                    <div class="refresh"><a href="{{ URL::route('tickets') }}"><span class="material-icons">sync</span></a></div>
                </div>

                <!-- @ Table -->
                <table> 
                    <tr class="head">
                        <th>Ticket Id</th>
                        <th>Title</th>  
                        <th>Status</th> 
                        <th>Created</th>
                    </tr>

                    @if ($tickets->count() > 0)    
                        @foreach ($tickets as $ticket)
                            <tr onclick="window.location.href = '/tickets/{{ $ticket->id }}'">
                                <td>#{{ $ticket->id }}</td> 
                                <td>{{ $ticket->title }}</td>  
                                <td>{{ $ticket->solved ? 'Solved' : 'Pending...' }}</td> 
                                <td>{{ $ticket->created_at }}</td> 
                            </tr> 
                        @endforeach
                    @endif
                </table>  
                
                <div class="paginate">{{ $tickets->links() }} </div>

                @if ($tickets->count() <= 0)
                    <div class="no-tickets">No tickets to display</div>
                @endif
            </div> 
        </div>
    </body> 

    <style>
        .paginate {
            margin-top: 20px; 
            transition: .3s
        }

        .paginate:hover {
            color: rgb(109, 124, 212); 
            transition: .3s; 
            cursor: pointer;
        }

        .middle { 
            display: flex; 
            justify-content: center;
        } 

        .container {   
            width: 60%;  
            padding-bottom: 50px;  
        }

        .header {
            padding: 40px 0px; 
            width: 100%;    
            display: flex; 
            flex-direction: row; 
            justify-content: space-between; 
            flex-wrap: wrap; 
            align-items: center;  
        }

        .header .info { 
            display: flex;
            justify-content: flex-start;  
            align-items: center;   
        }

        .header .info div {
            padding-right: 30px 
        } 

        .bar {
            display: flex; 
            width: 650px;
            align-items: center; 
            background: rgb(229, 229, 229); 
            padding: 5px 0px; 
            border-radius: 5px; 
        }

        .bar span {
            padding: 0px 15px; 
        }

        .bar input {
            background: none;
            font-family: 'Nunito', sans-serif;  
            border: none; 
            padding: 5px 10px; 
            font-size: 1.1rem; 
            width: 350px;  
        }

        .bar input:focus {
            outline: none
        }

        a {
            all: unset
        }

        .refresh {
            transition: .5s; 
        }

        .refresh:hover {
            transition: .5s; 
            cursor: pointer; 
            user-select: none; 
            color: rgb(80, 206, 80); 
        }

        .information {
            width: 100%;  
            display: flex; 
            justify-content: space-between; 
        }

        table { 
            margin-top: 40px; 
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd; 
            border-radius: 5px; 
        }

        th, td {
            text-align: left;
            padding: 16px;
        }

        tr {
            transition: .5s;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover:not(:first-child) {
            user-select: none; 
            cursor: pointer;  
            transition: .5s; 
            background: #c6c6c6; 
        }

        @media screen and (max-width: 1600px) {  
            table {
                border: 0; 
            }

            table caption {
                font-size: 1.3em;
            }
            
            table .head {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
                display: block; 
            }
            
            table tr { 
                display: block;
                margin-bottom: .625em;
                border-radius: 5px;
            }
            
            table td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: .8em;
                text-align: center;
                display: flex; 
                justify-content: center; 
            }
            
            table td::before { 
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }
            
            table td:last-child {
                border-bottom: 0;
            }
        }

        @media screen and (max-width: 1000px) {
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

            .bar {
                width: 100%; 
            }  

            .header {
                flex-direction: column;  
            }

            .header .info { 
                width: 100%; 
                margin-top: 20px; 
            }
        }
    </style>
</html>