@section('head')
	<?php 
	if (!isset($title)){
		$title = Lang::get('dashboard.untitled_page');
	}
	?>
	<title>{{strip_tags($title)}} {{Config::get('app.app_name_divider')}} {{strip_tags(Config::get('app.app_name'))}}</title>

	<?php // If the assets is not defined in the controller, we'll get it from the config
	if (!isset($assets)){
		$assets = Config::get('cms_dashboard.assets');
	} ?>


	{{-- Header CSS --}}
	@foreach ($assets['header']['css'] as $asset)
		<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('css/' . $asset . '.css'); ?>" />
	@endforeach


	{{-- Header JS --}}
	@foreach ($assets['header']['js'] as $asset)
		<script src="<?php echo URL::asset('js/' . $asset . '.js'); ?>"></script>
	@endforeach
@endsection