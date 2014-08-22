<?php 

class DashboardController extends BackendBaseController {

	/*
	|--------------------------------------------------------------------------
	| Login controller
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	public function index()
	{
		return View::make('dashboard.main')
			->with( 
				array( 
					'title' 		=> Lang::get('dashboard.dashboard'),
					'inlineJs' 	 	=> 'var targetUser = "qwerty";',
				) 
			);
	}


	/* ---------------------------------
	Log out user
	--------------------------------- */
	public function signOut(){
		Auth::logout();
		Redirect::to('dashboard/log-in');
	}

}