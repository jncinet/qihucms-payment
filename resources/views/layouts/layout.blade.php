<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ cache('config_site_name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            font-family: sans-serif;
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        body {
            margin: 0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #f0f1f3;
        }

        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            color: #0056b3;
        }

        a:not([href]) {
            color: inherit;
            text-decoration: none;
        }

        a:not([href]):hover {
            color: inherit;
            text-decoration: none;
        }

        .bg-white {
            background: #fff;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        a.bg-light:hover, a.bg-light:focus,
        button.bg-light:hover,
        button.bg-light:focus {
            background-color: #dae0e5;
        }

        small,
        .small {
            font-size: 80%;
            font-weight: 400;
        }

        .d-block {
            display: block;
        }

        .d-flex {
            display: -ms-flexbox;
            display: flex;
        }

        .justify-content-center {
            -ms-flex-pack: center;
            justify-content: center;
        }

        .justify-content-between {
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .align-content-center {
            -ms-flex-line-pack: center;
            align-content: center;
        }

        .align-content-between {
            -ms-flex-line-pack: justify;
            align-content: space-between;
        }

        .align-items-start {
            -ms-flex-align: start;
            align-items: flex-start;
        }

        .align-items-end {
            -ms-flex-align: end;
            align-items: flex-end;
        }

        .align-items-center {
            -ms-flex-align: center;
            align-items: center;
        }

        .align-items-baseline {
            -ms-flex-align: baseline;
            align-items: baseline;
        }

        .align-items-stretch {
            -ms-flex-align: stretch;
            align-items: stretch;
        }

        .vh-100 {
            height: 100vh;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn:hover {
            color: #212529;
            text-decoration: none;
        }

        .btn:focus, .btn.focus {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn.disabled, .btn:disabled {
            opacity: 0.65;
        }

        .btn:not(:disabled):not(.disabled) {
            cursor: pointer;
        }

        a.btn.disabled,
        fieldset:disabled a.btn {
            pointer-events: none;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .btn-block + .btn-block {
            margin-top: 0.5rem;
        }

        .btn-primary {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-primary:focus, .btn-primary.focus {
            color: #fff;
            background-color: #c82333;
            border-color: #bd2130;
            box-shadow: 0 0 0 0.2rem rgba(225, 83, 97, 0.5);
        }

        .btn-primary.disabled, .btn-primary:disabled {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active {
            color: #fff;
            background-color: #bd2130;
            border-color: #b21f2d;
        }

        .btn-primary:not(:disabled):not(.disabled):active:focus, .btn-primary:not(:disabled):not(.disabled).active:focus {
            box-shadow: 0 0 0 0.2rem rgba(225, 83, 97, 0.5);
        }

        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-secondary:focus, .btn-secondary.focus {
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
            box-shadow: 0 0 0 0.2rem rgba(130, 138, 145, 0.5);
        }

        .btn-secondary.disabled, .btn-secondary:disabled {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:not(:disabled):not(.disabled):active, .btn-secondary:not(:disabled):not(.disabled).active {
            color: #fff;
            background-color: #545b62;
            border-color: #4e555b;
        }

        .btn-secondary:not(:disabled):not(.disabled):active:focus, .btn-secondary:not(:disabled):not(.disabled).active:focus {
            box-shadow: 0 0 0 0.2rem rgba(130, 138, 145, 0.5);
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-success:focus, .btn-success.focus {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
            box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
        }

        .btn-success.disabled, .btn-success:disabled {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:not(:disabled):not(.disabled):active, .btn-success:not(:disabled):not(.disabled).active {
            color: #fff;
            background-color: #1e7e34;
            border-color: #1c7430;
        }

        .btn-success:not(:disabled):not(.disabled):active:focus, .btn-success:not(:disabled):not(.disabled).active:focus {
            box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
        }

        .w-25 {
            width: 25%;
        }

        .w-50 {
            width: 50%;
        }

        .w-75 {
            width: 75%;
        }

        .w-100 {
            width: 100%;
        }

        .w-auto {
            width: auto;
        }

        .h-25 {
            height: 25%;
        }

        .h-50 {
            height: 50%;
        }

        .h-75 {
            height: 75%;
        }

        .h-100 {
            height: 100%;
        }

        .h-auto {
            height: auto;
        }

        .mw-100 {
            max-width: 100%;
        }

        .mh-100 {
            max-height: 100%;
        }

        .min-vw-100 {
            min-width: 100vw;
        }

        .min-vh-100 {
            min-height: 100vh;
        }

        .vw-100 {
            width: 100vw;
        }

        .vh-100 {
            height: 100vh;
        }

        .text-center {
            text-align: center;
        }

        .m-0 {
            margin: 0;
        }

        .mt-0,
        .my-0 {
            margin-top: 0;
        }

        .mr-0,
        .mx-0 {
            margin-right: 0;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0;
        }

        .ml-0,
        .mx-0 {
            margin-left: 0;
        }

        .m-1 {
            margin: 0.25rem;
        }

        .mt-1,
        .my-1 {
            margin-top: 0.25rem;
        }

        .mr-1,
        .mx-1 {
            margin-right: 0.25rem;
        }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25rem;
        }

        .ml-1,
        .mx-1 {
            margin-left: 0.25rem;
        }

        .m-2 {
            margin: 0.5rem;
        }

        .mt-2,
        .my-2 {
            margin-top: 0.5rem;
        }

        .mr-2,
        .mx-2 {
            margin-right: 0.5rem;
        }

        .mb-2,
        .my-2 {
            margin-bottom: 0.5rem;
        }

        .ml-2,
        .mx-2 {
            margin-left: 0.5rem;
        }

        .m-3 {
            margin: 1rem;
        }

        .mt-3,
        .my-3 {
            margin-top: 1rem;
        }

        .mr-3,
        .mx-3 {
            margin-right: 1rem;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem;
        }

        .ml-3,
        .mx-3 {
            margin-left: 1rem;
        }

        .m-4 {
            margin: 1.5rem;
        }

        .mt-4,
        .my-4 {
            margin-top: 1.5rem;
        }

        .mr-4,
        .mx-4 {
            margin-right: 1.5rem;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem;
        }

        .ml-4,
        .mx-4 {
            margin-left: 1.5rem;
        }

        .m-5 {
            margin: 3rem;
        }

        .mt-5,
        .my-5 {
            margin-top: 3rem;
        }

        .mr-5,
        .mx-5 {
            margin-right: 3rem;
        }

        .mb-5,
        .my-5 {
            margin-bottom: 3rem;
        }

        .ml-5,
        .mx-5 {
            margin-left: 3rem;
        }

        .p-0 {
            padding: 0;
        }

        .pt-0,
        .py-0 {
            padding-top: 0;
        }

        .pr-0,
        .px-0 {
            padding-right: 0;
        }

        .pb-0,
        .py-0 {
            padding-bottom: 0;
        }

        .pl-0,
        .px-0 {
            padding-left: 0;
        }

        .p-1 {
            padding: 0.25rem;
        }

        .pt-1,
        .py-1 {
            padding-top: 0.25rem;
        }

        .pr-1,
        .px-1 {
            padding-right: 0.25rem;
        }

        .pb-1,
        .py-1 {
            padding-bottom: 0.25rem;
        }

        .pl-1,
        .px-1 {
            padding-left: 0.25rem;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .pt-2,
        .py-2 {
            padding-top: 0.5rem;
        }

        .pr-2,
        .px-2 {
            padding-right: 0.5rem;
        }

        .pb-2,
        .py-2 {
            padding-bottom: 0.5rem;
        }

        .pl-2,
        .px-2 {
            padding-left: 0.5rem;
        }

        .p-3 {
            padding: 1rem;
        }

        .pt-3,
        .py-3 {
            padding-top: 1rem;
        }

        .pr-3,
        .px-3 {
            padding-right: 1rem;
        }

        .pb-3,
        .py-3 {
            padding-bottom: 1rem;
        }

        .pl-3,
        .px-3 {
            padding-left: 1rem;
        }

        .p-4 {
            padding: 1.5rem;
        }

        .pt-4,
        .py-4 {
            padding-top: 1.5rem;
        }

        .pr-4,
        .px-4 {
            padding-right: 1.5rem;
        }

        .pb-4,
        .py-4 {
            padding-bottom: 1.5rem;
        }

        .pl-4,
        .px-4 {
            padding-left: 1.5rem;
        }

        .p-5 {
            padding: 3rem;
        }

        .pt-5,
        .py-5 {
            padding-top: 3rem;
        }

        .pr-5,
        .px-5 {
            padding-right: 3rem;
        }

        .pb-5,
        .py-5 {
            padding-bottom: 3rem;
        }

        .pl-5,
        .px-5 {
            padding-left: 3rem;
        }

        .m-auto {
            margin: auto;
        }

        .mt-auto,
        .my-auto {
            margin-top: auto;
        }

        .mr-auto,
        .mx-auto {
            margin-right: auto;
        }

        .mb-auto,
        .my-auto {
            margin-bottom: auto;
        }

        .ml-auto,
        .mx-auto {
            margin-left: auto;
        }

        .text-primary {
            color: #007bff;
        }

        a.text-primary:hover, a.text-primary:focus {
            color: #0056b3;
        }

        .text-secondary {
            color: #6c757d;
        }

        a.text-secondary:hover, a.text-secondary:focus {
            color: #494f54;
        }

        .text-success {
            color: #28a745;
        }

        a.text-success:hover, a.text-success:focus {
            color: #19692c;
        }

        .text-info {
            color: #17a2b8;
        }

        a.text-info:hover, a.text-info:focus {
            color: #0f6674;
        }

        .text-warning {
            color: #ffc107;
        }

        a.text-warning:hover, a.text-warning:focus {
            color: #ba8b00;
        }

        .text-danger {
            color: #dc3545;
        }

        a.text-danger:hover, a.text-danger:focus {
            color: #a71d2a;
        }

        .text-light {
            color: #f8f9fa;
        }

        a.text-light:hover, a.text-light:focus {
            color: #cbd3da;
        }

        .text-dark {
            color: #343a40;
        }

        a.text-dark:hover, a.text-dark:focus {
            color: #121416;
        }

        .text-body {
            color: #212529;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-black-50 {
            color: rgba(0, 0, 0, 0.5);
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
    @yield('heads')
</head>
<body>
@yield('content')
@include('components.wap.notice')
</body>
@stack('scripts')
</html>