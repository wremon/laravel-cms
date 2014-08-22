<div class="box box-info">
	<div class="box-header">
		<h3 class="box-title">{{Lang::get('dashboard.content_settings', array('post-type' => ''))}}</h3>
		
		<div class="pull-right box-tools">
			<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body pad">
		<table class="table">

			@if (isset($post->created_at) && isset($post->updated_at))
				{{-- Post created --}}
				<tr>
					<td>{{Lang::get('dashboard.created_at')}}</td>
					<td>
						{{$post->created_at}} <a href="#" data-effect="toggle" data-target="toggle-created">{{Lang::get('dashboard.edit')}}</a>
					</td>
				</tr>
				<tr class="toggle-created hide">
					<td class="row" colspan="2">
						<div class="note col-md-3">{{Lang::get('dashboard.status')}}</div>
						<div class="col-md-9">
							{{Form::text('created_at', NULL, array('class' => 'form-control'))}}
						</div>
					</td>
				</tr>
				

				{{-- Post updated --}}
				<tr>
					<td>{{Lang::get('dashboard.updated_at')}}</td>
					<td>
						{{$post->updated_at}} <a href="#" data-effect="toggle" data-target="toggle-updated">{{Lang::get('dashboard.edit')}}</a>
					</td>
				</tr>
				<tr class="toggle-updated hide">
					<td class="row" colspan="2">
						<div class="note col-md-3">{{Lang::get('dashboard.status')}}</div>
						<div class="col-md-9">
							{{Form::text('updated_at', NULL, array('class' => 'form-control'))}}
						</div>
					</td>
				</tr>
			@endif

			
			{{-- Post status --}}
			<tr>
				<td>{{Lang::get('dashboard.status')}}</td>
				<td>{{$postStatus[$post->status]}} <a href="#" data-effect="toggle" data-target="toggle-post-status">{{Lang::get('dashboard.edit')}}</a></td></td>
			</tr>
			<tr class="toggle-post-status hide">
				<td class="row" colspan="2">
					<div class="note col-md-3">{{Lang::get('dashboard.status')}}</div>
					<div class="col-md-9">
						{{Form::select('status', $postStatus, NULL, array('class' => 'form-control'))}}
					</div>
				</td>
			</tr>

		</table>
	</div>
</div>