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
	 * Мы не можем использовать http_build_url, потому что ее может не быть,
	 * поэтому делаем добавление поддомена костылями.
	 */
	public function get_base_currency_subdomain_url() {
		if( $this->is_valid() ) {
			$url_template = _x( 'http://exchangerate.guru/', 'Homepage URL of plugin developer.', Plugin::NAME );
			$url = str_replace( '://', '://' . strtolower( $this->base_currency ) . '.', $url_template );
			return $url;
		}
		return false;
	}

	public function get_homepage_url() {
		return _x( 'http://exchangerate.guru/', 'Homepage URL of plugin developer.', Plugin::NAME );
	}

	public function get_caption_with_base_currency_link () {
		if( $this->is_valid() ) {

			// Смотрим ЦБ РФ провайдер или нет.
			$settings = get_option( \Korobochkin\CurrencyConverter\Models\Settings\General::$option_name );
			if( isset( $settings['cached_rates_by_data_provider_name'] ) && $settings['cached_rates_by_data_provider_name'] === 'cbr' ) {
				$link = sprintf(
					_x( '<a href="%1$s" class="currency-converter-update-data-link">Exchange rate</a> of the CBRF at %2$s', '%1$s - url to data provider website. %2$s - date of update currency rate in regional format.', Plugin::NAME ),
					esc_url( $this->get_homepage_url() ),
					esc_html(
						$this->currency_obj->get_rate_datetime()->format(
							_x( 'F j, Y', 'Local date/month/year date format. Available variables - http://php.net/manual/en/function.date.php. Note that the name of the month may be displayed on English language or wrong the ending of the word (падежное окончание). Например, для русского языка лучше использовать формат ДД-ММ-ГГГГ, потому что "21 декабрь 2015" выглядит не очень красиво.', Plugin::NAME )
						)
					)
				);
			}
			else {
				$link = sprintf(
					_x( '<a href="%1$s" class="currency-converter-update-data-link">Exchange rate</a> on %2$s', '%1$s - url to data provider website. %2$s - date of update currency rate in regional format.', Plugin::NAME ),
					esc_url( $this->get_homepage_url() ),
					esc_html(
						$this->currency_obj->get_rate_datetime()->format(
							_x( 'F j, Y', 'Local date/month/year date format. Available variables - http://php.net/manual/en/function.date.php. Note that the name of the month may be displayed on English language or wrong the ending of the word (падежное окончание). Например, для русского языка лучше использовать формат ДД-ММ-ГГГГ, потому что "21 декабрь 2015" выглядит не очень красиво.', Plugin::NAME )
						)
					)
				);
			}
			return $link;
		}
		return '';
	}
}
