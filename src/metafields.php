<?php


/**
 * 
 */
class EAMetaFields
{

	const T_INPUT    = 'INPUT';
	const T_TEXTAREA = 'TEXTAREA';
	const T_SELECT   = 'SELECT';

	function __construct() { }

	static function getMetaFieldsType()
	{
		return array(
			T_INPUT    => __('Input', 'easy_appointments'),
			T_SELECT   => __('Select', 'easy_appointments'),
			T_TEXTAREA => __('Text', 'easy_appointments'),
		);
	}
}