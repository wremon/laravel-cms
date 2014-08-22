<?php 

class Page
{

	/**
	 * Content(s) to be displayed
	 *
	 */
	private static $posts;


	/**
	 * Content's post type
	 *
	 */
	public static $postType;


	/**
	 * Type
	 * Type of template
	 *
	 */
	public static $type;

	/**
	 * Allowed static template types
	 *
	 */
	private static $allowedTemplateType = array('attachment', 'index', '404');


	/**
	 * Page title
	 *
	 */
	static $title;


	/**
	 * Template to use
	 *
	 */
	private static $template;
	

	/**
	 * Array of variables to be passed to view
	 *
	 */
	private static $viewVariables;






	function __construct(Template $template)
	{
		$this->template = $template;
	}

	public static function create($post)
	{
		self::$posts = $post;
	}




	/**
	 * Get the type of template
	 *
	 * @return 	object
	 */
	private function getTemplateType()
	{
		$postType 	= Setting::getOptionArray('post_type', TRUE);
		$post 		= self::$posts->first();

		if (count(self::$posts) == 1)
		{
			self::$postType = $postType[$post->post_type];
			self::$type = $post->post_type;
		}
		else
		{
			self::$postType = $postType[$post->post_type];
			self::$type = 'archive';
		}
		
	}


	/**
	 * Set the template type
	 *
	 * @return 	object
	 */
	public static function getTitle()
	{
		if (count(self::$posts) == 1)
		{
			$post 		= self::$posts->first();
			return $post->title;
		}
	}


	/**
	 * Set variables to send to view
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public static function bodyClass($userDefined = NULL)
	{
		$classes = '';

		foreach (self::$posts as $post)
		{
			$classes .= $post->post_type . ' ';
			$classes .= slugMake($post->title) . ' ';

			$classes .= $post->post_type.'-'.$post->id . ' ';
		}
		return $classes.' '.$userDefined;
	}


	/**
	 * Set variables to send to view
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public static function variables($variables)
	{
		self::$viewVariables = $variables;
		
	}


	/**
	 * Sets the page template
	 *
	 * @param  	string 	$customTemplate
	 * @return 	object
	 */
	public static function template($customTemplate = NULL)
	{
		if (!is_null($customTemplate))
		{
			self::$template = self::getTemplate($customTemplate);
			
		}

		View::addLocation(base_path() . '/themes/' . Setting::getOption('template', TRUE));
		View::addNamespace('theme', base_path() . '/themes/' . Setting::getOption('template', TRUE));

		$template = NULL;


		if (self::$type == 'page')
		{
			/* Hirarchy: 
			-> page-{id}.blade.php
			-> page-{slug}.blade.php
			-> page.blade.php 
			-> index.blade.php
			*/
			$post 		= self::$posts->first();
			$hirarchy 	= array('page-'.$post->id, 'page-'.$post->slug, 'page', 'index');
		}
		elseif (in_array(self::$type, self::getPostTypeSlugs()))
		{
			/* Hirarchy: 
			-> single-{post-type}.blade.php
			-> single.blade.php 
			-> index.blade.php
			*/
			$hirarchy = array('single-'.self::$type, 'single', 'index');
		}
		else
		{
			/* Hirarchy: 
			-> index.blade.php
			*/
			$hirarchy = array('index');
		}


		// Get the view
		foreach ($hirarchy as $file)
		{
			if (!$template)
			{
				$template 	= self::getTemplate($file);
			}
		}

		self::$template = $template;
		
	}


	/**
	 * Returns the page template
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public static function show()
	{
		dd(self::$template);
		return self::$template;
	}


	/**
	 * Determines the current objects template file to use
	 *
	 * @param  	string 	$file
	 * @return 	object
	 */
	private static function getTemplate($file)
	{
		try
		{
			View::getFinder()->find('theme::'.$file);

			return View::make('theme::'.$file)->with(self::$viewVariables);
		}
		catch (InvalidArgumentException $error)
		{
			
			return false;
		}
	} 


	/**
	 * Get all post type's slug
	 *
	 * @return 	array
	 */
	static function getPostTypeSlugs()
	{
		$postSlugs = array();
		foreach (Setting::getOptionArray('post_type', TRUE) as $key => $value)
		{
			$postSlugs[] = $value['slug'];
		}
		return $postSlugs;
	}
}