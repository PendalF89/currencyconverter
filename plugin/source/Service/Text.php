<?php
namespace Korobochkin\Currency\Service;

class Text {

	public static function format_plus_minus_signs( $number ) {
		if( $number > 0 ) {
			$number = '+' . $number;
		}
		elseif( $number < 0 ) {
			$number = str_replace('-', '&ndash;', $number );
		}
		return $number;
	}
}
