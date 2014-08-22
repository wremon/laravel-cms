<?php 

class SettingController extends BackendBaseController {

	/*
	|--------------------------------------------------------------------------
	| Settings controller
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


	/*
	|--------------------------------------------------------------------------
	| Post types
	|--------------------------------------------------------------------------
	|
	|
	*/

	/**
	 * Displays all post types
	 * @return object
	 */
	public function getPostTypes()
	{
		$postTypes 	= Setting::getOptionArray('post_type');

		// Load view
		return View::make('dashboard.settings.post-types.all')
					->with( 
						array( 
							'title' 		=> Lang::choice('dashboard.post_type', 2),
							'postTypes'		=> $postTypes,
							'assets'		=> $this->assets,
						) 
					);
	}


	/**
	 * Save post type
	 * @return object
	 */
	public function postPostTypes()
	{
		$postTypes 	= Setting::getOptionArray('post_type');
		$validTypes = $postTypes;

		// Only on edit mode
		if (Input::get('_id'))
		{
			unset($validTypes[Input::get('_id')]);
		}


		$validator = Validator::make(
			Input::all(), 
			array(
				'name' => 'required|alpha_spaces|not_in:'.implode(',', arrayKeyValues($validTypes, 'name')),
				'slug' => 'required|alpha_spaces|not_in:'.implode(',', arrayKeyValues($validTypes, 'slug')),
			)
		);


		if (!$validator->passes())
		{
			return Redirect::to(Request::url())
							->withInput()
							->withErrors($validator);
		}


		if (Input::get('_id'))
		{
			// Overwrite the existing key value pair
			// on edit mode
			$postTypes[Input::get('_id')] = array(
				'name'			=> Input::get('name'),
				'slug'			=> Input::get('slug'),
				'style'			=> $postTypes[Input::get('_id')]['style'],
			);
		}
		else
		{	
			// Add new key value pair
			// on new mode
			$postTypes[slugMake('_id')] = array(
				'name'			=> Input::get('name'),
				'slug'			=> Input::get('slug'),
				'style'			=> 'post',
			);
		}
		

		// Update setting
		Setting::set('post_type', serialize($postTypes));

		// Redirect
		return Redirect::to(Request::url())
						->with('message', Lang::get('dashboard.item_saved', array('item' => Lang::choice('dashboard.post_type', 1))));
	}


	/**
	 * Delete a post type
	 * @return object
	 */
	public function postRemovePostType()
	{
		$postTypes 		= Setting::getOptionArray('post_type');

		if (!isset($postTypes[Input::get('post-type')]['name']))
		{
			return;
		}
		
		// $postTypeName 	= $postTypes[Input::get('post-type')]['name'];

		// Unset the postype from array
		unset($postTypes[Input::get('post-type')]);
		
		// Update setting
		Setting::set('post_type', serialize($postTypes));
		return;
	}


	public function getEditPostType()
	{
		$postTypes 	= Setting::getOptionArray('post_type');

		foreach ($postTypes as $key => $value)
		{
			if ($key == Input::get('key'))
			{
				return Response::json(array(
					'id'	=> $key,
					'name' 	=> $value['name'],
					'slug' 	=> $value['slug']
				));
			}
		}
	}


	/**
	 * Up the meta fields order
	 * @param  string 	$postType
	 * @return object
	 */
	public function postReorderPostTypes()
	{
		$postTypes 	= Setting::getOptionArray('post_type');
		$metaFields = array();

		$reorderedPostTypes = array();
		foreach (Input::get('keys') as $key)
		{
			if (isset($postTypes[$key]))
			{
				$reorderedPostTypes[$key] = $postTypes[$key];
			}
		}
		
		// Update setting
		Setting::set('post_type', serialize($reorderedPostTypes));
	}



	/*
	|--------------------------------------------------------------------------
	| Meta fields
	|--------------------------------------------------------------------------
	|
	|
	*/

