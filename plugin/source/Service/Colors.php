<?php
namespace Korobochkin\CurrencyConverter\Service;

class Colors {
	public static function hex2rgb( $hex, $format = 'string' ) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		if($format == 'string') {
			return implode(",", $rgb); // returns the rgb values separated by commas
		}
		return $rgb; // returns an array with the rgb values
	}

	public static function hex2rgba( $hex, $opacity, $format = 'string' ) {
		$rgba = self::hex2rgb($hex, 'array');
		$rgba[] = (int)$opacity / 100;

		if($format == 'string') {
			return implode(",", $rgba);
		}
		return $rgba;
	}
}
