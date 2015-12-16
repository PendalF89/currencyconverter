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
		if( $this->is_valid() ) {

			$this->table = new Table();
			$have_data = false;

			// Header
			if(
				!empty( $this->parameters['table_headers']['currencies'] )
				|| !empty( $this->parameters['table_headers']['price'] )
				|| !empty( $this->parameters['table_headers']['change'] )
			) {
				$this->table->set_heading( array_values( $this->parameters['table_headers'] ) );
				$have_data = true;
			}

			foreach( $this->parameters['currency_list'] as $currency ) {

				$currency_obj = new Currency( $this->parameters['base_currency'], $currency );
				// Проверяем доступность валюты
				if( $currency_obj->is_available() ) {
					$have_data = true;

					// Страна
					$country_obj = new Country();
					$country_obj->set_country_by_currency( $currency );

					// Получаем флаг, цену и изменение. Форматируем числа.
					$output_data = array();
					$flag = $country_obj->get_flag_url( $this->parameters['flag_size'] );
					if( $flag ) {
						$flag = sprintf(
							'<img src="%1$s" class="currency-flag-icon currency-flag-icon-%2$s">',
							$flag,
							$this->parameters['flag_size']
						);
					}
					else {
						$flag = '';
					}
					$output_data[0] = $flag . ' ' . $currency;
					$output_data[1] = $currency_obj->get_rate();
					$output_data[2] = $currency_obj->get_change_percentage();

					// Стрелочка
					$trend = $currency_obj->get_trend();
					if( $trend ) {
						$trend = sprintf(
							'<span class="currency-trand currency-trand-%1$s"></span>',
							$trend
						);
					}
					else {
						$trend = '';
					}


					foreach( $output_data as $key => $output_data_single ) {
						if( !$output_data_single ) {
							$output_data[$key] = '';
							continue;
						}
						else {
							if( is_numeric( $output_data_single ) ) {
								$output_data[$key] = number_format_i18n( $output_data[$key], 2 );
							}
						}
					}
					$output_data[2] .= $trend;

					// Добавляем ряд (строчку) в таблицу
					$this->table->add_row( $output_data );
				}
			}
			if ($have_data) {
				return $this->table->generate();
			}
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
		if( !isset( $this->parameters['flag_size'] ) || !is_int( $this->parameters['flag_size'] ) ) {
			return false;
		}

		if(
			!isset( $this->parameters['table_headers']['currencies'] )
			|| !isset( $this->parameters['table_headers']['price'] )
			|| !isset( $this->parameters['table_headers']['change'] )
		) {
			return false;
		}

		return true;
	}
}
