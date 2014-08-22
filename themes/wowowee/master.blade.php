<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		
		<link rel="stylesheet" type="text/css" href="{{ url('/css/bootstrap.min.css') }}" />

		@yield( 'header' )
	</head>


	<body class="{{-- $bodyClass --}}">
		{{ 'Using template: <strong>' . $template_file . '.blade.php</strong>' }}
		<div class="container">
			
			<div id="main-content" class="row">
				<div class="span12">
					<div class="row">
						@yield( 'content' )
					</div>
				</div>
			</div>
			 
			<div class="sidebar">
				@yield( 'sidebar' )
			</div>
		</div>

		@yield( 'footer' )
	</body>
</html>