<?php
namespace Korobochkin\Currency\Service;

class Rates {

	public static function is_available() {
		$rates = get_option( \Korobochkin\Currency\Plugin::NAME . '_rates' );
		if( $rates ) {
			if( !empty( $rates[0]['rates'] ) ) {
				return true;
			}
		}
		return false;
	}

	public static function get_rate( $currency_ticker, $base_ticker = 'USD' ) {
		if( self::is_available() ) {
			$rates = get_option( \Korobochkin\Currency\Plugin::NAME . '_rates' );

			/**
			 * Проверяем наличие базовой валюты (в которой будет указываться стоимость других)
			 * и валюты, которую нужно рассчитать (курс для которой пишем).
			 */
			if( !empty( $rates[0]['rates'][$currency_ticker] ) || $currency_ticker === 'USD' ) {
				if( !empty( $rates[0]['rates'][$base_ticker] ) || $base_ticker === 'USD' ) {

					/**
					 * Применяем ставки
					 */
					$currency_rate = $currency_ticker === 'USD' ? 1 : $rates[0]['rates'][$currency_ticker];
					$base_rate = $base_ticker === 'USD' ? 1 : $rates[0]['rates'][$base_ticker];

					/**
					 * Считаем всегда по одной формуле
					 */
					return $base_rate / $currency_rate;
				}
			}
		}
		return false;
	}
}
