<?php
namespace Korobochkin\CurrencyConverter\Models\Settings;

use Korobochkin\CurrencyConverter\Plugin;

class General {

	public static $option_name = Plugin::NAME;

	public static function get_defaults() {
		return array(
			'data_provider_name' => _x( 'oxr', 'Select default data provider. The list of available providers located in plugin/source/Models/DataProviders.php.', Plugin::NAME ),
			'rates_available' => false
		);
	}
}
