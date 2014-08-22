<?php 

class PageController extends FrontendBaseController {

	/*
	|--------------------------------------------------------------------------
	| Content controller
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	function __construct()
	{
		parent::__construct();
	}

	
	public function index()
	{
		$post = Post::all();
		$page = new Template($post);

		$page->variables(array(
				'post'			=> $post->first(),
				'posts'			=> $post,
				'bodyClass'		=> $page->bodyClass(),
			))->template();
		
		echo $page->show();
	}


	public function getPost($post)
	{
		dd($post);
		// $page = new Template($post);

		// $page->variables(array(
		// 		'posts'			=> $post,
		// 		'pageTitle'		=> $post->first()->title,
		// 		'bodyClass'		=> $page->bodyClass(),
		// 	))->template();
		// echo $page->type;
		// echo $page->templateFile;
		// echo $page->show();
	}
}