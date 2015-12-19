<?php
namespace Korobochkin\Currency\Service;

use \Korobochkin\Currency\Plugin;

class UpdateCurrency {
	static public $newRates = null;

	static function update( $show_warning_in_admin = false ) {

		// Получаем полностью все настройки + дефолтные на 100%
		$settings = get_option( \Korobochkin\Currency\Models\Settings\General::$option_name, array() );
		$settings = wp_parse_args( $settings, \Korobochkin\Currency\Models\Settings\General::get_defaults() );

		$providers_obj = \Korobochkin\Currency\Models\DataProviders::getInstance();
		$providers = $providers_obj->get_providers();

		if( array_key_exists( $settings['data_provider_name'], $providers ) ) {

			$api = new \Korobochkin\Currency\API\API( $providers[$settings['data_provider_name']] );
			self::$newRates = $api->get_rates();

			if( !is_wp_error( self::$newRates ) ) {
				update_option(
					\Korobochkin\Currency\Plugin::NAME . '_rates',
					self::$newRates
				);
				$settings['rates_available'] = true;
				return update_option( \Korobochkin\Currency\Models\Settings\General::$option_name, $settings );
			}
		}

		return false;
	}
}
