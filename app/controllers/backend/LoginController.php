<?php 

class LoginController extends BackendBaseController {

	/*
	|--------------------------------------------------------------------------
	| Login controller
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/
	function __construct()
	{
		parent::__construct();
		array_push($this->assets['footer']['js'], 'custom');
	}

	public function index()
	{
		return View::make('dashboard.login.form')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.login'),
							'inlineJs' 	 	=> 'var targetUser = "qwerty";',
						) 
					);
	}



}