<?php 

class AuthController extends BackendBaseController {

	/*
	|--------------------------------------------------------------------------
	| Authentication controller
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
		/*User::add(
			1,
			'lumapas.remon@gmail.com',
			'admin',
			'admin',
			'Remon',
			'Lumapas'
		);*/
	}

	public function user(){
		if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
		{
			return Redirect::intended(Setting::getOption('admin_path', TRUE));
		}else{
			return Redirect::to(Request::url())
				->withInput(Input::except('password'))
				->with('message', Lang::get('dashboard.login_failed'));
		}
	}



}