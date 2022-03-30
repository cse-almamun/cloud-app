<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/x-icon" href="{{ asset('images/icons/cloud-service.png') }}">
<title>@yield('title')</title>
{{-- jQuery ui css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
{{-- toastr css --}}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
{{-- International Telephone --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css" />
{{-- materliaze css cdn --}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
{{-- Croppie.js css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
{{-- jquery enoji css --}}
<link rel="stylesheet" href="{{ asset('css/jquery.emojipicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/jquery.emojipicker.tw.css') }}">
{{-- Custom app css --}}
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
