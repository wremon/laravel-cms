@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')
	
	{{-- Alert --}}
	<div id="alert-container" class="col-md-12">
		{{alertShow('success', Session::get('message'))}}
		{{alertGroup('danger', $errors, array_keys($fields))}}
	</div>

	{{-- Form --}}
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">

				{{Form::model($settingsValue, array('class' => 'form', 'id' => 'form-security'))}}

				@foreach ($fields as $key => $value)
					<div class="row form-group title">
						<div class="col-md-2">
							{{Form::label($key, $value['text'])}}
						</div>

						<div class="col-md-10">

							@if ($value['type'] == 'checkbox')
								{{Form::$value['type']($key, $key, NULL, array('class' => 'form-control'))}}
							@elseif ($value['type'] == 'colorpicker')
								{{Form::$value['type'](array('1111', '222'))}}
							@else
								{{Form::$value['type']($key, NULL, array('class' => 'form-control'))}}
							@endif

							<small>{{$value['description']}}</small>
						</div>
					</div>
				@endforeach
				
				{{Form::submit(Lang::get('dashboard.save'), array('class' => 'btn btn-success'))}}
				{{Form::close()}}

			</div>
		</div>
	</div>
	

	{{-- Dialog --}}
	<div id="dialog-delete-post-type" title="Delete post type" class="hide">
		<p class="text">Are you sure you want to delete post type</p>
	</div>

@endsection

@include('layouts.footer')