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

			if( $base === 'USD' ) {
				if( !empty( $rates[0]['rates'][$currency] ) ) {
					return $rates[0]['rates'][$currency];
				}
				return false;
			}
			else {
				if( !empty( $rates[0]['rates'][$currency] ) || $currency === 'USD' ) {
					if( !empty( $rates[0]['rates'][$base] ) ) {
						if( $currency === 'USD' ) {
							/**
							 * 1 USD -- 1.3700507322827999 AUD
							 * x USD -- 1 AUD
							 * x USD = (1 USD * 1 AUD) / 1.3700507322827999 AUD
							 */
							return 1 / $rates[0]['rates'][$base];
						}

						/**
						 * 1 USD -- 1.3700507322827999 AUD
						 * 1 USD -- 1.0492000836752 AZN
						 *
						 * 1.3700507322827999 AUD -- 1.0492000836752 AZN
						 * x AUD                  -- 1 AZN
						 * x AUD = (1.3700507322827999 AUD * 1 AZN ) / 1.0492000836752 AZN
						 *
						 */
						return $rates[0]['rates'][$currency] / $rates[0]['rates'][$base];
					}
				}
				return false;
			}
		}
		return false;
	}
}
