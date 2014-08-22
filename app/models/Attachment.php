<?php

class Attachment extends Eloquent {

/*	public function __construct($attributes = array())
	{
		parent::__construct($attributes);
	}	

	protected $fillable = array('title', 'slug', 'user_id', 'description', 'file_name', 'mime');

*/

	/**
	 * Return attachment classes
	 *
	 * @param  string 	$prefix
	 * @return string
	 */
	public function getClasses($prefix = NULL)
	{
		$prefix = ($prefix) ? $prefix.'-' : NULL;

		return $prefix.$this->slug.' '.$prefix.$this->id;
	}


	public function thumbnail($size = NULL)
	{
		$thumbSizes = Config::get('cms_main.image_sizes');
		$size 		= (array_key_exists($size, $thumbSizes)) ? $thumbSizes[$size] : NULL;

		if ($size)
		{
			$image 		= pathinfo(Setting::getOption('upload_path').'/'.$this->file_name);
			return $image['dirname'].'/'.$image['filename'].'-'.$size[0].'x'.$size[1].'.'.$image['extension'];
		}
		else
		{
			return Setting::getOption('upload_path').'/'.$this->file_name;
		}
	}


	public static function model()
	{
		$model = new Attachment;
		$model->title 		= NULL;
		$model->slug 		= NULL;
		$model->description	= NULL;
		$model->file_name 	= NULL;

		return $model;
	}


	public static function add($title, $slug, $userId, $description, $fileName, $mime)
	{
		$attachment = new Attachment;
		$attachment->title 		= $title;
		$attachment->slug 		= $slug;
		$attachment->user_id 	= $userId;
		$attachment->description	= $description;
		$attachment->file_name 	= $fileName;
		$attachment->mime 		= $mime;
		$attachment->save();

		return $attachment->id;
	}


	public static function modify($attachmentId, $title, $slug, $userId, $description)
	{
		$attachment = Attachment::find($attachmentId);

		if (!$attachment)
		{
			App::abort(404);
		}

		$attachment->title 		= $title;
		$attachment->slug 		= $slug;
		$attachment->user_id 	= $userId;
		$attachment->description = $description;

		$attachment->save();
	}
}
?>