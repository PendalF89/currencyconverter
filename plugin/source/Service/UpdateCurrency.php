<?php
namespace Korobochkin\Currency\Service;

class UpdateCurrency {
	static public $newRates = null;

	static function update( $show_warning_in_admin = false ) {

		$provider = get_option( Plugin::NAME );
		$providers_obj = \Korobochkin\Currency\Models\DataProviders::getInstance();
		$providers = $providers_obj->get_providers();

		if( !empty( $provider['data_provider_name'] ) && array_key_exists( $provider['data_provider_name'], $providers ) ) {

			// TODO: Похоже здесь проблемы и мы не передаем название провайдера
			$api = new \Korobochkin\Currency\API\API( $providers[$provider['data_provider_name']] );
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

	static function select_provider() {
		
	}
}
