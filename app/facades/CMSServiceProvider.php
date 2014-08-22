<?php 
use Illuminate\Support\ServiceProvider;

class CMSServiceProvider extends ServiceProvider
{
	public function register() {
		App::bind( 'Page', function(){
			return new Page;
		} );

	}

}