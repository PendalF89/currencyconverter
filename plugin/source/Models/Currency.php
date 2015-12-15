<?php
namespace Korobochkin\Currency\Models;

use Korobochkin\Currency\Plugin;

class Currency {

	/**
	 * Валюта, в которой будет указываться цена $currency.
	 * Хранится в виде названия из 3 букв (тикера).
	 */
	private $base_currency;

	/**
	 * Валюта, для которой производятся все рассчеты.
	 * Хранится в виде названия из 3 букв (тикера).
	 */
	private $currency;

	/**
	 * Копия опции из get_option() с курсами валют.
	 */
	private $rates = null;

	public function __construct( $base_currency, $currency ) {
		$this->set_currencies( $base_currency, $currency );
	}

	public function set_currencies( $base_currency, $currency ) {
		$this->base_currency = $base_currency;
		$this->currency = $currency;

		if( is_null( $this->rates ) ) {
			$this->rates = get_option( Plugin::NAME . '_rates' );
		}
	}

	public function is_available() {
		if(
			$this->rates
			&& isset( $this->rates[0]['rates'][$this->currency] )
			&& isset( $this->rates[0]['rates'][$this->base_currency] )
		) {
			return true;
		}
		return false;
	}

	public function get_rate( $date = 'last' ) {
		if( $this->is_available() ) {
			switch( $date ) {
				case 'last':
				default:
					$day_key = 0;
					break;

				case 'previous':
					$day_key = 1;
			}
			/**
			 * Применяем ставки
			 */
			$currency_rate = $this->currency  === 'USD' ? 1 : $this->rates[$day_key]['rates'][$this->currency];
			$base_rate = $this->base_currency === 'USD' ? 1 : $this->rates[$day_key]['rates'][$this->base_currency];

			/**
			 * Считаем всегда по одной формуле
			 */
			return $base_rate / $currency_rate;
		}
		return false;
	}

	public function get_previous_rate() {
		return $this->get_rate( 'previous' );
	}

	/**
	 * Рассчитывает изменение цены валюты в единицах $base_currency.
	 */
	public function get_change() {
		if( $this->is_available() ) {
			if( $this->currency === $this->base_currency ) {
				return 0;
			}
			else {
				return $this->get_rate() - $this->get_previous_rate();
			}
		}
	}

	/**
	 * Рассчитывает изменения цены валюты в процентах.
	 */
	public function get_change_percentage() {
		if( $this->is_available() ) {
			if( $this->currency === $this->base_currency ) {
				return 0;
			}
			else {
				return 100 - (( 100 * $this->rates[1]['rates'][$this->currency] ) / $this->rates[0]['rates'][$this->currency]);
			}
		}
		return false;
	}

	public function get_trend() {
		if( $this->is_available() ) {
			if( $this->rates[0]['rates'][$this->currency] > $this->rates[1]['rates'][$this->currency] ) {
				return 'up';
			}
			elseif( $this->rates[0]['rates'][$this->currency] == $this->rates[1]['rates'][$this->currency] ) {
				return 'flat';
			}
			else {
				return 'down';
			}
		}
		return false;
	}

}
