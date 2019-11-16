<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>OLX Video API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Bungee" rel="stylesheet">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="{{ asset('js/form_manipulation.js') }}"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #F5DEB3;
                font-family: 'Bungee', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 60px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                transition: 1s ease;
            }

            .links > a:hover{
                font-size: 20px;
                font-weight: bold;
            }

            .links-signup > a{
                color: #636b6f;
                font-size: 25px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .links-signup a:hover{
                
            }

            .m-b-md {
                margin-bottom: 30px;
                font-weight: bold;
                -webkit-text-stroke: 4px #CD5C5C;
                opacity: 0.8;
            }
            .add_video_form {
                visibility: hidden;
            }

            .add_video_button{

            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    OLX Video API
                </div>
                <div class="links">
                    <a href="/videos">All Videos</a>
                    <a href="/videos?token=5862c9493a788b18084d08f297d9ade41845f407">Enter with test token</a>
                    <a href="/api/documentation">Documentation</a>
                </div>
                <div class="image">
                    <img src="" alt="">
                </div>
                @include('layouts.top-menu')
            </div>
        </div>
    </body>
</html>
