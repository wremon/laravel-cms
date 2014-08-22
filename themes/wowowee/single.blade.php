@extends( 'master' )
@include( 'header' )
@include( 'comment' )


@section( 'content' )
	<div class="span12">

		<div class="row">
			<div class="span8">

					<article id="post-{{ $post->id }}">
						<h1 class="entry-title">
							{{ $post->title }}<br>
							<small>By {{ $post->author->first_name }}</small>
						</h1>

						<div class="entry-meta">
							Date posted: {{ $post->created_at }}
							{{ $post->editLink() }}
						</div>
						<hr>
						
						<div class="entry-content">
							{{ $post->content }}
						</div>
					</article>				
				
				{{--@yield( 'comment' )--}}

			</div>
		</div>

	</div>

@endsection

@include( 'footer' )