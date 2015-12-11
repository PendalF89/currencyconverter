<?php
namespace Korobochkin\Currency\Service;

class UpdateCurrency {
	static public $newRates = null;

	static function update( $show_warning_in_admin = false ) {
		$api = new \Korobochkin\Currency\API\API();
		self::$newRates = $api->get_rates();
		if( !is_wp_error( self::$newRates ) ) {
			update_option(
				\Korobochkin\Currency\Plugin::NAME . '_rates',
				self::$newRates
			);
			update_option( \Korobochkin\Currency\Plugin::NAME . '_rates_available', '1' );
		}
	}
}
