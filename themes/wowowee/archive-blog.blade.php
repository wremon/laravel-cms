@extends( 'master' )
@include( 'header' )



@section( 'content' )

	<div class="span12">

		<div class="row">
			<div class="span8">
				@foreach ( $posts as $post )
					<?php 
					/*
					 * Get the current post's meta data
					 */
					$meta = Meta::getMultiple($post->id, TRUE);
					?>

					<h2 class="entry-title">
						{{ $post->title }}<br>						
					</h2>
					
					<div class="entry-meta">
						Date posted: {{ $post->created_at }}
						{{ $post->editLink() }}
					</div>
					
					<div class="entry-content">
						<p>{{ $post->excerpt() }}</p>
					</div>

					<a href="{{$post->permalink()}}">Read more</a>
					<hr>
				@endforeach
	

			</div>
		</div>

	</div>

@endsection

@include( 'footer' )