<?php 

function template($post, $postSlug = null, $postType = null, $customTemplate = NULL)
{	
	$template = '';
	if (!is_null($customTemplate))
	{
		$template = getTemplate($customTemplate);
		return $template;
	}

	View::addLocation(base_path() . '/themes/' . Setting::getOption('template', TRUE));
	View::addNamespace('theme', base_path() . '/themes/' . Setting::getOption('template', TRUE));

	$template = NULL;


	/*
	 * Only the 'archive' can have archive list (multiple posts)
	 */
	if (count($post) > 1)
	{
		/* Hirarchy: 
		-> archive-{slug}.blade.php
		-> archive-{postType}.blade.php
		-> archive.blade.php 
		-> index.blade.php
		*/
		$hirarchy = array('archive-'.$postSlug, 'archive-'.$postType, 'archive', 'index');
		$params = array('posts' => $post);
	} 
	else
	{
		if ($post->post_type == 'page')
		{
			/* Hirarchy: 
			-> page-{id}.blade.php
			-> page-{slug}.blade.php
			-> page.blade.php 
			-> index.blade.php
			*/
			$hirarchy 	= array('page-'.$post->id, 'page-'.$post->slug, 'page', 'index');
			$params = array('post' => $post, 'meta' => Meta::getMultiple($post->id, TRUE));
		}
		elseif ($post->post_type == 'post')
		{
			/* Hirarchy: 
			-> single-{id}.blade.php
			-> single-{slug}.blade.php
			-> single.blade.php 
			-> index.blade.php
			*/
			$hirarchy 	= array('single-'.$post->id, 'single-'.$post->slug, 'single', 'index');
			$params = array('post' => $post, 'meta' => Meta::getMultiple($post->id, TRUE));
		}
		elseif (in_array($post->post_type, getPostTypeSlugs()))
		{
			/* Hirarchy: 
			-> single-{post-type}.blade.php
			-> single.blade.php 
			-> index.blade.php
			*/
			$hirarchy = array('single-'.$post->post_type, 'single', 'index');
			$params = array('post' => $post);
		}
		else
		{
			/* Hirarchy: 
			-> index.blade.php
			*/
			$hirarchy = array('index');
		}
	}


	// Get the view
	foreach ($hirarchy as $file)
	{
		if (!$template)
		{
			$template 	= getTemplate($file, $params);
		} else {
			break;
		}
	}

	echo $template;
}

function getTemplate($file, $params)
{
	try
	{
		View::getFinder()->find('theme::'.$file);

		// echo 'OK ' . $file;
		$params['template_file'] = $file;
		return View::make('theme::'.$file)->with($params);
	}
	catch (InvalidArgumentException $error)
	{
		return false;
	}
} 

function getPostTypeSlugs()
{
	$postSlugs = array('post');
	foreach (Setting::getOptionArray('post_type', TRUE) as $key => $value)
	{
		$postSlugs[] = $value['slug'];
	}
	return $postSlugs;
}



































/*
|--------------------------------------------------------------------------
| Content
|--------------------------------------------------------------------------
|
| 
|
*/
function alertShow($type, $message)
{
	if (empty($message))
	{
		return;
	}

	return '<div class="alert alert-'.$type.' alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				'.$message.'
			</div>';
}

function alertGroup($type, $errors, $fields = array())
{
	if (count($errors) == 0)
	{ 
		return;
	}

	$list = '<ul>';
	foreach ($fields as $field)
	{
		if ($errors->first($field))
		{
			$list .= '<li>'.$errors->first($field).'</li>';
		}
	}
	$list .= '</ul>';

	return '<div class="alert alert-'.$type.' alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				'.$list.'
			</div>';
}


function alertNote($errors, $field)
{
	return '<small>'.$errors->first($field).'</small>';
}


/*
|--------------------------------------------------------------------------
| Array
|--------------------------------------------------------------------------
|
| 
|
*/

/**
 * Get array elements using wildcard key
 *
 * @param  $array
 * @param  $needle
 * @param  $returnPair
 * @return array
 */
function arrayKeyWildcard($array, $needle, $returnPair = false)
{
	$needle = str_replace('\*', '.*?', preg_quote($needle, '/'));
	$result = preg_grep('/^'.$needle.'$/i', array_keys($array));
	if ($returnPair)
	{
		return array_intersect_key($array, array_flip($result));
	}
	return $result;
}


/**
 * Get all values of given key
 *
 * @param  $array
 * @param  $needle
 * @return array
 */
