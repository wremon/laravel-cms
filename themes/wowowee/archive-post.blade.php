@extends( 'master' )
@include( 'header' )



@section( 'content' )

	<div class="span12">

		<div class="row">
			<div class="span8">
				@foreach ( $posts as $post )
					<h2>
						{{ $post->title }}<br>						
					</h2>

					Date posted: {{ $post->created_at }}
					
					<p>{{ substr( strip_tags( $post->content ), 0, 350 ) }}</p>

					<a href="{{url($post->slug)}}">Read more</a>
					<hr>
				@endforeach
	

			</div>
		</div>

	</div>

@endsection

@include( 'footer' )