@extends( 'layouts.error' )
@include( 'layouts.head' )


@section( 'content' )

	<div class="error-container col-md-6 col-md-offset-3">
		<h1 id="title" class="text-center">No sections</h1>
		<p id="message">Last week I looked at setting up your first Controller in Laravel 4. Controllers are what dictate how data is transferred between your Models and Views and vice versa. We set up our first RESTful controller and I described what each of the methods should be used for.</p>
	</div>
@endsection


@include( 'layouts.footer' )