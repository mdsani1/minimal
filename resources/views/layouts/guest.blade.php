<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Minimal</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('image/logo.png') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            body {
                height: 60vh;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                background-color: #f8f9fa;
            }
            .card {
                margin-top: 30px;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            .container-fluid {
                padding: 60px;
                padding-left: 150px;
                padding-top: 30px;
                padding-right: 150px;
            }
            .form-control {
                text-align:center;
            }
            .form-control {
                border-radius: 25px;
                height: 50px;
                border-right: none;
            }
            .input-group-text {
                border-radius: 0px 30px 30px 0px;
                background-color: #fff;
                border-left: none;
            }
            .btn-login {
                border-radius: 25px;
                background-color: #00695c;
                border: 2px solid #00695c;
            }
            .btn-login:hover {
                background-color: #1A4314;
                border: 2px solid #1A4314;
            }
            @media only screen and (max-width: 979px) {
                .col-sm-12 {
                    max-width: 100%;
                    border:none !important;
                }
                .container-fluid {
                    padding: 30px;
                }
            }
        </style>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
