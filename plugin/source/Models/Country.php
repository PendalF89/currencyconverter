<?php
namespace Korobochkin\Currency\Models;

use Korobochkin\Currency\Models\Currencies\Currencies;
use Korobochkin\Currency\Plugin;

class Country {

	private $currency = null;

	public function __construct() {

	}

	public function set_country_by_currency( $currency ) {
		$currency = Currencies::get_currency($currency);
		if( $currency ) {
			$this->currency = $currency;
		}
	}

	public function get_flag_url( $size = 16, $style = 'flat' ) {
		if( !empty( $this->currency['flag_name'] ) ) {
			$url = plugin_dir_url( $GLOBALS['CurrencyPlugin']->plugin_path );
			$url .= 'libs/flags/flags-iso/flat/';
			switch( $size ) {
				case 16:
				case 24:
				case 32:
				case 48:
				case 64:
					$url .= (string)$size;
					break;

				default:
					$url .= '16';
					break;
			}
			$url .= '/' . $this->currency['flag_name'] . '.png';
			return $url;
		}
		return false;
	}
}
