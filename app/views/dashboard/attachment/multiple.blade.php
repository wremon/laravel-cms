@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')

	{{-- Alert --}}
	<div id="alert-container" class="col-md-12">
		{{alertShow('success', Session::get('message'))}}
		{{alertGroup('danger', $errors, array('multiple-file-upload'))}}
		<?php // print_r($errors);?>
	</div>


	{{-- Form --}}
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">	
				{{Form::open(array('files'=> true, 'class' => 'multiple'))}}
					<div class="row">
						<div class="col-md-12">
							<div id="preview-zone">
								{{Form::file('attachments[]', array('id' => 'multiple-file-upload', 'multiple'))}}
							</div>
							<output id="attachments-list"></output>
							{{Form::submit(Lang::get('dashboard.upload'), array('class' => 'btn btn-success', 'name' => 'button'))}}
						</div>
					</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
@endsection

@include('layouts.footer')