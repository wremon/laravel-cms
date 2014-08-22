@extends('layouts.fullscreen')
@include('layouts.head')
@include('layouts.alerts')


@section('content')

	<div class="col-md-6 col-md-offset-3">
		{{ Form::open(array('id' => 'form-login')) }}


			@if (Session::get('message'))
				<div class="alert alert-error">
					{{Session::get('message')}}
				</div>
			@endif

			<div class="row">
				<div class="col-md-4">
					{{ Form::label('username', Lang::get('dashboard.username')) }}
				</div>
				<div class="col-md-8">
					@if (Input::old('username'))
						{{ Form::text('username', NULL, array('class' => 'form-control required ', 'disabled')) }}
					@else
						{{ Form::text('username', Input::old('username'), array('class' => 'form-control required ')) }}
					@endif
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					{{ Form::label('password', Lang::get('dashboard.password')) }}
				</div>
				<div class="col-md-8">
					{{ Form::password('password', array('class' => 'form-control required ')) }}
				</div>
			</div>

			<div class="row">
				<div class="col-md-8 col-md-offset-4">
					{{ Form::submit(Lang::get('dashboard.sign_in') , array('class' => 'btn btn-success')) }}
				</div>
			</div>

		{{ Form::close() }}
	</div>

@endsection

@include('layouts.footer')