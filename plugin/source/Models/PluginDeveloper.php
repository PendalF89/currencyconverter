<?php
namespace Korobochkin\CurrencyConverter\Models;

use Korobochkin\CurrencyConverter\Plugin;

class PluginDeveloper {

	private $base_currency = null;

	private $currency_obj = null;

	public function __construct() {

	}

	public function set_base_currency( $currency ) {
		$this->base_currency = $currency;
		$this->currency_obj = new Currency( $this->base_currency, $this->base_currency );
	}

	public function is_valid() {
		if( empty( $this->base_currency ) ) {
			return false;
		}

		if( is_null( $this->currency_obj ) ) {
			$this->currency_obj = new Currency( $this->base_currency, $this->base_currency );
		}
		$is_valid = $this->currency_obj->is_available();

		return $is_valid;
	}

	/**
	 * We cannot use http_build_url() to construct URLs.
	 */
	public function get_base_currency_url() {
		if( $this->is_valid() ) {
			$url = $this->get_homepage_url();
			if( !in_array( $this->base_currency, \Korobochkin\CurrencyConverter\Models\Currencies\Currencies::get_currencies_list_without_home_pages() ) ) {
				$url = trailingslashit( $url ) . strtolower( $this->base_currency ) . '/';
			}
			return $url;
		}
		return false;
	}

	public function get_homepage_url() {
		/* translators: Homepage URL of plugin developer. */
		return __( 'http://exchangerate.guru/', Plugin::NAME );
	}

	public function get_caption_with_base_currency_link () {
		if( $this->is_valid() ) {

			$link = sprintf(
				/* translators: %1$s - url to homepage with base currency. %2$s - base currency ticker (ISO code). %3$s - date of update currency rate in regional format (only month, date and year available right now). Available date variables - http://php.net/manual/en/function.date.php. */
				__( 'Currency exchange rates in <a href="%1$s" class="currencyconverter-base-currency-link">%2$s</a> on %3$s', 'currencyconverter' ),
				esc_url( $this->get_base_currency_url() ),
				esc_html( strtoupper( $this->base_currency ) ),
				esc_html(
					$this->currency_obj->get_rate_datetime()->format(
						/* translators: date of update currencies rates in regional format (only month, date and year available right now). Variables - http://php.net/manual/en/function.date.php. */
						__( 'F j, Y', Plugin::NAME )
					)
				)
			);
			return $link;
		}
		return '';
	}
}
