<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>Customer | CRM</title>
    </head>

    <body>
        @include('components/sidebar') 
        
        <div class="middle">
            <div class="container">  
                <div class="header">
                    <h1><span class="material-icons public-icon">public</span>{{ $customer->name }}</h1>
                    <div>Customer since <strong>{{ $customer->created_at }}</strong></div>

                    @if (Session::has('error'))
                        <div class="error">{{ Session::get('error') }}</div>
                    @endif
                </div>

                <div class="flexbox">
                    <!-- @ Customer information -->
                    <div class="information">
                        <div class="box">
                            <span class="material-icons">badge</span>
                            <input type="text" name="name" value="{{ $customer->name }}" disabled>
                        </div>
    
                        <div class="box">
                            <span class="material-icons">fingerprint</span>
                            <input type="text" name="identifier" value="{{ $customer->identifier }}" disabled>
                        </div>
    
                        <div class="box">
                            <span class="material-icons">call</span>
                            <input type="text" name="phone" value="{{ $customer->phoneNumber }}" disabled>
                        </div>
    
                        <div class="box">
                            <span class="material-icons">celebration</span>
                            <input type="text" name="dob" value="{{ $customer->dateOfBirth }}" disabled>
                        </div>
    
                        <div class="box">
                            <span class="material-icons">mail</span>
                            <input type="text" name="email" value="{{ $customer->email }}" disabled>
                        </div>
    
                        <div class="box">
                            <span class="material-icons">save_as</span>
                            <input type="text" name="created_at" value="{{ $customer->created_at }}" disabled>
                        </div>
                    </div>

                    <!-- @ State and roles -->
                    <div class="management">
                        <div class="state">
                            <div>State: @if ($customer->active)
                                <span class="green">Active</span>
                            @else
                                <span class="red">Inactive</span>
                            @endif</div> 
                        </div>

                        <div class="roles">
                            @if ($roles->count() > 0)
                                @foreach ($roles as $role)
                                    <div class="role" style="background: @php echo $role->color @endphp">{{ $role->role }}</div>
                                @endforeach
                            @else
                                <div>No roles to display</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- @ Actions -->
                <div class="actions">
                    <form method="POST" action="{{ route('handle-customer-state') }}">
                        @csrf  
                        <input type="hidden" name="identifier" value="{{ $customer->identifier }}">
                        <input type="submit" value="Handle state">
                    </form> 
                    
                    <form method="POST" action="{{ route('role-create') }}">
                        @csrf 
    
                        <input type="text" name="name" placeholder="Role name">
                        <input type="color" name="color">
                        <input type="hidden" name="identifier" value="{{ $customer->identifier }}">
    
                        <input type="submit" value="Add role">
                    </form>
                </div>

                <div class="tickets"> 
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

                    @if ($tickets->count() <= 0)
                        <div class="no-tickets">No tickets to display</div>
                    @endif

                    <button class="handleTicket" onclick="toggleTicket()">Create Ticket</button>
                </div>
            </div>
        </div>

        <!-- @ Customers create -->
        <div class="popup-container">
            <div class="popup-box">
                <div class="close"><span onclick="toggleTicket()" class="material-icons close-icon">close</span></div>

                <form method="POST" class="form-create" action="{{ route('create-ticket') }}">
                    @csrf 

                    <input type="text" name="title" maxlength="30" placeholder="Title" />
                    <textarea spellcheck="false" name="content" placeholder="Information here..."></textarea> 
                    <input type="hidden" name="customer" value="{{$customer->identifier}}">
                    <input type="submit" value="Create ticket" />
                </form>   
            </div>
        </div>
    </body>

    <script>
        function toggleTicket() {  
            if($('.popup-container').css('display') == 'none') {  
                $('.popup-container').css('display', 'flex'); 
            } else { 
                $('.popup-container').css('display', 'none'); 
            }
        }
    </script>

    <style>
        textarea {
            margin-top: 20px; 
            resize: vertical; 
            width: 76%;
            margin-left: 11%; 
            font-family: 'Nunito', sans-serif; 
            border: none;  
            font-size: 1.1rem; 
            border-radius: 3px;
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */ 
            background-color: rgb(211, 209, 209); 
            padding: 1%; 
        }

        textarea::-webkit-scrollbar {
            display: none;
        }

        textarea:focus {
            outline: none; 
        }

        .handleTicket {
            margin-top: 35px; 
            box-shadow: none; 
            background: rgb(109, 124, 212); 
            transition: .4s;
            color: white;  
            margin-bottom: 20px; 
            border: none; 
            padding: 10px 15px; 
            font-size: 1.1rem; 
            font-family: 'Nunito', sans-serif; 
            border-radius: 3px; 
        }

        .handleTicket:hover {
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

        .popup-container { 
            display: none; 
            position: fixed; 
            top: 0; 
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

        .form-create input[type="submit"] {
            margin-top: 35px; 
            box-shadow: none; 
            background: rgb(109, 124, 212); 
            transition: .4s;
            color: white;  
            margin-bottom: 20px; 
        }

        .form-create input[type="submit"]:hover {
            box-shadow: 0px 0px 5px rgb(109, 124, 212); 
            transition: .4s; 
        }

        .tickets {
            margin-top: 30px;  
            width: 100%;   
        } 

        .no-tickets {
            margin-top: 20px; 
            width: 100%; 
            text-align: center; 
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

        .actions {
            margin-top: 50px; 
            width: 100%;  
            display: flex; 
            flex-direction: row; 
            justify-content: space-between;
            flex-wrap: wrap;  
            align-content: center; 
        }

        .actions form { 
            display: flex; 
            align-content: center; 
            flex-wrap: wrap;  
        }

        .actions form input[type="text"] {
            background: rgb(229, 229, 229); 
            border: none; 
            font-family: 'Nunito', sans-serif;  
            padding: 0px 20px; 
            margin-right: 20px; 
            border-radius: 4px; 
            font-size: 1.1rem; 
            width: 200px; 
        }

        .actions form input[type="text"]:focus {
            outline: none; 
        }

        .actions form input[type="color"] {
            -webkit-appearance: none;
	        border: none; 
            height: 100%; 
            margin-right: 20px; 
        }  

        .actions form input[type="submit"] {
            background: rgb(109, 124, 212); 
            border: none;
            padding: 10px 10px; 
            border-radius: 3px; 
            font-size: 1.1rem; 
            font-family: 'Nunito', sans-serif;  
            transition: .4s; 
            color: white;
        }

        .actions form input[type="submit"]:hover {
            box-shadow: 0px 0px 10px rgb(109, 124, 212); 
            transition: .4s
        }

        .middle { 
            display: flex; 
            justify-content: center;
        } 

        .public-icon {
            padding-right: 20px; 
        }

        .container {   
            width: 60%;  
            padding-bottom: 50px; 
        }

        .header { 
            padding-bottom: 30px; 
            border-bottom: 2px solid rgba(8, 8, 8, 0.628); 
        }

        .flexbox { 
            display: flex; 
            flex-direction: row; 
            flex-wrap: wrap; 
            justify-content: space-between; 
        }

        .error {
            color: rgb(232, 76, 76); 
            margin-top: 20px; 
        }

        .management { 
            width: 30%;  
        }

        .roles { 
            margin-top: 20px;  
            display: flex;  
            flex-direction: row;
            flex-wrap: wrap;  
        }

        .role { 
            border-radius: 3px;
            color: white;  
            padding: 5px 10px; 
            margin-right: 10px;  
            background: skyblue; 
            margin-top: 5px; 
        }

        .role:hover {
            cursor: pointer; 
        }

        .information {
            width: 65%;  
            display: flex; 
            flex-direction: row;  
            flex-wrap: wrap; 
            justify-content: space-between;  
        }

        .box {
            display: flex;  
            align-items: center; 
            background: rgb(229, 229, 229); 
            padding: 5px 0px; 
            border-radius: 5px; 
            height: 40px; 
            width: 45%; 
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

        .state { 
            margin-top: 20px; 
            font-size: 1.3rem;  
        } 

        .red {
            color: rgb(232, 76, 76);  
        }

        .green {
            color: rgb(80, 206, 80);  
        }

        @media screen and (max-width: 1700px) {
            .box {
                width: 45%; 
            } 

            .information {
                width: 50%; 
                flex-direction: column; 
            }

            .information .box {
                width: 100%; 
            }

            .management {
                width: 45%; 
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

            .information {
                width: 100%; 
            }

            .management {
                width: 100%; 
            }

            .actions {
                flex-direction: column; 
            }

            .actions form {
                margin-top: 10px; 
                flex-direction: column; 
                align-content: initial; 
                flex-wrap: nowrap; 
                width: 100%;  
            }

            .actions form input {
                margin-top: 20px; 
            }

            .actions form input[type="submit"] {
                width: 100%; 
            }

            .actions form input[type="color"] {
                width: 100%; 
                height: 40px;   
            }

            .actions form input[type="text"] {
                width: 100%; 
                padding: 10px 0px; 
                text-align: center; 
                font-size: 1.1rem
            }
        }
    </style>
</html>