<?php
namespace Korobochkin\Currency\Service;

use Korobochkin\Currency\API\API;
use Korobochkin\Currency\Plugin;

class DataProvidersPreview {

	private static $providers_data = null;

	private static $providers_list = null;

	public static function get_providers_preview() {

		// Запрашиваем кеш
		self::$providers_data = get_transient( Plugin::NAME . '_providers' );

		// Проверяем чего нет и пытаемся получить данные
		self::get_missing_providers_data();

		// Запихиваем в кеш
		set_transient( Plugin::NAME . '_providers', self::$providers_data, 24 * HOUR_IN_SECONDS );

		// Отдаем то, что засунули в кеш
		return self::$providers_data;
	}

	private static function get_missing_providers_data() {

		// Запрашиваем список провайдеров
		self::$providers_list = \Korobochkin\Currency\Models\DataProviders::getInstance()->get_providers();

		if( is_array( self::$providers_data ) ) {
			foreach( self::$providers_list as $provider_key => $provider_meta ) {
				$provider_valid = self::validate_provider_data( $provider_key );
				if( !$provider_valid ) {
					self::try_fetch_provider_data( $provider_key );
				}
			}
		}
		else {
			foreach( self::$providers_list as $provider_key => $provider_meta ) {
				self::try_fetch_provider_data( $provider_key );
			}
		}
	}

	private static function validate_provider_data( $provider_key ) {
		if( isset( self::$providers_data[$provider_key] ) ) {
			if( self::$providers_data[$provider_key]['status'] === 'ok' ) {
				if( !empty( self::$providers_data[$provider_key]['currencies'] ) ) {
					return true;
				}
			}
		}
		return false;
	}

	private static function try_fetch_provider_data( $provider_key ) {
		$api = new API(self::$providers_list[$provider_key]);
		$currencies_list = $api->get_currencies_list();

		if( is_wp_error( $currencies_list ) ) {
			self::$providers_data[$provider_key]['status'] = 'failure';
			self::$providers_data[$provider_key]['errors'] = $currencies_list->get_error_messages();
			self::$providers_data[$provider_key]['currencies'] = array();
		}
		else {
			self::$providers_data[$provider_key]['status'] = 'ok';
			self::$providers_data[$provider_key]['errors'] = array();
			self::$providers_data[$provider_key]['currencies'] = $currencies_list;
		}

	}
}
