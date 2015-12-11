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

	public static function get_rate( $currency, $base = 'USD' ) {
		if( self::is_available() ) {
			$rates = get_option( \Korobochkin\Currency\Plugin::NAME . '_rates' );

			if( !empty( $rates[0]['rates'][$currency] ) || $currency === 'USD' ) {
				if( !empty( $rates[0]['rates'][$base] ) || $base === 'USD' ) {
					$currency = $currency === 'USD' ? 1 : $rates[0]['rates'][$currency];
					$base = $base === 'USD' ? 1 : $rates[0]['rates'][$base];

					return $base / $currency;
				}
			}

			/**
			 * Валюта должна быть в списке
			 */
			/*if( !empty( $rates[0]['rates'][$currency] ) || $rates[0]['rates'][$currency] === 'USD' ) {
				// Базовая валюта доллар
				if( $base === 'USD' ) {
					if( $rates[0]['rates'][$currency] === 'USD' ) {
						return 1;
					}
					else {
						return 1 / $rates[0]['rates'][$currency];
					}
				}
				// Базовая валюта не доллар (должна быть в списке)
				elseif( !empty( $rates[0]['rates'][$base] ) ) {
					if( $rates[0]['rates'][$currency] === 'USD' ) {
						return $rates[0]['rates'][$base];
					}
					else {
						return $rates[0]['rates'][$base] / $rates[0]['rates'][$currency];
					}
				}
			}*/
		}
		return false;
	}
}
