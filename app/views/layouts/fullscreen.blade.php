<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		@yield('header')
	</head>


	<?php 
	if (!isset($title)){
		$title = Lang::get('dashboard.unset');
	}
	?>
	<body class="fullscreen <?php echo slugMake($title); ?> row">
		@yield('content')
		@yield('footer')
	</body>
</html>