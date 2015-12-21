<?php
namespace Korobochkin\CurrencyConverter\Models;

use Korobochkin\CurrencyConverter\Models\Currencies\Currencies;
use Korobochkin\CurrencyConverter\Plugin;

class Country {

	private $currency = null;

	private $currency_iso_code = null;

	public function __construct() {

	}

	public function set_country_by_currency( $currency ) {
		$this->currency_iso_code = $currency;
		$currency = Currencies::get_currency($currency);
		if( $currency ) {
			$this->currency = $currency;
		}
	}

	public function get_flag_url( $size = 16, $style = 'flat' ) {
		if( !empty( $this->currency['flag_name'] ) ) {
			$url = plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path );
			$url .= 'libs/flags/flags-iso/flat/';
			switch( $size ) {
				case 0:
					return '';
					break;
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

	public function is_flag_available() {
		if($this->currency_iso_code) {
			$country_iso_code = substr($this->currency_iso_code, 0, 2);
			if($country_iso_code) {
				$path = dirname($GLOBALS['CurrencyConverterPlugin']->plugin_path);
				$path .= '/libs/flags/flags-iso/flat/16/' . $country_iso_code . '.png';
				$flag_available = file_exists( $path );

				if($flag_available) {
					return true;
				}
			}
		}
		return false;
	}
}
