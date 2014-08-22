<?php
class BaseModel extends Eloquent{

	private static function getCallerClass()
	{
		return get_called_class();
	}

	static function hasItem( $column, $item )
	{
		$callerClass 	= self::getCallerClass();
		$user 			= $callerClass::where( $column, $item )->first();
		if ( !isset( $user ) )
		{
			return false;
		}
		return true;
	}

	static function recordCount(){
		$callerClass 	= self::getCallerClass();
		$records 		= $callerClass::all();
		return count( $records );
	}

}
?>