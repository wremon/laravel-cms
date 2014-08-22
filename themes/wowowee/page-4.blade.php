@extends( 'master' )
@include( 'header' )
@include( 'comment' )


@section( 'content' )
	<div class="span12">

		<div class="row">
			<div class="span8">
				<h1>
					{{ $post->title }}<br>
					<small>By {{-- Post::getAuthor( 'full_name' ) --}}</small>
				</h1>
				Date posted {{-- Post::getPostDate( 'M d Y' ) --}}
				{{-- Post::editLink(); --}}
				<hr>

				<article>
					{{ $post->content }}

					
				</article>
				
				{{--@yield( 'comment' )--}}

			</div>
		</div>

	</div>
page-4
@endsection

@include( 'footer' )