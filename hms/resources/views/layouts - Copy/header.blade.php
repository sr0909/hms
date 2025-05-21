<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield("title")</title>

        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"/>

        <!--Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!--End of Bootstrap CSS-->

        <style>
            .custom-navbar {
                left: 250px;
            }

            .custom-sidebar .sidebar-title {
                color: #F1F1F1;
            }

            .custom-sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                width: 250px;
                background-color: #00275B;
                color: #fff;
            }

            .custom-sidebar .nav-item.dropdown .dropdown-menu {
                position: static;
                float: none;
            }

            .custom-sidebar .nav-link,
            .custom-dropdown-menu .dropdown-item {
                color: #9C9FA4;
            }

            .custom-sidebar .nav-link:hover,
            .custom-dropdown-menu .dropdown-item:hover {
                color: #D2D5D8;
            }

            .custom-sidebar .nav-link.active,
            .custom-dropdown-menu .dropdown-item:active,
            .nav-link.dropdown-toggle.active,
            .nav-link.dropdown-toggle:focus,
            .nav-link.dropdown-toggle.show {
                color: #ffffff; 
                font-weight: semi-bold;
            }

            .custom-dropdown-menu {
                /* background-color: #03316D; */
                background-color: transparent;
                width: 240px;
            }

            .custom-dropdown-menu .dropdown-item {
                font-size: 14px;
                font-weight: light;
            }

            .custom-dropdown-menu .dropdown-item:hover {
                background-color: transparent;
            }

            .btn-user {
                background-color: transparent;
                border: none;
            }

            .user-icon {
                color: #00275B;
            }

            .user-icon:hover {
                color: #A6A6A6; 
            }

            .user-dropdown-menu .dropdown-item:active {
                background-color: #737373;
            }

            main {
                margin-left: 250px;
                padding: 10px;
                padding-top: 50px;
                min-height: vh100;
                /* overflow-y: auto; // Allows scrolling within the main content area */
            }
        </style>
    </head>
    <body>
        <header>
            @include("layouts.navbar")
        </header>
        <main>