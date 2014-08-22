<?php

return array(

	'cache' 			=> 1,
	'image_sizes' 		=> array(
		'small' 	=> array(100, 100),
		'medium' 	=> array(300, 300),
		'large' 	=> array(600, 600),
	),
	'link_target'		=> array(
		'_self'		=> 'Self',
		'_blank'	=> 'New tab',
	),
	


	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/
	'date_format' 		=> 'F d, Y',
	'post_status'		=> array('Draft', 'Published'),
	'post_type' 		=> array(
		'post'		=> 'Post', 
		'page'		=> 'Page'
	),
	'post_action' 		=> array(
		'new', 
		'edit'
	),
	'attachment_action' => array(
		'new', 
		'edit'
	),

	/*
	|--------------------------------------------------------------------------
	| Dashboard setting
	|--------------------------------------------------------------------------
	|
	|
	*/
	'd_post_per_page' 			=> 10,


	/*
	|--------------------------------------------------------------------------
	| Site setting
	|--------------------------------------------------------------------------
	|
	|
	*/
	'app_name' 					=> 'Laravel Test',
	'app_name_divider' 			=> '|',
	'theme' 					=> 'wowowee',
	'404_title' 				=> 'Page Not Found',

	/*
	|--------------------------------------------------------------------------
	| Blog setting
	|--------------------------------------------------------------------------
	|
	| post_per_page: 	Number of post to show on a blog page
	| blog_list_title: 	Page title of the blog list page
	| blog_list_slug: 	Slug of the blog page
	| 	for single post 'blog_list_slug' will be used before the post slug
	| 	www.example.com/blog_list_slug/your_post_slug
	| home_page: 		Content for the homepage 
	|	=> {post-type}|{post-slug} 	= post-type and slug of post/ page
	|	=> blog 					= latest blog posts
	|
	*/
	't_post_per_page' 	=> 5,
	'blog_list_title' 	=> 'Blog',	
	'blog_list_slug' 	=> 'my-blog',
	'home_page' 		=> 'page|raw-expresions', // 'page|raw-expresions',


	/*
	|--------------------------------------------------------------------------
	| Gravatar setting
	|--------------------------------------------------------------------------
	|
	| gravatar_size: 	Gravatar size
	| gravatar_default: defaul Gravatar picture (404, mm, identicon, monsteroid, wavatar, retro, blank)
	| gravatar_rating: 	Rating 					(g, pg, r, x)
	|
	*/
	'gravatar_size' 	=> 100,
	'gravatar_default' 	=> 'wavatar',
	'gravatar_rating' 	=> 'pg',


	/*
	|--------------------------------------------------------------------------
	| Post's meta fields
	|--------------------------------------------------------------------------
	|
	| additional fields for posts
	|
	*/
	'field_type' 		=> array(
		'text'		=> 'Text', 
		'textarea'	=> 'Textarea', 
		'checkbox'	=> 'On-Off',
		'colorPicker' =>"Color picker",
	),

);
