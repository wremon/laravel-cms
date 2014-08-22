@section( 'search' )
	{{ Form::open( array( 'method' => 'get', 'role' => 'search' ) ) }}
		<div class="input-append">
			{{ Form::text( 's', Input::get( 's' ), array( 'class' => '', 'placeholder' => 'Search' ) ); }}
			{{ Form::submit( 'go', array( 'class' => 'btn' ) ); }}
		</div>
	{{ Form::close() }}
@endsection