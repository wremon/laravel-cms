@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')
	
	{{-- Alert --}}
	<div id="alert-container" class="col-md-12">
		{{alertShow('success', Session::get('message'))}}
		{{alertGroup('danger', $errors, array('name', 'slug'))}}
	</div>

	{{-- Form --}}
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h3 class="box-title">{{Lang::get('dashboard.editor')}}</h3>
				
				<div class="pull-right box-tools">
					<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>


			<div class="box-body pad">
				{{Form::open(array('class' => 'form', 'id' => 'form-post-type'))}}

				<div class="form-group">
					{{Form::label('name', Lang::get('dashboard.name'))}}
					{{Form::text('name', NULL, array('class' => 'form-control'))}}
				</div>

				<div class="form-group">
					{{Form::label('name', Lang::get('dashboard.slug'))}}
					{{Form::text('slug', NULL, array('class' => 'form-control'))}}
				</div>

				{{Form::submit(Lang::get('dashboard.save'), array('class' => 'btn btn-success'))}}
				{{Form::close()}}
			</div>
		</div>
	</div>


	{{-- Table --}}
	<div class="col-md-8">
		<div class="box box-solid">
			<div class="box-body">	

				<table class="table">
					<thead>
						<tr>
							<th>{{Lang::choice('dashboard.post_type', 1)}}</th>
							<th>{{Lang::get('dashboard.slug')}}</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="sortable" data-sortable-id="post-types">
						{{-- Post types --}}
						@foreach ($postTypes as $key => $value)
							<tr id="row-{{$key}}" data-id="{{$key}}">
								<td>
									<span class="handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									</span> 
									&nbsp;
									{{$value['name']}}
								</td>
								<td>{{$value['slug']}}</td>
								<td>
									<div class="dropdown pull-right">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
											{{Lang::choice('dashboard.action', 2)}}
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
											<li role="presentation"><a href="{{route('all_'.$key.'_posts', $key)}}" title="{{Lang::get('dashboard.goto', array('to' => $value['name']))}}" role="menuitem" tabindex="-1">{{Lang::choice('dashboard.post', 2)}}</a></li>
											<li role="presentation"><a href="{{route('post_type_meta', $key)}}" title="{{Lang::get('dashboard.meta_fields', array('post-type' => $value['name']))}}">{{Lang::get('dashboard.meta')}}</a></li>
											<li role="presentation" class="divider"></li>
											<li role="presentation"><a href="#" data-id="{{$key}}" class="edit-post-type" role="menuitem" tabindex="-1">{{Lang::get('dashboard.edit')}}</a></li>
											<li role="presentation"><a href="#" data-id="{{$key}}" class="delete-post-type" role="menuitem" tabindex="-1">{{Lang::get('dashboard.delete')}}</a></li>
										</ul>
									</div>
								</td>
							</tr>
						@endforeach
										
					</tbody>
				</table>

				<a href="#" class="btn btn-success update-sortable" data-sortable="post-types">Update</a>

			</div>
		</div>
	</div>
	

	{{-- Dialog --}}
	<div id="dialog-delete-post-type" title="Delete post type" class="hide">
		<p class="text">Are you sure you want to delete post type</p>
	</div>

@endsection

@include('layouts.footer')