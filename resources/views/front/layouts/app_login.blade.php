<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
    <title>Admin</title>

    @include('layouts.css')
	@yield('css')
    <!-- Styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
	<div class="app-wrapper">
		<!--
			Sidebar	| Topbar	
			        | Content
		-->
		@yield('login-container')

		

		<input type="hidden" name="message" 
			value="{{session()->has('message')?session('message'):''}}"/>
		<?php 
			if(Session::has('errorMessage')) {
				$errorMessage = Session::get('errorMessage');
			}
		?>
		<input type="hidden" 
			value="{{!empty($errorMessage)?$errorMessage:''}}" 
			name="error-message"
		/>
	</div>

	@include('layouts.js')
    <!-- Scripts -->
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('js')
</body>
</html>
