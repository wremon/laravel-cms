@extends( 'layouts.error' )
@include( 'layouts.head' )


@section( 'content' )

	<div class="error-container col-md-6 col-md-offset-3">
		<h1 id="title" class="text-center">Invalid token</h1>
		<p id="message">A filter is basically a chunk of code that you will typically want to run either before or after Laravel routes a request.</p>
	</div>
@endsection


@include( 'layouts.footer' )