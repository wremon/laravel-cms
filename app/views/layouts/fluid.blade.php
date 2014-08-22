<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		
		@include('layouts.head')
		@yield('head')
	</head>


	<?php 
	if (!isset($title)){
		$title = Lang::get('dashboard.unset');
	}
	?>
	<body class="skin-blue wysihtml5-supported  pace-done fullscreen {{slugMake($title)}}">

		@include('layouts.header')
		@yield('header')

		<div class="wrapper row-offcanvas row-offcanvas-left">
			<aside class="left-side sidebar-offcanvas">
				<section class="sidebar">
					@include('layouts.menu')
					@yield('menu')
				</section>
			</aside>
			<aside class="right-side">
				<section class="content-header">
					@include('layouts.content-header')
					@yield('content-header')
				</section>

				<section class="content">
					<div class="row">
						@yield('content')
					</div>
				</section>
			</aside>

			@include('layouts.footer')
			@yield('footer')
		</div>
	</body>
</html>