@extends( 'master' )
@include( 'header' )
@include( 'comment' )


@section( 'content' )
	<div class="span12">

		<div class="row">
			<div class="span8">

				@foreach ( $posts as $post )

					<article id="post-{{ $post->id }}">
						<h1>
							{{ $post->title }}<br>
							<small>By {{ $post->author->first_name }}</small>
						</h1>
						Date posted: {{ $post->created_at }}
						{{-- Post::editLink(); --}}
						<hr>
						
						{{ $post->content }}
					</article>
				@endforeach

				
				
				{{--@yield( 'comment' )--}}

			</div>
		</div>

	</div>

@endsection

@include( 'footer' )