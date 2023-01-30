<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>Services | CRM</title>
    </head>

    <body>
        @include('components/sidebar')

        @php
            $SELECTED = null; 
        @endphp
        
        <div class="middle">
            <div class="container">   

                <h1>CRM | Packages</h1>
                
                @if (Session::has('error'))
                    <div class="error">{{ Session::get('error') }}</div>
                @endif
                
                <form method="POST" action="{{ route('create-package') }}">
                    @csrf  

                    <div class="box">
                        <span class="material-icons">border_color</span>
                        <input type="text" maxlength="30" name="name" placeholder="Package name">
                    </div>

                    <div class="box">
                        <span class="material-icons">payments</span>
                        <input type="number" onkeypress="isNumber(event)" name="price" placeholder="Price">
                    </div> 

                    <input class="submit" type="submit" name="submit" value="Create"> 
                </form>

                <div class="active">Active services: {{ $services->count() }}</div>

                @if ($services->count() > 0)  
                    <table> 
                        <tr class="head">
                            <th>Name</th>
                            <th>Price</th> 
                            <th></th>
                            <th></th> 
                        </tr>

                        @foreach ($services as $package)
                            <tr>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->price }}$</td>  
                                <td><span class="material-icons" onclick="@php $SELECTED = $package @endphp toggleEdit()">edit</span></td>
                                <td><span class="material-icons">delete</span></td>
                            </tr> 
                        @endforeach
                    </table> 
                @else
                    <div>No services to display</div>
                @endif

            </div>
        </div>

        <div class="popup-container">
            <div class="popup-box">
                <div class="close"><span onclick="toggleEdit()" class="material-icons close-icon">close</span></div>

                @if ($SELECTED != null)
                    <div>{{ $SELECTED->name }}</div>

                    <form method="POST" class="form-create" action="{{ route('customer-create') }}">
                        @csrf 

                        <input type="text" name="name" value="{{ $SELECTED->name }}" placeholder="Package name" />
                        <input type="number" onkeypress="isNumber(event)" name="phone" value="{{ $SELECTED->price }}" placeholder="Package Price" />
                        <input type="submit" value="Edit package" />
                    </form>  
                @endif
            </div>
        </div>
    </body>

    <script>    
        function toggleEdit() {  
            if($('.popup-container').css('display') == 'none') {  
                $('.popup-container').css('display', 'flex'); 
            } else { 
                $('.popup-container').css('display', 'none'); 
            }
        }

        function isNumber(evt) {
            var theEvent = evt || window.event;

            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else { 
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }

            var regex = /[0-9]|\./;

            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>

    <style>
        td span {
            opacity: .7;
            transition: .3s
        }

        td span:hover {
            opacity: 1;
            color: rgb(208, 73, 73); 
            transition: .3s
        }

        .popup-container { 
            display: none; 
            position: fixed; 
            width: 100%; 
            background: rgba(0, 0, 0, 0.401); 
            z-index: 5; 
            height: 100%;  
            top: 0; 
            justify-content: center; 
            align-items: center; 
        }

        .popup-box {
            background: white; 
            width: 500px; 
            height: 400px; 
            border-radius: 5px; 
        }

        .popup-box .close { 
            display: flex; 
            align-content: center; 
            justify-content: flex-end; 
            padding: 15px 15px; 
        }

        .form-create {
            margin-top: 20px; 
            width: 100%; 
            display: flex; 
            flex-direction: column;    
        }

        .form-create input {
            padding: 10px 0px;
            text-align: center; 
            width: 80%;   
            margin-left: 10%; 
            border-radius: 3px;
            font-family: 'Nunito', sans-serif; 
            border: none;   
            background-color: rgb(211, 209, 209); 
        }

        .form-create input:focus {
            outline: none; 
        }

        .form-create input:not(:first-child) {
            margin-top: 15px; 
        }

        .popup-box div {
            margin-top: 20px; 
            margin-left: 10%; 
            color: rgb(70, 80, 173); 
            width: 80%; 
        }

        .form-create input[type="submit"] {
            margin-top: 35px; 
            box-shadow: none; 
            width: 80%; 
            background: rgb(109, 124, 212); 
            transition: .4s;
            color: white;  
        }

        .form-create input[type="submit"]:hover {
            box-shadow: 0px 0px 5px rgb(109, 124, 212); 
            transition: .4s; 
        }

        .close-icon {
            transition: .5s; 
        }

        .close-icon:hover {
            transition: .5s; 
            cursor: pointer; 
            user-select: none; 
            color: rgb(208, 73, 73); 
        }


        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .active {
            margin-top: 40px; 
            color: rgb(70, 80, 173);
        }

        .error {
            color: rgb(232, 76, 76); 
        }

        .middle { 
            display: flex; 
            justify-content: center;
        }  

        .container {   
            width: 60%;  
            padding-bottom: 50px; 
        }

        form { 
            width: 80%;  
            display: flex;  
            justify-content: space-between; 
            flex-wrap: wrap;    
        }

        .box {
            display: flex;  
            align-items: center; 
            background: rgb(229, 229, 229); 
            padding: 5px 0px; 
            border-radius: 5px; 
            width: 40%; 
            margin-top: 20px; 
        }

        .box span {
            padding-left: 10px; 
        }

        .box input {
            background: none;
            font-family: 'Nunito', sans-serif;  
            border: none; 
            padding: 5px 10px; 
            font-size: 1.1rem;  
            width: 90%; 
        }

        .box input:focus {
            outline: none
        } 

        input[type="submit"] {
            width: 150px; 
            border: none; 
            font-family: 'Nunito', sans-serif; 
            border-radius: 5px; 
            background: rgb(109, 124, 212); 
            transition: .5s;   
            color: white;  
            padding: 0px 0px; 
            height: 45px; 
            margin-top: 20px; 
        }

        input[type="submit"]:hover {
            transition: .5s; 
            box-shadow: 0px 0px 5px rgb(109, 124, 212); 
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

        @media screen and (max-width: 1800px) {  
            form { 
                width: 100%;  
            }

            .box {
                width: 45%; 
            }

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
            .box {
                width: 100%
            } 
        }
    </style>
</html>