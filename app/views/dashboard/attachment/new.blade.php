@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')

	{{Form::open(array('url' => $formAction, 'files'=> true, 'class' => 'multiple'))}}		

		{{alertShow()}}
		
		<div class="row">
			<div class="col-md-4">
				<div id="preview-zone">
					{{Form::file('attachments[]', array('id' => 'multiple-file-upload', 'multiple'))}}
				</div>
				<output id="attachments-list"></output>
				{{Form::submit(Lang::get('dashboard.upload'), array('class' => 'btn btn-success'))}}
			</div>
		</div>
		
	{{Form::close()}}

@endsection

@include('layouts.footer')