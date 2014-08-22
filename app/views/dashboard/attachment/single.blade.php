@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')
	
	{{-- Alert --}}
	<div id="alert-container" class="col-md-12">
		{{alertShow('success', Session::get('message'))}}
		{{alertGroup('danger', $errors, array('title', 'slug'))}}
	</div>


	{{-- Form --}}
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">				
				{{Form::open(array('url' => $formAction, 'files'=> true))}}		

					<div class="row">
						<div class="col-md-4">
							<span class="thumbnail">
								<img src="{{url(Setting::getOption('upload_path').$attachment->file_name)}}" id="upload-image-preview" >
							</span>
						</div>

						<div class="col-md-8">
							<div class="row form-group attachment-title">
								<div class="col-md-1">
									{{Form::label('attachment-title', Lang::get('dashboard.title'))}}
								</div>

								<div class="col-md-11">
									{{Form::text('attachment-title', ifNull(Input::old('attachment-title'), $attachment->title), array('class' => 'form-control'))}}
								</div>
							</div>

							<div class="row form-group attachment-slug">
								<div class="col-md-1">
									{{Form::label('attachment-slug', Lang::get('dashboard.slug'))}}
								</div>

								<div class="col-md-11">
									{{Form::text('attachment-slug', ifNull(Input::old('attachment-slug'), $attachment->slug), array('class' => 'form-control'))}}
								</div>
							</div>

							<div class="attachment-description form-group">
								{{Form::label('attachment-description', Lang::get('dashboard.description'))}}

								{{Form::textarea('attachment-description', ifNull(Input::old('attachment-description'), $attachment->description), array('class' => 'form-control editor'))}}
							</div>

							{{Form::submit(Lang::get('dashboard.upload'), array('class' => 'btn btn-success'))}}
						</div>
					</div>
					
				{{Form::close()}}	
			</div>
		</div>
	</div>

@endsection

@include('layouts.footer')