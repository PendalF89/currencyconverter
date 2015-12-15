<?php
namespace Korobochkin\Currency\Models;

use Korobochkin\Currency\Models\Currencies\Currencies;

class Country {

	private $flagObj;

	public function __construct() {

	}

	public function set_country_by_currency( $currency ) {
		$currency = Currencies::get_currency($currency);
		if( $currency ) {
			$this->currency = $currency;
		}
	}

	public function get_flag($flag) {
		return $this->flagObj;
	}
}
