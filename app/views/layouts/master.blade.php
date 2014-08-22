<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		@yield('header')
	</head>


	<body class="template <?php echo slugMake($title); ?>">

		<div class="container">

			<div class="row">
				<div class="col-md-8">
					<nav class="navigation">
						<?php 
						echo Menu::make(
							'top-nav',
							'nav nav-pills',
							array(
								// id 	=> 'text:Menu Text:url:www.domain.com:class:class-1,class-2',
								'home'		=> 'text:' . Lang::get('dashboard.visit_site') . '|url:/|class:abc,def',
								'post'		=> 'text:' . Lang::get('dashboard.posts') . '|url:dashboard/content/post/all|class:abc,def',
								'page'		=> 'text:' . Lang::get('dashboard.pages') . '|url:dashboard/content/page/all|class:abc,def',
								'user'		=> 'text:' . Lang::get('dashboard.users') . '|url:dashboard/user|class:active,most-active',
								'logs'		=> 'text:' . Lang::get('dashboard.action_logs') . ' |url:dashboard/logs|class:inactive,not-so-active',
								'log-out'	=> 'text:' . Lang::get('dashboard.log_out') . '|url:dashboard/user/sign-out|class:active,most-active',
							)
						); ?>
					</nav>
				</div>
				<div class="col-md-4 text-right">
					{{ Lang::get('dashboard.welcome', array('name' => '<strong> USER HERE! </strong>')); }}
				</div>
			</div>

			<div id="main-content" class="row">
				@if (isset($title))
					<div class="col-md-12 page-title">
						<h1>
							@if (isset($icon))
								<i class="{{ $icon }} padd-r-0"></i>
							@endif
							{{ $title }}
						</h1>
					</div>
				@endif
				<div class="col-md-12">
					<div class="row">
						@yield('alerts')
					</div>
				</div>

				<div class="col-md-12">
					<div class="row">
						@yield('content')
					</div>
				</div>
			</div>
			 
			<div class="sidebar">
				@yield('sidebar')
			</div>
		</div>

		@yield('footer')	
	</body>
</html>