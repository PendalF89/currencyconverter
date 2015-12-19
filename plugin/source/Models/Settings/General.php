<?php
namespace Korobochkin\Currency\Models\Settings;

use Korobochkin\Currency\Plugin;

class General {

	public static $option_name = Plugin::NAME;

	public static function get_defaults() {
		return array(
			'data_provider_name' => _x( 'oxr', 'Выберите поставщика данных из доступных наиболее подходящего для региона (языка). Список доступных в файле plugin/source/Models/DataProviders.php.', Plugin::NAME ),
			'rates_available' => false
		);
	}
}
