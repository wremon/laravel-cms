<?php

class BackendBaseController extends Controller {

	protected function __construct()
	{		
		 /*
		|--------------------------------------------------------------------------
		| CSRF
		|--------------------------------------------------------------------------
		|
		| Perform CSRF check on all post/patch/put requests
		|
		*/
        $this->beforeFilter('csrf', array('on' => array('post', 'patch', 'put')));


        /*
		|--------------------------------------------------------------------------
		| Assets
		|--------------------------------------------------------------------------
		|
		| Used to modify the styles and scripts defined in cms_dashboard config
		| You may use this to control them depending on the loading page
		| 
		|
		*/
		$this->assets 		= Config::get( 'cms_dashboard.assets' );	


		/*
		|--------------------------------------------------------------------------
		| Session
		|--------------------------------------------------------------------------
		|
		| 
		|
		*/
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

	}

}