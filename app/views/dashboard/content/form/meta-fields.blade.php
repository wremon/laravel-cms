@if ($metaFields)
	<div class="box box-info">
		<div class="box-header">
			<h3 class="box-title">{{Lang::get('dashboard.meta_fields', array('post-type' => ''))}}</h3>
			
			<div class="pull-right box-tools">
				<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body pad">
			@foreach ($metaFields as $field => $attr)
				<?php $type = $attr['type']?>
				<div class="row">
					<div class="col-md-2">{{Form::label('meta_'.$field, $attr['text'])}}</div>
					<div class="col-md-10">
						@if ($type == 'checkbox')
							{{Form::$type('meta_'.$field, $post->{'meta_'.$field}, NULL, array('class' => 'form-control'))}}
						@elseif ($type == 'colorpicker')
							{{Form::$type(array('1111', '222'))}}
						@else
							{{Form::$type('meta_'.$field, NULL, array('class' => 'form-control'))}}
						@endif

						<p class="note">{{$attr['description']}}</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endif