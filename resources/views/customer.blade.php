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
                </div>

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

                <div class="state">
                    <div>State: @if ($customer->active)
                        <span class="green">Active</span>
                    @else
                        <span class="red">Inactive</span>
                    @endif</div> 
                </div>

                Needed controllers: Locations, Services, Relation with services and CustomerId

                <br>

                Roles, Authorized identifiers, Información, Tickets, Servicios

                <button>Modify (Open popup)</button>
                <button>Delete</button>
            </div>
        </div>
    </body>

    <style>
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

        .information {
            width: 100%;  
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
            width: 30%; 
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
            margin-top: 30px; 
            font-size: 1.3rem; 
            padding-bottom: 30px; /* Only for debug */
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
                flex-direction: column; 
            }

            .box {
                width: 100%; 
            }
        }
    </style>
</html>