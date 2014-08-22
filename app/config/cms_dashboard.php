<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Required assets
	|--------------------------------------------------------------------------
	|
	| This array of class assets CSS and Javascript/jQuery
	| You can add your own assets in controllers by pushing the folder name/filename
	|
	*/
	'assets' 	=> array(
					'header' 	=> array(
						'css' 		=> array(
							'bootstrap.min',
							'font-awesome.min',
							'ionicons.min',
							// 'morris/morris',
							// 'jvectormap/jquery-jvectormap-1.2.2',
							// 'fullcalendar/fullcalendar',
							// 'daterangepicker/daterangepicker-bs3',
							'jQueryUI/jquery-ui.min',
							// 'bootstrap-wysihtml5/bootstrap3-wysihtml5.min',
							'AdminLTE',
							'custom',
						),
						'js' 		=> array()
					),
					'footer' 	=> array(
						'js' 		=> array(
							'jquery-2.0.2.min',
							'jquery-ui.min',
							'bootstrap.min',
							'raphael-min',
							// 'plugins/morris/morris.min',
							// 'plugins/sparkline/jquery.sparkline.min',
							// 'plugins/jvectormap/jquery-jvectormap-1.2.2.min',
							// 'plugins/jvectormap/jquery-jvectormap-world-mill-en',
							// 'plugins/fullcalendar/fullcalendar.min',
							// 'plugins/jqueryKnob/jquery.knob',
							// 'plugins/daterangepicker/daterangepicker',
							// 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min',
							// 'plugins/iCheck/icheck.min',
							'AdminLTE/app'
						)
					)
				),

);
