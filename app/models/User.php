<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface{

	protected $fillable = array('username', 'password', 'email_address');
	protected $hidden 	= array( 'password' );

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword()
	{
		return $this->password;
	}

	public function getReminderEmail()
	{
		return $this->email_address;
	}


	/* ---------------------------------
	Relations
	--------------------------------- */
	public function posts()
	{
		return $this->hasMany('Post');
	}


	public function attachments()
	{
		return $this->hasMany('Attachment', 'user_id');
	}


	public function getDateFormat()
	{
		return 'Y-m-d h:i:s';
	}


	/* ---------------------------------
	Abstract method
	--------------------------------- */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}


	/* ---------------------------------
	Add new user
	--------------------------------- */
	static function add( $userLevel, $emailAddress, $username, $password, $firstName, $lastName )
	{
		$user = new User;
		$user->user_level 		= $userLevel;
		$user->email_address 	= $emailAddress;
		$user->username 		= $username;
		$user->password 	= Hash::make( $password );
		$user->first_name 		= $firstName;
		$user->last_name 		= $lastName;
		$user->save();
	}


	static function modify( $userLevel, $username, $password, $firstName, $lastName ){
		$user = User::where( 'username', $username )->first();			
		$user = User::find( $user->id );
		if ( $password ){
			$user->password 	= Hash::make( $password );
		}
		$user->user_level 			= $userLevel;
		$user->first_name 			= $firstName;
		$user->last_name 			= $lastName;
		$user->save();
	}

	static function erase( $username ){
		$user = User::where( 'username', $username )->first();
		$user = $user::find( $user->id );
		$user->delete();
	}

	static function page( $sortingOrder, $sWhere, $sLimitStart, $sLimitEnd ){
		$users = DB::table( 'users' )
					->where( 'UPPER( LAST_NAME )', 'like', '%' . $sWhere . '%' )
					->orWhere( 'UPPER( FIRST_NAME )', 'like', '%' . $sWhere . '%' )
					->orWhere( 'UPPER( username )', 'like', '%' . $sWhere . '%' )
					->orWhere( 'UPPER( CREATED_AT )', 'like', '%' . $sWhere . '%' )
					->orWhere( 'UPPER( UPDATED_AT )', 'like', '%' . $sWhere . '%' )
					->orderBy( $sortingOrder['column'], $sortingOrder['direction'] )
					->skip( $sLimitStart )
					->take( $sLimitEnd )
					->get();
		return $users;
	}

}