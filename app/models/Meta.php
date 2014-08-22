<?php

class Meta extends Eloquent { 
	
	protected $fillable = array('object_id', 'meta_name', 'meta_value');

	protected function getDateFormat()
	{
		return 'Y-m-d h:i:s';
	}


	public function post()
	{
		return $this->belongsTo('Post');
	}


	/**
	 * Set meta value
	 * @param  $postId - post id
	 * @param  $name - name of meta
	 * @param  $value - value of meta
	 * @return integer
	 */
	static function set($postId, $name, $value)
	{
		$meta = Meta::firstOrCreate(array('object_id' => $postId, 'meta_name' => $name));
		$meta->object_id 	= $postId;
		$meta->meta_name 	= $name;
		$meta->meta_value 	= $value;
		$meta->save();

		return $meta->id;
	}


	static function value($metaName)
	{
		$meta = Meta::where( 'object_id', '=', Page::id() )
					->where( 'meta_name', '=', $metaName )
					->select( 'meta_value' )
					->first();
		
		
		if ( isset( $meta ) )
		{
			return $meta->meta_value;	
		}

		return false;
	}


	/**
	 * Get post's metas
	 * @param  $postId - post id
	 * @param  $returnArray - return results as assciative array
	 * @return integer
	 */	
	static function getMultiple($postId, $returnArray = 0)
	{
		$metas 	= Meta::select('meta_name', 'meta_value')
						->where('object_id', '=', $postId)
						->get();
		

		if ($returnArray)
		{
			$returnValue = array();

			foreach ($metas as $meta)
			{
				$returnValue[$meta->meta_name] = $meta->meta_value;
			}

			return $returnValue;
		}
		else
		{
			return $metas;
		}
	}


}