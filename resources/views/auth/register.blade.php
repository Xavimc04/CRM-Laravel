<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Register | CRM</title> 
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head> 

    <body>
        <div class="container">
            <div class="header">
                <div>CRM | <a>Register</a></div>
                <a>Customer Relationship Management</a>
            </div>

            @if (Session::has('message') && Session::get('type'))
                <div class="notification {{ Session::get('type') }}">{{ Session::get('message') }}</div>
            @endif

            <form method="POST" action="{{ route('register-account') }}">
                @csrf

                <input type="text" name="name" value="{{ old('name') }}" placeholder="Username" />
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <input type="password" name="repeated" placeholder="Repeat password" />

                <input type="submit" value="Register account" />
            </form>
            
            <div class="login">
                <a class="link" href="{{ URL::route('login'); }}">¿Did you have an account? Log in now</a>
            </div>
        </div>
    </body>

    <style>
        .container {
            position: absolute; 
            left: 50%; 
            top: 50%; 
            transform: translate(-50%, -50%); 
        }

        .header div {
            font-family: 'Nunito', sans-serif;  
            font-weight: 900; 
            font-size: 2rem;  
        }

        .notification {
            margin-top: 20px; 
            border-radius: 3px; 
            font-family: 'Nunito', sans-serif; ; 
            text-align: center; 
            padding: 10px 0px;
            color: rgb(36, 35, 35); 
            font-size: 1rem; 
        }

        .success {
            background: rgb(118, 219, 92); 
        }

        .error {
            background: rgb(219, 92, 92); 
        }

        .header a {
            font-family: 'Nunito', sans-serif;  
            color: black; 
            opacity: .5; 
        }

        .header div a {
            color: rgb(109, 124, 212); 
            opacity: 1;
        }

        form {
            margin-top: 10px; 
            width: 350px;
            display: flex; 
            flex-direction: column;  
        }

        form input {
            padding: 10px 0px;
            text-align: center; 
            border-radius: 3px;
            font-family: 'Nunito', sans-serif; 
            border: none;   
            background-color: rgb(211, 209, 209); 
        }

        form input:focus {
            outline: none; 
        }

        form input:not(:first-child) {
            margin-top: 15px; 
        }

        form input[type="submit"] {
            margin-top: 35px; 
            box-shadow: none; 
            background: rgb(109, 124, 212); 
            transition: .4s;
            color: white;  
        }

        form input[type="submit"]:hover {
            box-shadow: 0px 0px 5px rgb(109, 124, 212); 
            transition: .4s; 
        }

        .login {
            margin-top: 10px; 
        }

        .login .link {
            font-family: 'Nunito', sans-serif;  
            opacity: .5;
            font-size: .9rem; 
            transition: .3s; 
            text-decoration: none; 
            color: black; 
        }

        .login .link:hover {
            opacity: 1;
            cursor: pointer; 
            transition: .3s
        }
    </style>
</html>