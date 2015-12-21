<?php
namespace Korobochkin\CurrencyConverter\Service;

use Korobochkin\CurrencyConverter\Models\Country;
use Korobochkin\CurrencyConverter\Plugin;

class CheckFlags {
	public static function all() {
		$rates = get_option( Plugin::NAME . '_rates' );
		echo 'Start checking flags.' . PHP_EOL;
		foreach( $rates[0]['rates'] as $key => $value ) {
			$country_obj = new Country();
			$country_obj->set_country_by_currency($key);

			$flag_available = $country_obj->is_flag_available();

			if( !$flag_available ) {
				echo $key . PHP_EOL;
			}
		}
		echo 'Stop checking flags.' . PHP_EOL;
	}
}
