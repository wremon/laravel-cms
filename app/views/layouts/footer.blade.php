@section('footer')
	<?php 
	// If the assets is not defined in the controller, we'll get it from the config
	if (!isset($assets)){
		$assets = Config::get('cms_dashboard.assets');
	} 

	// Inline scripts
	if (!isset($inlineJs)){
		$inlineJs 	= 'var baseUrl = "' . URL::to('/') . '", dashboardUrl = "' . url(Setting::getOption('dashboard_path', TRUE)) . '", csrf = "' . csrf_token() . '";';
	}
	else
	{
		$inlineJs 	.= 'var baseUrl = "' . URL::to('/') . '", dashboardUrl = "' . url(Setting::getOption('dashboard_path', TRUE)) . '", csrf = "' . csrf_token() . '"';
	}
	?>
	{{--<script>//<![CDATA[{{ $inlineJs }}//]]></script>--}}
	<script>{{ $inlineJs }}</script>

	{{-- Footer JS --}}
	@foreach ($assets['footer']['js'] as $asset)
	<script src="<?php echo URL::asset('js/' . $asset . '.js'); ?>"></script>
	@endforeach
@endsection