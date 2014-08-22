<?php
//Route::model('post', 'Post');
Route::pattern('id', '[0-9]+');
Route::pattern('postId', '[0-9]+');
Route::pattern('postId', '[0-9]+');


/*
|--------------------------------------------------------------------------
| Binds
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::bind('postId', function($postId)
{
	$post = Post::find($postId);

	// Check if $post is an object
	if ($post)
	{
		// Check if the post type correct
		if ($post->post_type != Request::segment(3))
		{
			App::abort(404);
		}

		// Get the post metas and return it
		return $post->getMetaFields();
	}
});


Route::bind('postPostSlug', function($postPostSlug)
{
	$post = Post::where('slug', '=', $postPostSlug)->get();

	// Check if $post is an object
	if ($post)
	{
		// Get the post metas and return it
		return $post;
	}

	App::abort(404);
});


Route::bind('postPageSlug', function($postPageSlug)
{
	$post = Post::where('slug', '=', $postPageSlug)->get();

	// Check if $post is an object
	if ($post)
	{
		// Get the post metas and return it
		return $post;
	}

	App::abort(404);
});



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', function()
{
	// foreach (Setting::getOptionArray('post_type', TRUE) as $key => $value)
	// {
	// 	// Route::get('/'.$value['slug'].'/{postPostSlug}', 				'PageController@getPost');
	// 	$posts = Post::where('post_type', '=', $key)->get();
	// 	foreach ($posts as $post){
	// 		echo '/'.$value['slug'].'/'.$post->slug;
	// 	}
	// 	// echo '/'.$value['slug'].'/{postPostSlug}';
	// }
	// $a = array(
	// 	'audio' => array(
	// 		'name' => 'Audio',
	// 		'slug' => 'album',
	// 		'style' => 'post',
	// 	),
	// 	'page' => array(
	// 		'name' => 'Page',
	// 		'slug' => 'page',
	// 		'style' => 'page',
	// 	),
	// 	'post' => array(
	// 		'name' => 'Post',
	// 		'slug' => 'post',
	// 		'style' => 'post',
	// 	),
	// 	'wamples' => array(
	// 		'name' => 'Wamples',
	// 		'slug' => 'Wamples',
	// 		'style' => 'post',
	// 	)
	// );
	// Setting::set('post_type', serialize($a));

	$postTypes 	= Setting::getOptionArray('post_type');
	print_r($postTypes);	
});


Route::get('/sample', function()
{
	/*$array = array(
		'meta_description' 		=> array' 			=> 'Meta description',
			'type'			=> 'text',
			'description' 	=> 'Your meta description goes here',
			'auto' 			=> 1,
		),
		'meta_keywords' 		=> array' 			=> 'Meta keywords',
			'type'			=> 'text',
			'description' 	=> 'Your meta keywords and other words goes here',
			'auto' 			=> 1,
		),
		'new_meta' 				=> array' 			=> 'Meta new',
			'type'			=> 'text',
			'description' 	=> 'Your new meta goes here... put anything here',
			'auto' 			=> 1,
		),
	);
	echo Setting::set('meta_page', serialize($array));*/

	
	//die;
	echo public_path('attachment/');
	echo "-". Setting::getOption('upload_path');


	/*
	attachments TABLE
	Schema::create('attachments', function($table)
	{
		$table->bigIncrements('id');
		$table->string('title');
		$table->string('slug');
		$table->integer('user_id');
		$table->text('description')->nullable();
		$table->string('path');
		$table->string('mime');
		$table->timestamps();
	});*/



	
	/*//OPTIONS TABLE
	Schema::dropIfExists('Settings');
	Schema::create('Settings', function($table)
	{
		$table->bigIncrements('id');
		$table->string('option_name');
		$table->text('option_value')->nullable();
		$table->timestamps();
	});*/


	//POSTS TABLE
	Schema::dropIfExists('posts');
	Schema::create('posts', function($table)
	{
		$table->bigIncrements('id');
		$table->string('title');
		$table->string('slug');
		$table->bigInteger('user_id');
		$table->text('content')->nullable();
		$table->string('post_type');
		$table->tinyInteger('status');
		$table->bigInteger('parent');
		$table->timestamps();
		$table->softDeletes();
	});
});



/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| 
|
*/

// Login
Route::any(Setting::getOption('dashboard_path', TRUE).'/login', 	'LoginController@index');
Route::post(Setting::getOption('dashboard_path', TRUE).'/login', 	'AuthController@user');


