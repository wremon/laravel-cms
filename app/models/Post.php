<?php

class Post extends Eloquent {
	
	protected $softDelete = true;

	/* ---------------------------------
	Relations
	--------------------------------- */
	public function author()
	{
		return $this->belongsTo('User', 'user_id', 'id');
	}

	public function metas()
	{
		return $this->hasMany('Meta', 'object_id');
	}


	public static function model()
	{
		$model = new Post;
		$model->title 		= NULL;
		$model->slug 		= NULL;
		$model->user_id 	= NULL;
		$model->content		= NULL;
		$model->post_type 	= NULL;
		$model->status 		= 1;
		$model->parent 		= NULL;

		return $model;
	}


	public static function add($title, $slug, $userId, $content, $type, $status, $parent)
	{
		$post = new Post;
		$post->title 		= $title;
		$post->slug 		= $slug;
		$post->user_id 		= $userId;
		$post->content		= $content;
		$post->post_type 	= $type;
		$post->status 		= $status;
		$post->parent 		= $parent;
		$post->save();

		return $post->id;
	}


	public static function modify($postId, $title, $slug, $userId, $content, $type, $status, $parent)
	{
		$post = Post::find($postId);

		if (!$post)
		{
			App::abort(404);
		}

		$post->title 		= $title;
		$post->slug 		= $slug;
		$post->user_id 		= $userId;
		$post->content 		= $content;
		$post->post_type 	= $type;
		$post->status 		= $status;
		$post->parent 		= $parent;
		$post->save();

		return $post->id;
	}


	public function getMetaFields()
	{
		$metas = Meta::getMultiple($this->id);

		foreach ($metas as $key => $value)
		{
			$this->{'meta_'.$value->meta_name} = $value->meta_value;
		}
		
		return $this;
	}


	public function getMetas()
	{
		$this->meta = $this->metas()->getMultiple($this->id);
		return $this;
	}


	/*
	 * Return the post permalink
	 */
	public function permalink()
	{
		return route('post-'.$this->id);
	}

	/*
	 * Return the post edit link
	 */
	public function editLink()
	{
		return '<a href="'.url(Setting::getOption('dashboard_path', TRUE).'/content/'.$this->post_type.'/'.$this->id).'" class="edit-link">'.Lang::get('dashboard.edit').'</a>';
	}


	/*
	 * Return the post excerpt
	 */
	public function excerpt( $length = 350 )
	{
		$excerpt = strip_tags($this->content);

		if (strlen($excerpt) <= $length)
		{
			return $excerpt;
		}

		$excerpt = substr($excerpt, 0, $length);
		if (substr($excerpt,-1,1) != ' ')
		{
			$excerpt = substr($excerpt, 0, strrpos($excerpt, " "));
		}

		return $excerpt;
	}
}
?>