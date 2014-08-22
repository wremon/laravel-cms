@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')
	
	{{-- Alert --}}
	<div id="alert-container" class="col-md-12">
		{{alertShow('success', Session::get('message'))}}
		{{alertGroup('danger', $errors, array('title', 'slug'))}}
	</div>
  

	{{-- Table --}}
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{Lang::get('dashboard.post_title')}}</th>
							<th>{{Lang::get('dashboard.created_at')}}</th>
							<th>{{Lang::get('dashboard.updated_at')}}</th>
							<th>{{Lang::get('dashboard.actions')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($posts as $post)
							<tr id="row-{{$post->id}}">
								<td><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/content/'.$postType.'/'.$post->id)}}">{{$post->title}}</a></td>
								<td>{{$post->created_at}}</td>
								<td>{{$post->updated_at}}</td>
								<td>
									<div class="dropdown pull-right">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
											{{Lang::choice('dashboard.action', 2)}}
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
											<li role="presentation"><a href="{{route('post-'.$post->id)}}" data-id="{{$post->id}}" class="edit-post-type" role="menuitem" tabindex="-1">{{Lang::get('dashboard.preview')}}</a></li>
											<li role="presentation"><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/content/'.$postType.'/'.$post->id)}}" data-id="{{$post->id}}" class="edit-post-type" role="menuitem" tabindex="-1">{{Lang::get('dashboard.edit')}}</a></li>
											<li role="presentation"><a href="#" data-id="{{$post->id}}" class="trash-post-item" role="menuitem" tabindex="-1">{{Lang::get('dashboard.trash')}}</a></li>
										</ul>
									</div>
									
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>


	{{-- Dialog --}}
	<div id="dialog-trash-post" title="{{$title}}" class="hide">
		<p class="text">Are you sure you want to move post to trash?</p>
	</div>

@endsection

@include('layouts.footer')