	/**
	 * Displays the current post type meta fields
	 * @param  string 	$postType
	 * @return object
	 */
	public function getMetaFieldForm($postType)
	{
		$meta 		= Setting::where('option_name', '=', 'meta_'.$postType)->first();
		$metaFields = $meta ? unserialize($meta->option_value) : array();


		// Load view
		return View::make('dashboard.settings.post-types.meta.all')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.meta_fields', array('post-type' => array_get(Setting::getOptionArray('post_type', TRUE), $postType.'.name'))),
							'metas'			=> $metaFields,
							'assets'		=> $this->assets,
							'inlineJs'		=> 'var postType="'.$postType.'";',
						) 
					);
	}


	/**
	 * Saves current post type's meta fields
	 * @param  string 	$postType
	 * @return object
	 */
	public function postMetaFieldForm($postType)
	{
		$meta 			= Setting::where('option_name', '=', 'meta_'.$postType)->first();
		$metaFields 	= array();
		$validFields 	= array();

		// If post's meta fields is set, try to unserialize it
		if ($meta)
		{
			$metaFields 	= unserialize($meta->option_value);
			$validFields 	= $metaFields;
		}

		// Only on edit mode
		if (Input::get('_id'))
		{
			unset($validFields[Input::get('_id')]);
		}

		// Validate
		$validator = Validator::make(
			Input::all(), 
			array(
				'text' => 'required|alpha_num_spaces|not_in:'.implode(',', arrayKeyValues($validFields, 'text')),
			)
		);		

		// Update the post's meta fields
		if (!$validator->passes())
		{
			return Redirect::to(Request::url())
							->withInput()
							->withErrors($validator);
		}

		if (Input::get('_id'))
		{
			// Overwrite the existing key value pair
			// on edit mode
			$metaFields[Input::get('_id')] = array(
				'text'			=> Input::get('text'),
				'type'			=> Input::get('type'),
				'description'	=> Input::get('description'),
			);
		}
		else
		{	
			// Add new key value pair
			// on new mode
			$metaFields[slugMake(Input::get('text'))] = array(
				'text'			=> Input::get('text'),
				'type'			=> Input::get('type'),
				'description'	=> Input::get('description'),
			);
		}

		// Update setting
		Setting::set('meta_'.$postType, serialize($metaFields));

		//Session::put('message', Lang::get('dashboard.item_saved', array('item' => Lang::choice('dashboard.post_type', 1))));
		return Redirect::to(Request::url())
						->with('message', Lang::get('dashboard.item_saved', array('item' => Lang::choice('dashboard.post_type', 1))));
	}


	/**
	 * Delete current post type's meta field
	 * @param  string 	$postType
	 * @return object
	 */
	public function postRemoveMetaField($postType)
	{
		$meta 		= Setting::where('option_name', '=', 'meta_'.$postType)->first();
		$metaFields = $meta ? unserialize($meta->option_value) : array();
		/*$metaFields = array();

		// If post's meta fields is set, try to unserialize it
		if ($meta)
		{
			$metaFields = unserialize($meta->option_value);
		}*/

		if (!isset($metaFields[Input::get('meta-field')])){
			return;
		}

		// Unset the meta field from array
		unset($metaFields[Input::get('meta-field')]);

		// Update setting
		Setting::set('meta_'.$postType, serialize($metaFields));

		return;
	}


	/**
	 * Get the meta field's details
	 * @return object 	json
	 */
	public function getEditMetaField()
	{
		
		$meta 		= Setting::where('option_name', '=', 'meta_'.Input::get('post-type'))->first();
		$metaFields = $meta ? unserialize($meta->option_value) : array();

		if (!isset($metaFields[Input::get('key')])){
			return;
		}

		foreach ($metaFields as $key => $value)
		{
			if ($key == Input::get('key'))
			{
				return Response::json(array(
					'id'			=> $key,
					'text' 			=> $value['text'],
					'type' 			=> $value['type'],
					'description' 	=> $value['description']
				));
			}
		}
		return Response::json(array('error'));
	}


	/**
	 * Up the meta fields order
	 * @param  string 	$postType
	 * @return object
	 */
	public function postReorderMetaField($postType)
	{
		$meta 		= Setting::where('option_name', '=', 'meta_'.$postType)->first();
		$metaFields = $meta ? unserialize($meta->option_value) : array();

		$reorderedMetaFields = array();
		foreach (Input::get('keys') as $key)
		{
			if (isset($metaFields[$key]))
			{
				$reorderedMetaFields[$key] = $metaFields[$key];
			}
		}
		
		// Update setting
		Setting::set('meta_'.$postType, serialize($reorderedMetaFields));
	}


	/**
	 * Load items of setting
	 * @param  string 	$function
	 * @return object
	 */
	public function getItems($settingType)
	{		
		try
		{
			$settings = call_user_func('self::get'.ucfirst($settingType).'Fields');

			return View::make('dashboard.settings.security.all')
						->with( 
							array( 
								'title' 		=> Lang::get('dashboard.'.$settingType),
								'fields'		=> $settings,
								'settingsValue'	=> Setting::getSet($settings),
								'assets'		=> $this->assets,
							) 
						);
			//return call_user_func('self::get'.ucfirst($function));
		}
		catch (Exception $e)
		{
			App::abort(404);
		}
	}


	/**
	 * Save items of setting
	 * @param  string 	$function
	 * @return object
	 */
	public function postItems($settingType)
	{		
		try
		{
			foreach (call_user_func('self::get'.ucfirst($settingType).'Fields') as $key => $value)
			{
				Setting::set($key, Input::get($key));
			}

			return Redirect::to(Request::url())
							->with('message', Lang::get('dashboard.item_saved', array('item' => Lang::get('dashboard.'.$settingType))));
			// return call_user_func('self::post'.ucfirst($function));
		}
		catch (Exception $e)
		{
			App::abort(404);
		}
	}


	/*
	|--------------------------------------------------------------------------
	| Settings fields
	|--------------------------------------------------------------------------
	|
	| Public method depends on 'getItems' and 'postItems' method
	|
	*/

	/**
	 * Get security settings fields
	 * @return array
	 */
	private function getSecurityFields()
	{
		// System defaults
		$items = array(
			'dashboard_path' 		=> array(
				'text' 			=> Lang::get('dashboard.dashboard_path'),
				'type'			=> 'text',
				'description' 	=> Lang::get('dashboard.dashboard_path_desc')
			),
			'upload_path' 			=> array(
				'text' 			=> Lang::get('dashboard.upload_path'),
				'type'			=> 'text',
				'description' 	=> Lang::get('dashboard.upload_path_desc')
			),
		);

		// Merge the default setting with the user created one
		$items = array_merge($items, Config::get('cms/settings.security'));

		return $items;
	}


	/**
	 * Get security settings fields
	 * @return array
	 */
	private function getGeneralFields()
	{
		// System defaults
		$items = array(
			'date_format' 		=> array(
				'text' 			=> Lang::get('dashboard.date_format'),
				'type'			=> 'text',
				'description' 	=> Lang::get('dashboard.date_format_desc')
			),
		);

		// Merge the default setting with the user created one
		$items = array_merge($items, Config::get('cms/settings.general'));

		return $items;
	}


	/**
	 * Get security settings fields
	 * @return array
	 */
	private function getTemplateFields()
	{
		// System defaults
		$items = array(
			'template' 			=> array(
				'text' 			=> Lang::get('dashboard.template'),
				'type'			=> 'text',
				'description' 	=> Lang::get('dashboard.template_desc')
			),
		);

		// Merge the default setting with the user created one
		$items = array_merge($items, Config::get('cms/settings.template'));

		return $items;
	}

}