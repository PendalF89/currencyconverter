<?php
namespace Korobochkin\Currency\Service;

use HtmlTableGenerator\Table;

class CurrencyTable {

	public $parameters;

	/**
	 * Список валют
	 * Показывать процент или нет
	 *
	 */

	public $table;

	public function get_table() {
		if( !empty( $this->parameters['currency_list'] ) && \Korobochkin\Currency\Service\Rates::is_available() ) {

			$this->table = new Table();
			$this->table->set_heading(
				array(
					'Валюта',
					'Курс',
					'%'
				)
			);
			$rates = get_option( \Korobochkin\Currency\Plugin::NAME . '_rates' );

			foreach( $this->parameters['currency_list'] as $currency ) {
				$rate = \Korobochkin\Currency\Service\Rates::get_rate( $currency, $this->parameters['base_currency'] );

				if( $rate ) {
					$this->table->add_row(
						esc_html( $currency ),
						$rate,
						0
					);
				}
			}
			return $this->table->generate();
		}

		return '';
	}
}
