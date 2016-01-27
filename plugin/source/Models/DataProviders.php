<?php
namespace Korobochkin\CurrencyConverter\Models;

use Korobochkin\CurrencyConverter\API\API;
use Korobochkin\CurrencyConverter\Plugin;

class DataProviders {
	private static $instance;

	private $transient_name;

	private $providers = null;

	private $providers_data = null;

	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
			static::$instance->prepare_vars();
			static::$instance->prepare_providers();
		}
		return static::$instance;
	}

	protected function __construct() {}

	private function __clone() {}

	private function __wakeup() {}

	private function prepare_vars() {
		$this->transient_name = Plugin::NAME . '_providers';
	}

	private function prepare_providers() {
		$this->providers = array(
			'oxr' => array(
				'abbreviated_name' => 'oxr',
				'name' => __( 'Open Exchange Rates', Plugin::NAME  ),
				'homepage' => 'https://openexchangerates.org/',
				'active' => true,
				'api_url' => 'http://api.exchangerate.guru/?source=oxr'
			),
			'cbr' => array(
				'abbreviated_name' => 'cbr',
				'name' => __( 'Central Bank of Russia', Plugin::NAME ),
				'homepage' => 'http://www.cbr.ru/',
				'active' => true,
				'api_url' => 'http://api.exchangerate.guru/?source=cbr'
			)
		);
	}

	public function get_transient_name() {
		return $this->transient_name;
	}

	public function get_providers() {
		return $this->providers;
	}

	public function get_providers_preview() {

		// Запрашиваем кеш
		$this->providers_data = get_transient( $this->transient_name );

		// Проверяем чего нет и пытаемся получить данные
		$this->get_missing_providers_data();

		// Запихиваем в кеш
		set_transient( $this->transient_name, $this->providers_data, 24 * HOUR_IN_SECONDS );

		// Отдаем то, что засунули в кеш
		return $this->providers_data;
	}

	private function get_missing_providers_data() {
		if( is_array( $this->providers_data ) ) {
			foreach( $this->providers as $provider_key => $provider_meta ) {
				$provider_valid = $this->validate_provider_data( $provider_key );
				if( !$provider_valid ) {
					$this->try_fetch_provider_data( $provider_key );
				}
			}
		}
		else {
			foreach( $this->providers as $provider_key => $provider_meta ) {
				$this->try_fetch_provider_data( $provider_key );
			}
		}
	}

	private function validate_provider_data( $provider_key ) {
		if(
			isset( $this->providers_data[$provider_key]['status'] )
			&&
			$this->providers_data[$provider_key]['status'] === 'ok'
			&&
			!empty( $this->providers_data[$provider_key]['currencies'] )
		) {
			return true;
		}
		return false;
	}

	private function try_fetch_provider_data( $provider_key ) {
		$api = new API($this->providers[$provider_key]);
		$currencies_list = $api->get_currencies_list();

		if( is_wp_error( $currencies_list ) ) {
			$this->providers_data[$provider_key]['status'] = 'failure';
			$this->providers_data[$provider_key]['errors'] = $currencies_list->get_error_messages();
			$this->providers_data[$provider_key]['currencies'] = array();
		}
		else {
			$this->providers_data[$provider_key]['status'] = 'ok';
			$this->providers_data[$provider_key]['errors'] = array();
			$this->providers_data[$provider_key]['currencies'] = $currencies_list;
		}

	}
}
