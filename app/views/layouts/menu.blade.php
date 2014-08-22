@section('menu')
	<nav class="navigation">
		{{--
			Menu::make(
			'top-nav',
			'nav nav-stacked side-navigation',
			array(
				// id 	=> 'text:Menu Text:url:www.domain.com:class:class-1,class-2',
				'home'		=> 'text:' . Lang::get('dashboard.visit_site') . '|url:/|class:abc,def',
				'post'		=> 'text:' . Lang::get('dashboard.posts') . '|url:dashboard/content/post/all|class:abc,def',
				'page'		=> 'text:' . Lang::get('dashboard.pages') . '|url:dashboard/content/page/all|class:abc,def',
				'user'		=> 'text:' . Lang::get('dashboard.users') . '|url:dashboard/user|class:active,most-active',
				'logs'		=> 'text:' . Lang::get('dashboard.action_logs') . ' |url:dashboard/logs|class:inactive,not-so-active',
				'sign-out'	=> 'text:' . Lang::get('dashboard.sign_out') . '|url:dashboard/sign-out|class:active,most-active',
			)
		)--}}
		<ul class="sidebar-menu">
			<li class="treeview">
				<a href="#">
					<i class="fa fa-edit"></i> <span>{{Lang::choice('dashboard.post', 2)}}</span>
					<i class="fa pull-right fa-angle-down"></i>
				</a>
				<ul class="treeview-menu">
					@foreach (Setting::getOptionArray('post_type') as $key => $value)
						<li><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/content/'.$key.'/list-all')}}" title="{{Lang::get('dashboard.goto', array('to' => $value['name']))}}"><i class="fa fa-angle-double-right"></i> {{$value['name']}}</a></li>
					@endforeach
				</ul>
			</li>

			<li class="treeview">
				<a href="#">
					<i class="fa fa-paperclip"></i> <span>{{Lang::choice('dashboard.attachments', 2)}}</span>
					<i class="fa pull-right fa-angle-down"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/attachment/')}}"><i class="fa fa-angle-double-right"></i> {{Lang::get('dashboard.new_attachment')}}</a></li>
					<li><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/attachment/list-all')}}" title="{{Lang::get('dashboard.goto', array('to' => Lang::get('dashboard.attachments')))}}"><i class="fa fa-angle-double-right"></i> {{Lang::get('dashboard.all_attachments')}}</a></li>
				</ul>
			</li>


			<li class="treeview">
				<a href="#">
					<i class="fa fa-cog"></i> <span>{{Lang::get('dashboard.settings')}}</span>
					<i class="fa pull-right fa-angle-down"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/settings/general')}}" title="{{Lang::get('dashboard.goto', array('to' => Lang::get('dashboard.general')))}}"><i class="fa fa-angle-double-right"></i> {{Lang::get('dashboard.general')}}</a></li>
					<li><a href="{{route('post_types')}}" title="{{Lang::get('dashboard.goto', array('to' => Lang::choice('dashboard.post_type', 2)))}}"><i class="fa fa-angle-double-right"></i> {{Lang::choice('dashboard.post_type', 2)}}</a></li>
					<li><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/settings/security')}}" title="{{Lang::get('dashboard.goto', array('to' => Lang::get('dashboard.security')))}}"><i class="fa fa-angle-double-right"></i> {{Lang::get('dashboard.security')}}</a></li>
					<li><a href="{{url(Setting::getOption('dashboard_path', TRUE).'/settings/template')}}" title="{{Lang::get('dashboard.goto', array('to' => Lang::get('dashboard.template')))}}"><i class="fa fa-angle-double-right"></i> {{Lang::get('dashboard.template')}}</a></li>
				</ul>
			</li>

		</ul>
	</nav>
@endsection