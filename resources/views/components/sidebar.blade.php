<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sidebar | CRM</title> 
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <div class="background"></div>

        <div class="nav">
            <div class="routing">
                <div class="title">{{ Auth::user()->name }}</div>
                <div><span class="material-icons">person</span><a href="{{ URL::route('main') }}">Customers</a></div>
                <div><span class="material-icons">badge</span><a href="">Dashboard</a></div>
                <div><span class="material-icons">local_activity</span><a href="">Tickets</a></div>
                <div><span class="material-icons">eject</span><a href="">Following</a></div>
            </div>

            <div class="bottom">
                <div><span class="material-icons">settings</span> <a href="">Settings</a></div>
                <div><span class="material-icons">logout</span> <a href="{{ URL::route('logout') }}">Logout</a></div>
            </div>

            <div class="hide"><span class="material-icons">open_with</span></div>
        </div>
    </body>

    <script> 
        let hidden = true; 

        $(".hide").on('click', () => {
            if(!hidden){
                $('.nav a').css('display', 'none');  
                $('.nav').animate({
                    left: '-230px'
                }, 'slow');
                $('.nav div').css('justify-content', 'flex-end'); 
                $('.nav .title').css('justify-content', 'left'); 
                $('.background').fadeOut();
            } else { 
                $('.nav').animate({
                    left: 0
                }, 'slow');
                $('.nav a').fadeIn();  
                $('.nav div').css('justify-content', 'left'); 
                $('.nav .title').css('justify-content', 'left'); 
                $('.background').fadeIn();
            }

            hidden = !hidden;  
        }) 
    </script>

    <style>
        html, body {
            padding: 0; 
            margin: 0;  
            font-family: 'Nunito', sans-serif; 
        } 

        .background {
            display: none; 
            position: fixed; 
            height: 100%; 
            width: 100%; 
            background: rgba(0, 0, 0, 0.297); 
        }

        .hide {
            position: absolute; 
            right: -12px;
            top: 22px; 
        }

        .hide:hover {
            cursor: pointer; 
            user-select: none; 
        }

        .nav { 
            position: fixed; 
            background: white; 
            width: 100%;   
            width: 300px;  
            left: -230px; 
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.333); 
            height: 100%;
            display: flex; 
            flex-direction: column; 
            justify-content: space-between;   
        }  

        .nav a {
            display: none; 
            all: unset
        } 

        .nav .bottom {
            bottom: 0; 
            display: flex; 
            flex-direction: column; 
            padding: 20px 10px;
        }

        .nav .bottom div {
            padding: 15px 0px;
            border-radius: 0px; 
            background: whitesmoke;    
            color: gray; 
            border-radius: 5px;  
            margin-top: 15px; 
            transition: .3s;
            display: flex;  
            align-content: center; 
        }

        .bottom div span {
            padding: 0px 20px; 
        }

        .bottom div:hover {
            background: rgb(109, 124, 212); 
            color: white; 
            transition: .3s;
            cursor: pointer
        }

        .routing {
            display: flex; 
            flex-direction: column; 
            padding: 20px 10px; 
        }

        .routing div {  
            transition: .3s;
            display: flex;  
            align-items: center;  
        }

        .routing div span {
            padding: 0px 20px; 
        }

        .routing div:first-child {
            border-bottom: 2px solid black; 
            padding-bottom: 15px;  
            font-size: 1.5rem; 
        }

        .routing div:not(:first-child) {
            padding: 15px 0px;
            border-radius: 0px; 
            background: whitesmoke;    
            color: gray; 
            border-radius: 5px;  
            margin-top: 15px; 
        }

        .routing div:hover:not(:first-child) { 
            background: rgb(109, 124, 212); 
            color: white; 
            transition: .3s;
            cursor: pointer
        }
    </style> 
</html>