<?php
namespace Korobochkin\CurrencyConverter\Service;

use HtmlTableGenerator\Table;
use Korobochkin\CurrencyConverter\Models\Country;
use Korobochkin\CurrencyConverter\Models\Currency;
use Korobochkin\CurrencyConverter\Plugin;

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
				!empty( $this->parameters['table_headers_currencies'] )
				|| !empty( $this->parameters['table_headers_price'] )
				|| !empty( $this->parameters['table_headers_change'] )
			) {
				$this->table->set_heading(
					array(
						$this->parameters['table_headers_currencies'],
						$this->parameters['table_headers_price'],
						$this->parameters['table_headers_change']
					)
				);
				$have_data = true;
			}

			foreach( $this->parameters['currency_list'] as $currency ) {

				$currency_obj = new Currency( $this->parameters['base_currency'], $currency );
				// Проверяем доступность валюты
				if( $currency_obj->is_available() ) {
					$currency_data_filtered = Text::currency_info_for_round( $currency_obj, 2 );
					$currency_data_filtered['trend'] = esc_attr( $currency_data_filtered['trend'] );
					$have_data = true;

					// Страна
					$country_obj = new Country();
					$country_obj->set_country_by_currency( $currency );

					// Получаем флаг, цену и изменение. Форматируем числа.
					$output_data = array();
					$flag = $country_obj->get_flag_url( $this->parameters['flag_size'] );
					if( $flag ) {
						$flag = sprintf(
							'<img src="%1$s" class="currencyconverter-flag-icon currencyconverter-flag-icon-%2$s">',
							esc_url( $flag ),
							esc_attr( $this->parameters['flag_size'] )
						);
					}
					else {
						$flag = '';
					}

					// Flag
					$output_data[0] = $flag . ' ' . $currency;

					// Rate (price)
					$output_data[1] = number_format_i18n( $currency_data_filtered['rate'], 2 );

					// Change %
					$output_data[2] = sprintf(
						/* translators: %s - currency change number (digit) in percentage. %% - one percentage symbol (typed twice for escape in printf() func.) */
						__( '%s<span class="currencyconverter-percentage-symbol">%%</span>', Plugin::NAME ),
						Text::number_format_i18n_plus_minus( $currency_data_filtered['change_percentage'], 2 )
					);

					// Wrap into the colored spans.
					$content_wrapper_template = '<span class="currencyconverter-color-%1$s">%2$s</span>';

					$output_data[1] = sprintf( $content_wrapper_template, $currency_data_filtered['trend'], $output_data[1] );
					if( $currency_data_filtered['per'] > 1 ) {
						/* translators: Some of currencies (units) are very small. For example 1 US dollar (USD) = 0.0026528435830000001 bitcoins (BTC). Sometimes we round this to 0.00 by round() func. To avoid this small currencies (units) recalculated by multiplying "small" number by 1000 or 1000000. And after this: 1000 USD = 0.26 BTC (0.26 BTC per 1000 USD). */
						$output_data[1] .= ' <span class="currencyconverter-per">' . esc_html( sprintf( __( 'per %s', Plugin::NAME ), number_format_i18n( $currency_data_filtered['per'] ) ) ) . '</span>';
					}

					// Arrow up-bottom
					$trend = sprintf(
						'<span class="currencyconverter-trend currencyconverter-trend-%1$s"></span>',
						$currency_data_filtered['trend']
					);
					$output_data[2] = $trend . sprintf( $content_wrapper_template, $currency_data_filtered['trend'], $output_data[2] );

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
			!isset( $this->parameters['table_headers_currencies'] )
			|| !isset( $this->parameters['table_headers_price'] )
			|| !isset( $this->parameters['table_headers_change'] )
		) {
			return false;
		}

		return true;
	}
}
