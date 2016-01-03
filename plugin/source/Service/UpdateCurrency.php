<?php
namespace Korobochkin\CurrencyConverter\Service;

use \Korobochkin\CurrencyConverter\Plugin;

class UpdateCurrency {
	static public $newRates = null;

	static function update( $show_warning_in_admin = false ) {

		// Получаем полностью все настройки + дефолтные на 100%
		$settings = get_option( \Korobochkin\CurrencyConverter\Models\Settings\General::$option_name, array() );
		$settings = wp_parse_args( $settings, \Korobochkin\CurrencyConverter\Models\Settings\General::get_defaults() );

		$providers_obj = \Korobochkin\CurrencyConverter\Models\DataProviders::getInstance();
		$providers = $providers_obj->get_providers();

		if( array_key_exists( $settings['data_provider_name'], $providers ) ) {

			$api = new \Korobochkin\CurrencyConverter\API\API( $providers[$settings['data_provider_name']] );
			self::$newRates = $api->get_rates();

			if( !is_wp_error( self::$newRates ) ) {
				update_option(
					\Korobochkin\CurrencyConverter\Plugin::NAME . '_rates',
					self::$newRates
				);
				$settings['rates_available'] = true;
				$settings['cached_rates_by_data_provider_name'] = $settings['data_provider_name'];
				$result = update_option( \Korobochkin\CurrencyConverter\Models\Settings\General::$option_name, $settings );
				return true;
			}
		}

		return false;
	}
}
