<?php
namespace Korobochkin\Currency\Service;

use HtmlTableGenerator\Table;
use Korobochkin\Currency\Models\Country;
use Korobochkin\Currency\Models\Currency;
use Korobochkin\Currency\Plugin;

class CurrencyTable {

	public $parameters;

	/**
	 * Список валют
	 * Базовая валюта
	 * Показывать процент или нет
	 *
	 */

	public $table;

	public function get_table() {
		if( !empty( $this->parameters['currency_list'] ) ) {

			$this->table = new Table();
			// TODO: Остановились здесь

			$this->table->set_heading( array(
				__( 'Currency', Plugin::NAME ),
				__( 'Rate', Plugin::NAME ) . ' ' . $this->parameters['base_currency'],
				'%'
			) );

			foreach( $this->parameters['currency_list'] as $currency ) {

				// Валюта
				$currency_obj = new Currency( $this->parameters['base_currency'], $currency );

				// Страна
				$country_obj = new Country();
				$country_obj->set_country_by_currency( $currency );

				// Получаем текущую цену и форматируем ее
				$output_data[] = $currency_obj->get_rate();
				$output_data[] = $currency_obj->get_change_percentage();
				$output_data[] = $country_obj->get_flag_url();

				foreach( $output_data as $key => $output_data_single ) {
					if( !$output_data_single ) {
						unset($output_data[$key]);
						continue;
					}
					else {
						if( is_numeric( $output_data_single ) ) {
							$output_data[$key] = number_format_i18n( $output_data[$key], 2 );
						}
					}
				}
				if( !empty( $output_data ) ) {
					$this->table->add_row();
				}
			}
			return $this->table->generate();
		}

		return '';
	}

	public function merge_defaults() {
		$this->parameters['currency_list'] = array();
		if( empty( $this->parameters['base_currency'] ) ) {
			$this->parameters['base_currency'] = 'USD';
		}

	}

	public function is_valid() {
		if( empty( $this->parameters['currency_list'] ) || !is_array( $this->parameters['currency_list'] ) ) {
			return false;
		}
		if( empty( $this->parameters['base_currency'] ) ) {
			return false;
		}
		if( !isset( $this->parameters['flag_size'] ) ) {
			return false;
		}
	}
}
