<?php

class FrontendBaseController extends Controller {

	protected function __construct()
	{
		$this->themeName 	= Setting::getOption('template', TRUE);
		$this->themePath 	= base_path().'/themes/'.$this->themeName;
		
		View::addLocation(base_path().'/themes/'.$this->themeName);
		View::addNamespace('theme', base_path().'/themes/'.$this->themeName);


		if (file_exists(base_path().'/themes/'.$this->themeName.'/functions.php'))
		{
			include_once base_path().'/themes/'.$this->themeName.'/functions.php';
		}
	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if (! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}




}