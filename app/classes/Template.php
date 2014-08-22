<?php 

class Template
{

	/**
	 * Content(s) to be displayed
	 *
	 */
	private $posts;


	/**
	 * Content's post type
	 *
	 */
	public $postType;


	/**
	 * Type
	 * Type of template
	 *
	 */
	public $type;

	/**
	 * Allowed static template types
	 *
	 */
	private $allowedTemplateType = array('attachment', 'index', '404');


	/**
	 * Page title
	 *
	 */
	private $title;


	/**
	 * Template to use
	 *
	 */
	private $template;
	

	/**
	 * Array of variables to be passed to view
	 *
	 */
	public $viewVariables;


	public $templateFile;




	function __construct($post)
	{
		$this->posts = $post;
		
		return $this;
	}





	/**
	 * Get the type of template
	 *
	 * @return 	object
	 */
	private function getTemplateType()
	{
		$postType 	= Setting::getOptionArray('post_type', TRUE);
		$post 		= $this->posts->first();

		if (count($this->posts) == 1)
		{
			$this->type = $post->post_type;
			$this->postType = $postType[$post->post_type];
		}
		else
		{
			$this->postType = $postType[$post->post_type];
			$this->type = 'archive';
		}
		return $this;
	}


	/**
	 * Set the template type
	 *
	 * @return 	object
	 */
	public function getTitle()
	{
		if (count($this->posts) == 1)
		{
			$post 		= $this->posts->first();
			return $post->title;
		}
	}


	/**
	 * Set variables to send to view
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public function bodyClass( $userDefined = NULL )
	{
		self::getTemplateType();

		$classes = '';
		
		foreach ($this->posts as $post)
		{
			$classes .= $post->post_type . ' ';
			$classes .= slugMake($post->title) . ' ';
			$classes .= $post->post_type.'-'.$post->id . ' ';
		}
		return trim( $classes.' '.$userDefined );
	}


	/**
	 * Set variables to send to view
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public function variables($variables)
	{
		$this->viewVariables = $variables;
		return $this;
	}


	/**
	 * Sets the page template
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public function template($customTemplate = NULL)
	{	

		if (!is_null($customTemplate))
		{
			$this->template = $this->getTemplate($customTemplate);
			return $this;
		}

		View::addLocation(base_path() . '/themes/' . Setting::getOption('template', TRUE));
		View::addNamespace('theme', base_path() . '/themes/' . Setting::getOption('template', TRUE));

		$template = NULL;


		if ($this->type == 'page')
		{
			/* Hirarchy: 
			-> page-{id}.blade.php
			-> page-{slug}.blade.php
			-> page.blade.php 
			-> index.blade.php
			*/
			$post 		= $this->posts->first();
			$hirarchy 	= array('page-'.$post->id, 'page-'.$post->slug, 'page', 'index');
		}
		elseif (in_array($this->type, array('archive')))
		{
			/* Hirarchy: 
			-> archive.blade.php
			-> blog.blade.php 
			-> index.blade.php
			*/
			$hirarchy = array('archive', 'index');
		}
		elseif (in_array($this->type, self::getPostTypeSlugs()))
		{
			/* Hirarchy: 
			-> single-{post-type}.blade.php
			-> single.blade.php 
			-> index.blade.php
			*/
			$hirarchy = array('single-'.$this->type, 'single', 'index');
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
				$template 	= $this->getTemplate($file);
				echo ' -no' . $file;
			}
		}

		$this->template = $template;
		$this->templateFile = $file;
		return $this;
	}


	/**
	 * Returns the page template
	 *
	 * @param  	array 	$viewVariables
	 * @return 	object
	 */
	public function show()
	{
		return $this->template;
	}


	/**
	 * Determines the current objects template file to use
	 *
	 * @param  	string 	$file
	 * @return 	object
	 */
	private function getTemplate($file)
	{
		try
		{
			View::getFinder()->find('theme::'.$file);

			return View::make('theme::'.$file)->with($this->viewVariables);
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
		$postSlugs = array('post');
		foreach (Setting::getOptionArray('post_type', TRUE) as $key => $value)
		{
			$postSlugs[] = $value['slug'];
		}
		var_dump($postSlugs);
		return $postSlugs;
	}
}