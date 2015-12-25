<?php
namespace Korobochkin\CurrencyConverter\Service;

class Text {

	public static function format_plus_minus_signs( $number, $formatted_number ) {
		if( $number > 0 ) {
			$formatted_number = '+' . $formatted_number;
		}
		elseif( $number < 0 ) {
			$formatted_number = str_replace('-', '&ndash;', $formatted_number );
		}
		return $formatted_number;
	}

	public static function number_format_i18n_plus_minus( $number, $decimals = 2 ) {
		$number = (float)$number;
		$decimals = absint( $decimals );

		$formatted_number = number_format_i18n( $number, $decimals );

		$formatted_number = self::format_plus_minus_signs($number, $formatted_number);

		return $formatted_number;
	}
}
