<?php
namespace Korobochkin\Currency\Models;

use Korobochkin\Currency\Plugin;

class DataProviders {
	private static $instance;

	private $providers;

	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
			static::$instance->prepare_providers();
		}
		return static::$instance;
	}

	protected function __construct() {}

	private function __clone() {}

	private function __wakeup() {}

	public function prepare_providers() {
		$this->providers = array(
			'oxr' => array(
				'abbreviated_name' => 'oxr',
				'name' => __( 'Open Exchange Rates', Plugin::NAME  ),
				'homepage' => 'https://openexchangerates.org/',
				'active' => true
			),
			'cbr' => array(
				'abbreviated_name' => 'cbr',
				'name' => __( 'Central Bank of Russia', Plugin::NAME ),
				'homepage' => 'http://www.cbr.ru/',
				'active' => true
			)
		);
	}

	public function get_providers() {
		return $this->providers;
	}
}
