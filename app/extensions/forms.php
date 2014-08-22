<?php

/**
* Register a custom form macro
*
* @param 	string  $name
* @return  	string
*/
Form::macro('colorPicker', function($name)
{
	$value = (is_null(Form::old($name)) ? Form::getValueAttribute($name) : Form::old($name));
	return '<div class="input-group color-picker"><input type="text" name="'.$name.'" value="'.$value.'" class="form-control"/><div class="input-group-addon"><i></i></div></div>';
});