@extends( 'layouts.error' )
@include( 'layouts.head' )


@section( 'content' )

	<div class="error-container col-md-6 col-md-offset-3">
		<h1 id="title" class="text-center">No users</h1>
		<p id="message">Imposible to use because there is no way get through the login without a user.<br/>
			Use <code>php artisan db:seed</code> to insert the default users.</p>
	</div>
@endsection


@include( 'layouts.footer' )