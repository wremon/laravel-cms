<?php 

class MenuController extends BackendBaseController {

	/*
	|--------------------------------------------------------------------------
	| Meta controller
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
	| Main menus
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	/**
	 * Display all menus
	 * @return object
	 */
	public function getListAll()
	{
		return View::make('dashboard.menu.all')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.menu'),
							'menu'			=> Setting::getOptionArray('menu'),
							'menuLocations'	=> Config::get('cms/menu.location'),
							'assets'		=> $this->assets,
						) 
					);
	}


	/**
	 * Save/update all menu
	 * @return object
	 */
	public function postListAll()
	{
		$menus 	= Setting::getOptionArray('menu');
		$validMenus = $menus;

		// Only on edit mode
		if (Input::get('_id'))
		{
			unset($validMenus[Input::get('_id')]);
		}


		$validator = Validator::make(
			Input::all(), 
			array(
				'name' => 'required|alpha_num_spaces|not_in:'.implode(',', arrayKeyValues($validMenus, 'name')),
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
			$menus[Input::get('_id')] = array(
				'name'			=> Input::get('name'),
				'location'		=> Input::get('location'),
			);
		}
		else
		{	
			// Add new key value pair
			// on new mode
			$menus[slugMake(Input::get('name'))] = array(
				'name'			=> Input::get('name'),
				'location'		=> Input::get('location'),
			);
		}
		

		// Update setting
		Setting::set('menu', serialize($menus));

		// Redirect
		return Redirect::to(Request::url())
						->with('message', Lang::get('dashboard.item_saved', array('item' => Lang::get('dashboard.menu'))));
	}

	/**
	 * Retrieve the menu to edit
	 * @return json 	object
	 */
	public function getEdit()
	{
		$postTypes 	= Setting::getOptionArray('menu');

		foreach ($postTypes as $key => $value)
		{
			if ($key == Input::get('key'))
			{
				return Response::json(array(
					'id'		=> $key,
					'name' 		=> $value['name'],
					'location' 	=> $value['location']
				));
			}
		}
	}


	/**
	 * Up the meta fields order
	 * @param  string 	$postType
	 * @return object
	 */
	public function postReorderMenu()
	{
		$postTypes 	= Setting::getOptionArray('menu');
		$metaFields = array();

		$reorderedMenu = array();
		foreach (Input::get('keys') as $key)
		{
			if (isset($postTypes[$key]))
			{
				$reorderedMenu[$key] = $postTypes[$key];
			}
		}
		
		// Update setting
		Setting::set('menu', serialize($reorderedMenu));
	}


	/*
	|--------------------------------------------------------------------------
	| Menu items
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	/**
	 * Display menu editor page
	 * @param  integer 	$menuId
	 * @return object
	 */
	public function getMenuItems($menuId)
	{
		$menuItems 	= Setting::getOptionArray('menu_'.$menuId);
		$menuCounter = 1;
		return View::make('dashboard.menu.items')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.menu'),
							'menuItems'		=> self::rendermenu($menuItems, $menuCounter),
							'assets'		=> $this->assets,
							'inlineJs'		=> 'var menuId="'.$menuId.'",
							menuTitle = "'.Lang::get('dashboard.new_menu').'",
							fieldText = "'.Lang::get('dashboard.text').'",
							fieldLink = "'.Lang::get('dashboard.link').'",
							fieldClass = "'.Lang::get('dashboard.class').'",
							fieldRel = "'.Lang::get('dashboard.rel').'",
							fieldTarget = "'.Lang::get('dashboard.target').'",
							fieldTargetElement = \''.Form::select('target[]', Config::get('cms_main.link_target'),  NULL, array('class' => 'form-control')).'\';',
						) 
					);
	}


	/**
	 * Save menu's items
	 * @param  array 	$menuItems
	 * @param  integer 	$menuId
	 * @return object
	 */
	private function rendermenu($menuItems, &$menuId)
	{
		$ui = '<ul data-id="'.$menuId.'" class="submenu sortable-connect list-unstyled">';
		$menuId++;
		foreach ($menuItems as $item)
		{
			$ui .= '<li class="menu">
						<div class="">
							<div class="item">
								<div class="item-header">
									<span class="handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									</span>
									&nbsp;
									<span class="item-title"><strong>'.strip_tags($item['text']).'</strong></span>
								</div>
								<div class="item-body" style="display:none;">

									<div class="form-group row">
										<div class="col-md-4">
											'.Form::label('text', Lang::get('dashboard.text')).'
										</div>
										<div class="col-md-8">
											'.Form::text('text[]', $item['text'], array('class' => 'form-control')).'
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-4">
											'.Form::label('link', Lang::get('dashboard.link')).'
										</div>
										<div class="col-md-8">
											'.Form::text('link[]', $item['link'], array('class' => 'form-control')).'
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-4">
											'.Form::label('class', Lang::get('dashboard.class')).'
										</div>
										<div class="col-md-8">
											'.Form::text('class[]', $item['class'], array('class' => 'form-control')).'
										</div>
									</div>

									<div class="row">
										<div class="form-group col-md-6">
											<div class="row">
												<div class="col-md-4">
													'.Form::label('rel', Lang::get('dashboard.rel')).'
												</div>
												<div class="col-md-8">
													'.Form::text('rel[]', $item['rel'], array('class' => 'form-control')).'
												</div>
											</div>
										</div>

										<div class="form-group col-md-6">
											<div class="row">
												<div class="col-md-4">
													'.Form::label('target', Lang::get('dashboard.target')).'
												</div>
												<div class="col-md-8">
													'.Form::select('target[]', Config::get('cms_main.link_target'),  $item['target'], array('class' => 'form-control')).'
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
			if (isset($item['submenu']))
			{
				$ui .= self::rendermenu($item['submenu'], $menuId);
			}
			else
			{
				$ui .= '<ul data-id="'.$menuId.'" class="submenu sortable-connect list-unstyled"><li class="unsortable"></li></ul>';
				$menuId++;
			}
			$ui .= 	'</li>';			
		}
		$ui .= '<li class="unsortable"></li></ul>';
		return $ui;
	}


	/**
	 * Save menu's items
	 * @param  integer 	$menuId
	 * @return object
	 */
	public function postMenuItems($menuId)
	{
		Setting::set('menu_'.$menuId, serialize(Input::get('menu-items')));
	}

}