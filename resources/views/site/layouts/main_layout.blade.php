<!DOCTYPE HTML>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js">
<!--<![endif]-->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!--[if lt IE 9]> 
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<![endif]-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>@yield('title', env('APP_NAME','Main page default title'))</title>
		<meta name="description" content="">
		<meta name="author" content="Themesrefinery">
		<!--[if lt IE 9]>
				<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!--[if lte IE 8]>
				<script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
		<![endif]-->
		@stack('css')
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/css/main.css') }}">
	</head>
	<body>
		<!--Top Header-->
		@include('site.parent_templates.header_template')
		<!--Top Header End-->

		<!--Slider Start-->
		@isset($sliders)
			@include('site.parent_templates.slider_template',[ 'allSlides' => $sliders ])
		@endisset
		<!--Slider Start-->

		<!--Main Body-->
		<div class="container">
		   <div class="row">
			@yield('content')
			<!--Sidebar Start-->
			@include('site.parent_templates.main_sidebar_template')
			 <!--Sidebar End--> 
			</div>
			<!--Footer Start-->
			@include('site.parent_templates.footer_template')
			<!--Footer End-->
		</div>
		<!--Main Body End-->

		<script src="{{asset('assets/site/js/site.js')}}" type="text/javascript"></script>
		@stack('scripts_bottom')
	</body>
</html>
