<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Sections\DataProvidersPrevew;

use Korobochkin\CurrencyConverter\Models\Country;
use Korobochkin\CurrencyConverter\Plugin;

class Table extends \WP_List_Table {

	function get_columns() {
		return array(
			'country_flag' => __( 'Country flag', Plugin::NAME ),
			'currency_iso' => __( 'Currency ISO code', Plugin::NAME ),
			'currency' => __( 'Currency', Plugin::NAME ),
			'country' => __( 'Country', Plugin::NAME )
		);
	}

	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->items = \Korobochkin\CurrencyConverter\Models\Currencies\Currencies::get_currencies_as_numeric_array();
	}

	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'country_flag':
				$country = new Country();
				$country->set_country_by_currency( $item['currency_iso'] );
				$flag = $country->get_flag_url( 32 );
				$flag = '<img src="' . $flag . '">';
				return $flag;

			case 'currency_iso':
				return $item['currency_iso'];

			case 'currency':
				return $item['currency_name'];

			case 'country':
				return $item['country_name'];

			default:
				return print_r( $item, true ) ; // Show the whole array for troubleshooting purposes
		}
	}
}