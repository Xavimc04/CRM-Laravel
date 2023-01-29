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

        @php 
            $CUSTOMERS_DATA = $customers;  
        @endphp

        <div class="middle">
            <div class="container">

                <form method="POST" action="{{ route('filter') }}">
                    @csrf 

                    <!-- @ Search -->
                    <div class="header">
                        <div class="bar">
                            <span class="material-icons">search</span>
                            <input class="filter" type="text" name="filter" placeholder="Identifier, Phone, Name..."> 
                        </div>
    
                        <div class="info">   
                            <button class="button">Search</button>
                            <button class="button" onclick="toggleCustomerCreation()">Create</button>
                        </div>
                    </div>
                </form>

                <!-- @ Information/Refresh -->
                <div class="information">
                    <div>Total customers: {{ $CUSTOMERS_DATA->count() }}</div>
                    <div class="refresh"><a href="{{ URL::route('main') }}"><span class="material-icons">sync</span></a></div>
                </div>

                <!-- @ Table -->
                @if ($CUSTOMERS_DATA->count() > 0) 
                    <table> 
                        <tr class="head">
                            <th>Identifier</th>
                            <th>Name</th> 
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Is Active</th>
                            <th>Created</th>
                        </tr>

                        @foreach ($CUSTOMERS_DATA as $customer)
                            <tr onclick="window.location.href = '/customers/{{ $customer->identifier }}'">
                                <td>{{ $customer->identifier }}</td>
                                <td>{{ $customer->name }}</td> 
                                <td>{{ $customer->phoneNumber }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    @if ($customer->active == 1)
                                        <div class="circle green"></div>
                                    @else
                                        <div class="circle red"></div>
                                    @endif
                                </td>
                                <td>{{ $customer->created_at }}</td>
                            </tr> 
                        @endforeach
                    </table> 
                @endif 
            </div>

            <!-- @ Customers create -->
            <div class="popup-container">
                <div class="popup-box">
                    <div class="close"><span onclick="toggleCustomerCreation()" class="material-icons close-icon">close</span></div>

                    <form method="POST" class="form-create" action="{{ route('customer-create') }}">
                        @csrf 

                        <input type="text" name="identifier" value="{{ old('identifier') }}" maxlength="9" placeholder="Identifier" />
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Name" />
                        <input type="date" name="dob" value="{{ old('dob') }}" placeholder="Date of birth" />
                        <input type="number" onkeypress="isNumber(event)" name="phone" value="{{ old('phone') }}" placeholder="Contact number" />
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
                        <input type="submit" value="Register customer" />
                    </form> 

                    @if (Session::has('message')) 
                        <div class="error">{{ Session::get('message') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- @ Axios -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
    </body> 

    <script>  
        function toggleCustomerCreation() { 
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
        a {
            all: unset
        }

        .information {
            width: 100%;  
            display: flex; 
            justify-content: space-between; 
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

        .close-icon {
            transition: .5s; 
        }

        .close-icon:hover {
            transition: .5s; 
            cursor: pointer; 
            user-select: none; 
            color: rgb(208, 73, 73); 
        }

        .popup-container { 
            display: none; 
            position: fixed; 
            width: 100%; 
            background: rgba(0, 0, 0, 0.401); 
            z-index: 5; 
            height: 100%;  
            justify-content: center; 
            align-items: center; 
        }

        .popup-box {
            background: white; 
            width: 500px; 
            height: 500px; 
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

        .error {
            width: 80%;   
            margin-left: 10%; 
            background: rgb(208, 73, 73); 
            margin-top: 15px; 
            padding: 8px 0px; 
            text-align: center;
            color: white; 
            border-radius: 3px; 
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

        .form-create input[type="submit"] {
            margin-top: 35px; 
            box-shadow: none; 
            background: rgb(109, 124, 212); 
            transition: .4s;
            color: white;  
        }

        .form-create input[type="submit"]:hover {
            box-shadow: 0px 0px 5px rgb(109, 124, 212); 
            transition: .4s; 
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
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
            justify-content: space-between;  
            align-items: center;    
            width: 340px;  
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

        .button {
            width: 150px; 
            border: none; 
            font-family: 'Nunito', sans-serif; 
            border-radius: 5px; 
            background: rgb(109, 124, 212); 
            transition: .5s;   
            color: white;  
            padding: 10px 0px; 
        }

        .button:hover {
            transition: .5s; 
            box-shadow: 0px 0px 5px rgb(109, 124, 212); 
        }

        .search .bar input:focus {
            outline: none; 
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

        .circle {
            width: 13px; 
            height: 13px;  
            border-radius: 50%; 
        }

        .red {
            background: rgb(232, 76, 76); 
            box-shadow: 0px 0px 5px rgb(232, 76, 76)
        }

        .green {
            background: rgb(80, 206, 80); 
            box-shadow: 0px 0px 5px rgb(80, 206, 80)
        }

        @media screen and (max-width: 1700px) {  
            .bar {
                width: 100%; 
            } 

            .header .info {  
                justify-content: space-between; 
                margin-top: 20px; 
            }
        }

        @media screen and (max-width: 900px) {
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

    </style>
</html>