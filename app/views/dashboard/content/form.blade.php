@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.header')
@include('layouts.alerts')


@section('content')
	
	{{-- Alert --}}
	<div class="col-md-12">
		{{alertShow('success', Session::get('message'))}}
		{{alertGroup('danger', $errors, array('title', 'slug'))}}
	</div>


	{{-- Form --}}
	{{Form::model($post, array('class' => 'form'))}}

		<div class="col-md-12">
			<div class="row">
				<div class="col-md-8">
					<div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">{{Lang::get('dashboard.main_content')}}</h3>
							
							<div class="pull-right box-tools">
								<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>

						<div class="box-body pad">
							<div class="row form-group title">
								<div class="col-md-1">
									{{Form::label('title', Lang::get('dashboard.title'))}}
								</div>

								<div class="col-md-11">
									{{Form::text('title', NULL, array('class' => 'form-control'))}}
								</div>
							</div>

							<div class="row form-group slug">
								<div class="col-md-1">
									{{Form::label('slug', Lang::get('dashboard.slug'))}}
								</div>

								<div class="col-md-11">
									{{Form::text('slug', NULL, array('class' => 'form-control'))}}
								</div>
							</div>

							<div class="content form-group">
								{{Form::label('content', Lang::get('dashboard.content'))}}

								{{Form::textarea('content', NULL, array('class' => 'form-control editor', 'id' => 'content'))}}
								{{alertNote($errors, 'content')}}
							</div>
						</div>
					</div>
					
					{{-- Custom meta fields --}}
					@include('dashboard.content.form.meta-fields')
				</div>

				<div class="col-md-4">
					{{-- Custom meta fields --}}
					@include('dashboard.content.form.post-meta-data')

					{{Form::submit(Lang::get('dashboard.save'), array('class' => 'btn btn-success'))}}

					<?php 
					// Post preview
					if (isset($post->slug)) {?>
						<a href="{{route('post-'.$post->id)}}" class="btn btn-info" target="_blank">{{ Lang::get('dashboard.preview') }}</a>
					<?php } ?>

				</div>
			</div>
		</div>
	{{Form::close()}}

@endsection

@include('layouts.footer')