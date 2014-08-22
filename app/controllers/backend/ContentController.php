<?php 

class ContentController extends BackendBaseController {

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
		array_push($this->assets['header']['css'], 'colorpicker/bootstrap-colorpicker.min');
		array_push($this->assets['footer']['js'], 'plugins/ckeditor/ckeditor');
		array_push($this->assets['footer']['js'], 'plugins/colorpicker/bootstrap-colorpicker.min');
		array_push($this->assets['footer']['js'], 'custom');
	}

	static $rules = array(
		'title' 	=> array('required', 'min:5'),
	);

	static $messages = array(
		'required' => 'The :attribute field is required.',
	);

	/*
	|--------------------------------------------------------------------------
	| Content controller
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	/**
	 * load page displaying post editor
	 * @param  $type
	 * @param  $post
	 * @return object
	 */
	public function getForm($type, $post = NULL)
	{
		if ($post){
			$pageTitle 	= Lang::get('dashboard.edit_post', array('post-type' => $type));
		}
		else
		{
			$post 		= Post::model();
			$pageTitle 	= Lang::get('dashboard.new_post', array('post-type' => $type));
		}

		return View::make('dashboard.content.form')
					->with( 
						array( 
							'title' 		=> $pageTitle,
							'post' 			=> $post,
							'postStatus' 	=> Config::get('cms_main.post_status'),
							'metaFields'	=> unserialize(Setting::getOption('meta_'.$type, TRUE)),
							'assets'		=> $this->assets
						) 
					);
	}


	/**
	 * save the post
	 * @param  $type
	 * @param  $post
	 * @return object
	 */
	public function postForm($type, $post = NULL)
	{
		// dd(Input::all());
		if (isset($post->id))
		{
			$validator = Validator::make(
				Input::all(), 
				array_merge(self::$rules , array('slug' => array('unique:posts,slug,'.$post->id)))
			);

			// Check if validation passes
			if (!$validator->passes())
			{	
				return Redirect::to(Setting::getOption('dashboard_path', TRUE).'/content/'.$post->post_type.'/'.$post->id)
								->withInput()
								->withErrors($validator)
								->with('error', Lang::get('dashboard.invalid_field_values'));
			}

			$postId = self::saveOld($post->id, $post->post_type);
			$type 	= $type;
		}
		else
		{
			$validator = Validator::make(
				Input::all(), 
				array_merge(self::$rules , array('slug' => array('unique:posts,slug')))
			);

			// Check if validation passes
			if (!$validator->passes())
			{
				return Redirect::to(Setting::getOption('dashboard_path', TRUE).'/content/'.$type.'/')
								->withInput()
								->withErrors($validator)
								->with('error', Lang::get('dashboard.invalid_field_values'));
			}

			$postId = self::saveNew($type);
		}


		// Save custom meta fields xxxxxxxx
		foreach (unserialize(Setting::getOption('meta_'.$type, TRUE)) as $key => $value)
		{
			Meta::set($postId, $key, Input::get('meta_'.$key), 1);
		}
		// foreach (arrayKeyWildcard(Input::all(), 'meta_*') as $meta_name => $meta_value)
		// {
		// 	Meta::set($postId, preg_replace('/meta_/', '', $meta_name, 1), $meta_value, 1);
		// }

		return Redirect::to(url(Setting::getOption('dashboard_path', TRUE).'/content/'.$type.'/'.$postId))
				->with('message', Lang::get('dashboard.item_saved', array('item' => ucfirst($type))));
	}


	/**
	 * load page displaying paginated posts
	 * @param  $postType
	 * @return object
	 */
	public function getListAll($postType = null)
	{
		contentIsValidPostType($postType);
		return View::make('dashboard.content.all')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.all_item', array('item' => array_get(Setting::getOptionArray('post_type', TRUE), $postType.'.name'))),
							'postType' 		=> $postType,
							'posts' 		=> Post::where('post_type', '=', $postType)->get(),
							'assets'		=> $this->assets,
						) 
					);
	}


	/**
	 * load page displaying paginated trashed posts
	 * @param  $postType
	 * @return object
	 */
	public function getListAllTrash($postType = null)
	{
		contentIsValidPostType($postType);
		return View::make('dashboard.content.all-trashed')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.all_trashed_item', array('item' => array_get(Setting::getOptionArray('post_type', TRUE), $postType.'.name'))),
							'postType' 		=> $postType,
							'posts' 		=> Post::onlyTrashed()->where('post_type', '=', $postType)->get(),
							'assets'		=> $this->assets,
						) 
					);
	}


	/**
	 * Move post to trash
	 * @return NULL
	 */
	public function postTrashPost()
	{
		$post = Post::find(Input::get('post-id'))->delete();
	}


	/**
	 * Restore post from trash
	 * @return NULL
	 */
	public function postRestorePost()
	{
		Post::onlyTrashed()->where('id', Input::get('post-id'))->restore();
	}


	/**
	 * Permanently delete post
	 * @return NULL
	 */
	public function postDeletePost()
	{
		Post::onlyTrashed()->where('id', Input::get('post-id'))->forceDelete();
	}


	/**
	 * save the new post
	 * @param  $postType
	 * @return integer|post id
	 */
	private function saveNew($postType)
	{
		return Post::add(
			Input::get('title'),
			slugMake(ifNull(Input::get('slug'), Input::get('title'))),
			Auth::user()->id,
			Input::get('content'),
			$postType,
			Input::get('status'),
			0
		);
	}


	/**
	 * save the edited post
	 * @param  $postId
	 * @param  $postType
	 * @return integer|post id
	 */
	private function saveOld($postId, $postType)
	{
		return Post::modify(
			$postId,
			Input::get('title'),
			slugMake(Input::get('slug'), Input::get('title')),
			Auth::user()->id,
			Input::get('content'),
			$postType,
			Input::get('status'),
			0
		);
	}
}