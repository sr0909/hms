<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"/>

        <!--Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!--End of Bootstrap CSS-->

        <!-- <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'> -->
        
        <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" >

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
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
            .custom-dropdown-menu .dropdown-item.active,
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

            .custom-dropdown-menu .dropdown-item:hover,
            .custom-dropdown-menu .dropdown-item.active {
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

            .hr {
                margin: 0;
                margin-bottom: 15px;
                border-width: 2px;
            }

            /* Custom CSS to align search text and field side by side */
            div.dataTables_wrapper div.dataTables_filter {
                text-align: left;
            }

            div.dataTables_wrapper div.dataTables_filter label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            div.dataTables_wrapper div.dataTables_filter input {
                margin-left: 0;
                width: auto;
            }

            /* Custom CSS to align show entries label and select side by side */
            div.dataTables_wrapper div.dataTables_length {
                text-align: left;
            }

            div.dataTables_wrapper div.dataTables_length label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            div.dataTables_wrapper div.dataTables_length select {
                margin-left: 0;
                width: auto;
            }

            /* Custom CSS to place pagination at the right side */
            div.dataTables_wrapper div.dataTables_paginate {
                display: flex;
                justify-content: flex-end;
            }

            /* Custom CSS for create button */
            #btn-create {
                border: none;
                margin-bottom: 2px;
                padding: 2px 5px;
            }

            /* Custom CSS for back button */
            #btn-back {
                font-size: 22px;
                display: none;
            }

            /* Custom CSS to adjust the height of select2 element */
            .select2-container--default .select2-selection--single {
                height: 38px; /* Same height as Bootstrap's .form-control */
                padding: 0.3rem 0.45rem; /* Same padding as .form-control */
                border: 1px solid #ced4da; /* Same border as .form-control */
                border-radius: 0.25rem; /* Same border-radius as .form-control */
            }
        </style>
    </head>
    <body>
        <header>
            <x-navbar />
        </header>
        <main>