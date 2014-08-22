@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')
	
	{{-- Alert --}}
	<div id="alert-container" class="col-md-12">
		{{alertShow('success', Session::get('message'))}}
		{{alertGroup('danger', $errors, array('name', 'id'))}}
	</div>


	{{-- Table --}}
	<div class="col-md-12">
		{{Form::open(array('class' => 'form', 'id' => 'form-menu'))}}

		<div class="box box-solid">
			<div class="box-body">

				{{$menuItems}}

				<a href="#" class="save-menu">Save</a><br>
				<a href="#" class="new-menu">New</a>
			</div>
			{{--Form::submit(Lang::get('dashboard.save'), array('class' => 'btn btn-success'))--}}
		</div>
		{{Form::close()}}
	</div>
	

	{{-- Dialog --}}
	<div id="dialog-delete-post-type" title="Delete post type" class="hide">
		<p class="text">Are you sure you want to delete post type</p>
	</div>

@endsection

@include('layouts.footer')