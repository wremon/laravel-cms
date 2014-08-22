<?php 

class AttachmentController extends BackendBaseController {
	static $rules = array(
		'attachment-title' 	=> array('required', 'min:5'),
	);


	/*
	|--------------------------------------------------------------------------
	| attachment controller
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

	/**
	 * load attachment page displaying paginated attachments
	 * @return object|view
	 */
	public function getListAll($page = 0)
	{
		return View::make('dashboard.attachment.all')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.all_attachment'),
							'attachments' 	=> Attachment::all(),
							'assets'		=> $this->assets,
						) 
					);
	}


	/**
	 * load add new attachment page
	 * @return object|view
	 */
	public function getAddNew()
	{
		return View::make('dashboard.attachment.multiple')
					->with( 
						array( 
							'title' 		=> Lang::get('dashboard.new_attachment'),
							'attachment' 	=> Attachment::model(),
							'assets'		=> $this->assets
						) 
					);
	}


	/**
	 * save the attachment to database
	 * @param  $action - save mode
	 * @param  $attachmentId - ID of attachment
	 * @return object|view
	 */
	public function postAddNew($attachmentId = NULL)
	{
		//Media::isValidAction($action);
		$attachments = Input::file('attachments');


		if (count($attachments) > 1)
		{
			echo 'multiple';
			return self::saveMultiple();
		}
		else
		{
			echo 'single';
			return self::saveMultiple();
			return self::saveSingle($attachmentId);
		}
		
	}


	/**
	 * load edit attachment page
	 * @return object|view
	 */
	public function modify($attachmentId)
	{
		$attachment = Attachment::find($attachmentId);

		if ($attachment)
		{
			return View::make('dashboard.attachment.single')
						->with( 
							array( 
								'title' 		=> Lang::get('dashboard.edit_attachment'),
								'formAction' 	=> url(Setting::getOption('admin_path', TRUE).'/attachment/edit/save/'.$attachmentId),
								'attachment' 	=> $attachment,
							) 
						);
		}

		App::abort(404);
	}





	/**
	 * save multiple attachments 
	 * generate thumbnails for image attachments
	 * @return string
	 */
	private function saveMultiple()
	{
		// Upload directory
		$uploadPath 	= public_path(Setting::getOption('upload_path'));

		foreach (\Input::file('attachments') as $attachment)
		{
			$fileSize 	= $attachment->getClientSize();
			$fileName 	= self::getFileName($uploadPath, $attachment->getClientOriginalName());
			$mimeType 	= $attachment->getMimeType();
			$info 		= pathinfo($uploadPath . $fileName);

			// Save uploaded file
			if ($attachment->move($uploadPath, $fileName))
				{
				if (in_array($mimeType, Config::get('cms/attachment.mimes.image')))
				{				
					// Generate different image dimensions
					self::generateThumbnails($uploadPath, $fileName);
				}
			}

			// Save to databse
			Attachment::add(
				$fileName,
				slugMake($info['filename']),
				Auth::user()->id,
				NULL,
				$fileName,
				$mimeType
			);
		}
	}


	/**
	 * save single attachment
	 * @param  $attachmentId - ID of attachment
	 * @param  $action - save mode
	 * @return object
	 */
	private function saveSingle($attachmentId)
	{
		$validator = Validator::make(
			Input::all(), 
			array_merge(self::$rules , array('attachment-slug' => array('unique:attachments,slug,'.$attachmentId)))
		);

		// Check if validation passes
		if (!$validator->passes())
		{
			return Redirect::to(Request::url())
				->withInput()
				->withErrors($validator);
		}

		// Save to databse
		Attachment::modify(
			$attachmentId,
			Input::get('attachment-title'),
			slugMake(ifNull(Input::get('attachment-slug'), Input::get('attachment-title'))),
			Auth::user()->id,
			Input::get('attachment-description')
		);

		return Redirect::to(Setting::getOption('admin_path', TRUE).'/attachment/edit/'.$attachmentId);
	}


	/**
	 * check the upload path and check if the new attachment's
	 * file name exist. And rename the new one to prevent overwriting 
	 * @param  $uploadPath - upload path
	 * @param  $fileName - file name of the new attachment
	 * @return string
	 */
	private function getFileName($uploadPath, $fileName)
	{
		$fullFilePath 	= $uploadPath . $fileName;
		$info 			= pathinfo($fullFilePath);
		$origFileName 	= $info['filename'];
		$fullFilePath 	= $info['dirname'] . '/' . $info['filename'] . '.' . $info['extension'];
		$unique 		= 1;

		while (file_exists($fullFilePath))
		{
			$info 			= pathinfo($fullFilePath);
			$fullFilePath 	= $info['dirname'] . '/' . $origFileName . $unique . '.' . $info['extension'];
			$fileName 		= $origFileName . $unique . '.' . $info['extension'];
			$unique++;
		}

		return $fileName;
	}


	/**
	 * generate thumbnails of the new image attachments
	 * @param  $uploadPath - upload path
	 * @param  $fileName - file name of the new attachment
	 * @return null
	 */
	private function generateThumbnails($uploadPath, $fileName)
	{
		$fullFilePath 	= $uploadPath . $fileName;
		$info 			= pathinfo($fullFilePath);
		$fullFilePath 	= $info['dirname'].'/'.$info['filename'].'.'.$info['extension'];


		foreach (Config::get('cms_main.image_sizes') as $size => $dimension)
		{
			Img::smart_resize_image(
				$uploadPath.$fileName, 
				NULL, 
				$dimension[0], 
				$dimension[1], 
				TRUE, 
				$info['dirname'].'/'.$info['filename'].'-'.$dimension[0].'x'.$dimension[1].'.'.$info['extension'], 
				false, 
				false,
				100
			);	
		}
	}


}