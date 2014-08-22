<?php

class Setting extends Eloquent{

	protected $fillable = array('option_name', 'option_name');


	/**
	 * Set option
	 * Create a new one when option name dont exist
	 *  update if option name exist
	 * @param  $optionName - name of option
	 * @param  $optionValue - value of option
	 * @return string
	 */
	public static function set($optionName, $optionValue)
	{
		$setting = Setting::firstOrCreate(array('option_name' => $optionName));
		$setting->option_name 	= $optionName;
		$setting->option_value 	= $optionValue;
		$setting->save();
		
		return $setting->id;
	}


	/**
	 * Get options
	 * For cache: In case the values are serializabe
	 *  each key/value pair will be cached individually
	 * @param  $optionName - name of option
	 * @param  $cached - optiona name and value will be cached
	 * @return string
	 */
	public static function getOption($optionName, $cached = FALSE)
	{ 
		if (Cache::has($optionName))
		{
			return Cache::get($optionName);
		}
		else
		{
			$optionValue = DB::table(with(new Setting)->getTable())
								->where('option_name', $optionName)
								->pluck('option_value');

			if ($cached)
			{
				// Try to unserialize the value
				$data = @unserialize($optionValue);

				// If the value is seializable
				//  we make sure that they are in cache
				if ($data !== false) {
					foreach ($data as $key => $value)
					{
						Cache::add($key, $value, Config::get('cms_main.cache'));
					}
				}
				else
				{
					Cache::add($optionName, $optionValue, Config::get('cms_main.cache'));
				}
				
			}

			return $optionValue;
		}
	}


	/**
	 * Get serialized option as array
	 * Each key/value pair will be cached individually
	 * @param  $optionName - name of option
	 * @param  $cached - optiona name and value will be cached
	 * @return array
	 */
	public static function getOptionArray($optionName, $cached = FALSE)
	{
		if (Cache::has($optionName))
		{
			return Cache::get($optionName);
		}
		else
		{
			$optionValue = DB::table(with(new Setting)->getTable())
								->where('option_name', $optionName)
								->pluck('option_value');

			// Try to unserialize the value
			$data = @unserialize($optionValue);
			$items = array();

			// If the value is seializable
			//  we make sure that they are in cache
			if ($data !== false) {
				foreach ($data as $key => $value)
				{
					$items[$key] = $value;
				}
			}


			if ($cached)
			{				
				Cache::add($optionName, $items, Config::get('cms_main.cache'));				
			}
			
			return $items;		
		}
	}


	/**
	 * Get set of settings
	 * @param  array $settingsName
	 * @return object
	 */
	public static function getSet($settingsName)
	{
		$settings = Setting::whereIn('option_name', array_keys($settingsName))->get();
		$items = new Setting;

		foreach ($settings as $key => $value)
		{
			$items->{$value->option_name} = $value->option_value;
		}
		
		return $items;
	}
}