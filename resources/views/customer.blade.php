<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Customer | CRM</title>
    </head>

    <body>
        @include('components/sidebar')
        
        <div class="middle">
            <div class="container">
                @if (Session::has('identifier'))
                    <div>{{ Session::get('identifier') }}</div>
                @endif

                Información, Tickets, Servicios {{ $identifier }}
            </div>
        </div>
    </body>

    <style>
        .middle { 
            display: flex; 
            justify-content: center;
        } 

        .container {   
            width: 60%;  
            padding-bottom: 50px; 
        }
    </style>
</html>