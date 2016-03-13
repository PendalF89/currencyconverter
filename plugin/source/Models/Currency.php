<?php
namespace Korobochkin\CurrencyConverter\Models;

use Korobochkin\CurrencyConverter\Models\Currencies\Currencies;
use Korobochkin\CurrencyConverter\Plugin;

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

			&& !empty( $this->rates[0]['date'] )
			&& !empty( $this->rates[1]['date'] )
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
					break;
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

	public function get_rate_datetime( $date = 'last' ) {
		if( $this->is_available() ) {
			switch( $date ) {
				case 'last':
				default:
					$day_key = 0;
					break;

				case 'previous':
					$day_key = 1;
					break;
			}

			$datetime_obj = new \DateTime( $this->rates[$day_key]['date'], new \DateTimeZone('GMT') );
			return $datetime_obj;
		}
		return false;
	}

	public function get_previous_rate_datetime() {
		return $this->get_rate_datetime( 'previous' );
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
				return 100 - (( 100 * $this->get_previous_rate() ) / $this->get_rate());
			}
		}
		return false;
	}

	public function get_trend() {
		if( $this->is_available() ) {
			if( $this->get_rate() > $this->get_previous_rate() ) {
				return 'up';
			}
			elseif( $this->get_rate() == $this->get_previous_rate() ) {
				return 'flat';
			}
			else {
				return 'down';
			}
		}
		return false;
	}

	public function get_base_currency_name() {
		if( $this->is_available() ) {
			$currencies_list = Currencies::get_currencies();
			if( isset( $currencies_list[$this->base_currency]['currency_name'] ) ) {
				return $currencies_list[$this->base_currency]['currency_name'];
			}
			else {
				return '';
			}
		}
		return false;
	}

	public function get_base_currency_country_name() {
		if( $this->is_available() ) {
			$currencies_list = Currencies::get_currencies();
			if( isset( $currencies_list[$this->base_currency]['country_name'] ) ) {
				return $currencies_list[$this->base_currency]['country_name'];
			}
			else {
				return '';
			}
		}
		return false;
	}
}
