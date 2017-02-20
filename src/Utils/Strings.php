<?php

namespace Annotate\Framework\Utils;

class Strings extends \Nette\Utils\Strings
{

	public static function fromDashes($s)
	{
		$s = strtolower($s);
		$s = preg_replace('#-(?=[a-z])#', ' ', $s);
		$s = substr(ucwords('x' . $s), 1);

		return $s;
	}



	public static function toDashes($s)
	{
		$s = preg_replace('#(.)(?=[A-Z])#', '$1-', $s);
		$s = strtolower($s);
		$s = rawurlencode($s);

		return $s;
	}



	/**
	 * Converts string to array, items can be divided by , (comma) or/and space
	 *
	 * @param  string
	 * @return array
	 */
	public static function toArray($string)
	{
		return self::split($string, "~[, ]+~");
	}

}