Route::group(array('prefix' => Setting::getOption('dashboard_path', TRUE), 'before' => 'auth'), function() 
{
	// Dashboard
	Route::get('/', 'DashboardController@index');

	// Sign out
	Route::get('/sign-out', array('as' => 'sign_out', 'uses' => 'DashboardController@signOut'));

	// Content	
	Route::group(array('prefix' => 'content'), function() 
	{	
		Route::post('/trash',									'ContentController@postTrashPost');
		Route::post('/restore',									'ContentController@postRestorePost');
		Route::post('/delete',									'ContentController@postDeletePost');

		// Add route of post types
		foreach (Setting::getOptionArray('post_type') as $key => $value)
		{
			Route::get('/{'.$key.'}/list-all', 					array('as' => 'all_'.$key.'_posts', 'uses' => 'ContentController@getListAll'));
			Route::get('/{'.$key.'}/list-all/trash',			'ContentController@getListAllTrash');
			Route::get('/{'.$key.'}/{postId?}', 				array('as' => 'new_'.$key.'_posts', 'uses' => 'ContentController@getForm'));
			Route::post('/{'.$key.'}/{postId?}', 				'ContentController@postForm');
		}
	});


	// Settings	
	Route::group(array('prefix' => 'settings'), function() 
	{	
		
		// Post type	
		Route::group(array('prefix' => 'post-types'), function() 
		{	
			// Post types
			Route::get('/', 									array('as' => 'post_types', 'uses' => 'SettingController@getPostTypes'));
			Route::post('/', 									'SettingController@postPostTypes');
			Route::post('/delete', 								array('as' => 'post_type_delete', 'uses' => 'SettingController@postRemovePostType'));
			Route::post('/reorder', 							'SettingController@postReorderPostTypes');
			Route::post('/edit', 								'SettingController@getEditPostType');
			

			// Meta
			Route::get('/{postType}/meta-fields', 				array('as' => 'post_type_meta', 'uses' => 'SettingController@getMetaFieldForm'));
			Route::post('/{postType}/meta-fields', 				'SettingController@postMetaFieldForm');
			Route::post('/{postType}/meta-fields/delete', 		'SettingController@postRemoveMetaField');
			Route::post('/{postType}/meta-fields/reorder', 		'SettingController@postReorderMetaField');
			Route::post('/{postType}/meta-fields/edit', 		'SettingController@getEditMetaField');
		});

		
		// Wildcards
		Route::get('/{function}', 								'SettingController@getItems');
		Route::post('/{function}', 								'SettingController@postItems');
	});


	// Attachments	
	Route::group(array('prefix' => 'attachment'), function() 
	{	
		// List all
		Route::get('/list-all/{page?}', 						array('as' => 'attachment_all', 'uses' => 'AttachmentController@getListAll'));

		// New
		Route::get('/', 										array('as' => 'attachment_new', 'uses' => 'AttachmentController@getAddNew'));
		Route::post('/', 										'AttachmentController@postAddNew');
		// Edit
		Route::get('/{id}', 									array('as' => 'attachment_edit', 'uses' => 'AttachmentController@modify'));
		Route::post('/{id?}', 									'AttachmentController@save');
	});


	// Menu	
	Route::group(array('prefix' => 'menu'), function() 
	{	
		// List all
		Route::get('/', 										array('as' => 'menu_all', 'uses' => 'MenuController@getListAll'));
		Route::post('/', 										'MenuController@postListAll');
		Route::post('/edit', 									'MenuController@getEdit');
		Route::post('/reorder', 								'MenuController@postReorderMenu');

		Route::get('/{menuId}/items', 							'MenuController@getMenuItems');
		Route::post('/{menuId}/items', 							'MenuController@postMenuItems');
	});

});






// Route::get('/', 							'PageController@index');

// Route::get('/{postPageSlug}', 				'PageController@getPost');


foreach (Setting::getOptionArray('post_type', TRUE) as $key => $value)
{
	$posts = Post::where('post_type', '=', $key)->get();
	foreach ($posts as $post)
	{
		/**
		 * Only "page" post type cannot have a base slug
		 * The "post" post type such as 'post' and other custom post type
		 *  must have base slug
		 */
		if ($value['style'] != 'page') 
		{
			$baseSlug = '/'.$value['slug'].'/';
		}
		else
		{
			$baseSlug = '';
		}

		Route::get($baseSlug.$post->slug, 			array('as' => 'post-'.$post->id, 'uses' => function() use ($post)
		{
			template($post);
		}));
	}

	/**
	 * Only "page" post type cannot have a list of posts
	 * 
	 */
	if ($value['style'] != 'page') 
	{
		Route::get('/'.$value['slug'].'/', 							array('as' => 'post-type'.$value['slug'], 'uses' => function() use ($value, $posts)
		{
			template($posts, $value['slug'], $value['style']);
		}));
	}
}




// 404
App::missing(function($exception)
{
	return Response::view( 
		'error.404', 
		array('title' => Lang::get('dashboard.404_page')), 
		404
	);
});


