@section( 'alerts' )


	<div class="flexible">
		@if ( $errors->any() )
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				{{ implode( '', $errors->all( '<div>:message</div>' ) ) }}
			</div>
		@endif

		@if ( Session::get( 'error' ) )
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				{{ Session::get( 'error' ); }}
			</div>
		@endif

		@if ( Session::get( 'success' ) )
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				{{ Session::get( 'success' ); }}
			</div>
		@endif

		@if ( Session::get( 'info' ) )
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				{{ Session::get( 'info' ); }}
			</div>
		@endif
		
	</div>
@endsection