<?php 

class Pages
{

	/**
	 * Content
	 *
	 */
	private static $object;


	/**
	 * Page type
	 *
	 */
	private static $type;


	/**
	 * Page title
	 *
	 */
	private static $title;


	private static $postType;


	private static $viewVariables;






	function __construct()
	{
		$this->id = 1;
	}


	/**
	 * Return the page title
	 *
	 * @return 	string
	 */
	public static function getTitle()
	{
		return self::$title;
	}


	/**
	 * Return the body class of the page
	 *
	 * @param  	string 	$additional_class
	 * @return 	string
	 */
	public static function bodyClass($additional_class = null)
	{
		$classes = '';

		foreach (self::$object as $post)
		{
			$classes .= $post->post_type . ' ';
			$classes .= slugMake($post->title) . ' ';

			// Add more body class when showing single post
			if (count(self::$object) == 1)
			{
				
				$classes .= $post->post_type.'-'.$post->id . ' ';
			}
		}
		return $classes . $additional_class;
	}


	/**
	 * Create object
	 *
	 * @return 	string
	 */
	public static function create($object, $type = NULL)
	{
		foreach ($object as $item)
		{
			self::$object[] = $item;
		}

		self::$type 	= (count($object) == 1) ? $object[0]->post_type : $type;
		self::$title 	= (count($object) == 1) ? $object[0]->title : 'Archive';

		self::setPostType();
	}


	private static function setPostType()
	{
		$postType = Setting::getOptionArray('post_type', TRUE);
		self::$postType = $postType[self::$object[0]->post_type];

	}


	/**
	 * Returns the page template
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public static function template($viewVariables)
	{
		self::$viewVariables = $viewVariables;

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
			$hirarchy = array('page-'.self::$object[0]->id, 'page-'.self::$object[0]->slug, 'page', 'index');
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

		return $template;
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
	private static function getPostTypeSlugs()
	{
		$postSlugs = array();
		foreach (Setting::getOptionArray('post_type', TRUE) as $key => $value)
		{
			$postSlugs[] = $value['slug'];
		}
		return $postSlugs;
	}
}