function arrayKeyValues($array, $needle)
{
	$result = array();

	foreach ($array as $key => $value)
	{
		if (is_array($value))
		{
			$result[] = arrayKeyValues($value, $needle);
		}
		else
		{
			if ($key == $needle)
			{
				$result[] = $value;
			}
		}
	}

	return array_flatten($result);
}


/*
|--------------------------------------------------------------------------
| Calendar
|--------------------------------------------------------------------------
|
| 
|
*/

function calendarYears(){
	$years = array(null);

	for ($yr = intval(date('Y')); $yr >= (intval(date('Y')) - 25); $yr--){
		$years[$yr] = $yr;
	}

	return $years;
}


function calendarMonths(){
	$months = array(
		NULL,
		Lang::get('dashboard.january'),
		Lang::get('dashboard.february'),
		Lang::get('dashboard.march'),
		Lang::get('dashboard.april'),
		Lang::get('dashboard.may'),
		Lang::get('dashboard.june'),
		Lang::get('dashboard.july'),
		Lang::get('dashboard.august'),
		Lang::get('dashboard.september'),
		Lang::get('dashboard.october'),
		Lang::get('dashboard.november'),
		Lang::get('dashboard.december'),
	);
	unset($months[0]);
	return $months;
}


/*
|--------------------------------------------------------------------------
| Content
|--------------------------------------------------------------------------
|
| 
|
*/

function contentIsValidPostAction($postAction){
	if (!$postAction || !in_array($postAction, Config::get('cms_main.post_action')))
	{
		App::abort(404);
	}
}

function contentIsValidPostType($postType){
	if (!$postType || !array_key_exists($postType, Setting::getOptionArray('post_type')))
	{
		App::abort(404);
	}
}



/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
|
| 
|
*/

function dashboardLoggedUser($show = 'full-name')
{
	if (Auth::check())
	{
		switch($show)
		{
			case 'first-name':
				return Auth::user()->first_name;
				break;

			case 'last-name':
				return Auth::user()->last_name;
				break;

			case 'full-name':
				return Auth::user()->first_name . ' ' . Auth::user()->last_name;
				break;

			case 'email':
				return Auth::user()->email_address;
				break;

			case 'username':
				return Auth::user()->username;
				break;
		}
		
	}
}


/*
|--------------------------------------------------------------------------
| Day
|--------------------------------------------------------------------------
|
| 
|
*/

function dayHours(){
	$hours = array();

	for ($hrs = 1; $hrs <= 24; $hrs++){
		$hours[$hrs] = $hrs;
	}

	return $hours;
}

function dayMinutes(){
	$minutes = array();

	for ($mnts = 1; $mnts <= 60; $mnts++){
		$minutes[$mnts] = $mnts;
	}

	return $minutes;
}


/*
|--------------------------------------------------------------------------
| Menu
|--------------------------------------------------------------------------
|
| 
|
*/
function menuMake($id = null, $class = null, $menu = array())
{
	$ui = '<ul id="' . $id . '" class="' . $class . '">';
	foreach ($menu as $text => $content)
	{
		$attributes = menuExtractAttributes($content);
		$listClass 		= '';
		if (Request::url() == url($attributes['url']))
		{
			$listClass 	= 'class="active"';
		}
		$ui .= '<li ' . $listClass . '><a href="' . url($attributes['url']) . '" class="' . $attributes['class'] . '">' . $attributes['text'] . '</a></li>' . "\r\n";
	}
	$ui .= '</ul>';
	return $ui;
}


function menuExtractAttributes($result)
{
	$links 			= array();
	$attributes 	= explode('|', $result);
	foreach ($attributes as $attribute)
	{
		$keyValue 	= explode(':', $attribute);
		$values 	= explode(',', $keyValue[1]);

		if (count($values) > 1)
		{
			$links[$keyValue[0]] = '';
			foreach ($values as $value)
			{
				$links[$keyValue[0]] .= $value . ' ';
			}
		}
		else
		{
			$links[$keyValue[0]] 	= $keyValue[1];
		}
		
	}
	return $links;
}


/*
|--------------------------------------------------------------------------
| Slug
|--------------------------------------------------------------------------
|
| 
|
*/
function slugMake($text)
{ 
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	$text = trim($text, '-');
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	$text = strtolower($text);
	$text = preg_replace('~[^-\w]+~', '', $text);

	if (empty($text))
	{
		return 'n-a';
	}

	return $text;
}


/*
|--------------------------------------------------------------------------
| Utility
|--------------------------------------------------------------------------
|
| 
|
*/
function ifSet($var)
{
	if (isset($var))
	{
		return $var;
	}
	return NULL;
}


function ifNull($var, $failSafe)
{
	if (!empty($var))
	{
		return $var;
	}
	return $failSafe;
}
?>