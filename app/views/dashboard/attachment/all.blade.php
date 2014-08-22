@extends('layouts.fluid')
@include('layouts.head')
@include('layouts.alerts')


@section('content')

	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{Lang::get('dashboard.attachment')}}</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($attachments as $attachment)
							<tr id="row-{{$attachment->id}}">
								<td>
									<img src="{{url($attachment->thumbnail('small'))}}" data-src="{{url(Setting::getOption('upload_path')).'/'.$attachment->file_name}}" class="{{$attachment->getClasses('img')}}">
									&nbsp;
									{{{$attachment->title}}}
								</td>
								<td>{{{$attachment->mime}}}</td>
								<td>
									<a href="{{url(Setting::getOption('dashboard_path', TRUE).'/attachment/'.$attachment->id)}}">{{Lang::get('dashboard.edit')}}</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>

@endsection

@include('layouts.footer')