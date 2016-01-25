<?php
namespace Korobochkin\CurrencyConverter\Models\Currencies;

class Currencies {

	/**
	 * This list of currencies doesn't have home pages on our site (http://exchangerate.guru).
	 *
	 * @return array List of currencies short names.
	 */
	public static function get_currencies_list_without_home_pages() {
		return array( 'XPD', 'XPT', 'XAG', 'XAU' );
	}

	public static function get_currency( $currency ) {
		$currencies = array(
			'AED' =>
				array(
					'flag_name'       => 'AE',
					'html_code'       => '&#1583;.&#1573;',
					'currency_symbol' => 'د.إ',
				),
			'AFN' =>
				array(
					'flag_name'       => 'AF',
					'html_code'       => '&#1547;',
					'currency_symbol' => '؋',
				),
			'AMD' =>
				array(
					'flag_name'       => 'AM',
					'html_code'       => null,
					'currency_symbol' => 'դր',
				),
			'ARS' =>
				array(
					'flag_name'       => 'AR',
					'html_code'       => '&#36;',
					'currency_symbol' => '$',
				),
			'AUD' =>
				array(
					'flag_name'       => 'AU',
					'html_code'       => '&#36;',
					'currency_symbol' => '$',
				),
			'AZN' =>
				array(
					'flag_name'       => 'AZ',
					'html_code'       => null,
					'currency_symbol' => 'man.',
				),
			'BDT' =>
				array(
					'flag_name'       => 'BD',
					'html_code'       => '&#2547;',
					'currency_symbol' => 'Tk',
				),
			'BRL' =>
				array(
					'flag_name'       => 'BR',
					'html_code'       => '&#82;&#36;',
					'currency_symbol' => 'R$',
				),
			'BTC' =>
				array(
					'flag_name'       => 'BTC',
					'html_code'       => null,
					'currency_symbol' => null,
				),
			'BYR' =>
				array(
					'flag_name'       => 'BY',
					'html_code'       => null,
					'currency_symbol' => 'Br',
				),
			'CHF' =>
				array(
					'flag_name'       => 'CH',
					'html_code'       => '&#8355;',
					'currency_symbol' => '₣',
				),
			'CNY' =>
				array(
					'flag_name'       => 'CN',
					'html_code'       => '&yen;',
					'currency_symbol' => '¥',
				),
			'CZK' =>
				array(
					'flag_name'       => 'CZ',
					'html_code'       => '&#75;&#269;',
					'currency_symbol' => 'Kč',
				),
			'EUR' =>
				array(
					'flag_name'       => 'EU',
					'html_code'       => '&euro;',
					'currency_symbol' => '€',
				),
			'FRF' =>
				array(
					'flag_name'       => 'FR',
					'html_code'       => '&#8355;',
					'currency_symbol' => '₣',
				),
			'GBP' =>
				array(
					'flag_name'       => 'GB',
					'html_code'       => '&pound;',
					'currency_symbol' => '£',
				),
			'GEL' =>
				array(
					'flag_name'       => 'GE',
					'html_code'       => null,
					'currency_symbol' => null,
				),
			'IDR' =>
				array(
					'flag_name'       => 'ID',
					'html_code'       => '&#82;&#112;',
					'currency_symbol' => 'Rp',
				),
			'ILS' =>
				array(
					'flag_name'       => 'IL',
					'html_code'       => '&#8362;',
					'currency_symbol' => '₪',
				),
			'INR' =>
				array(
					'flag_name'       => 'IN',
					'html_code'       => '&#8360;',
					'currency_symbol' => '₹',
				),
			'JMD' =>
				array(
					'flag_name'       => 'JM',
					'html_code'       => '&#74;&#36;',
					'currency_symbol' => 'J$',
				),
			'JPY' =>
				array(
					'flag_name'       => 'JP',
					'html_code'       => '&yen;',
					'currency_symbol' => '¥',
				),
			'KGS' =>
				array(
					'flag_name'       => 'KG',
					'html_code'       => null,
					'currency_symbol' => 'сом',
				),
			'KRW' =>
				array(
					'flag_name'       => 'KR',
					'html_code'       => '&#8361;',
					'currency_symbol' => '₩',
				),
			'KZT' =>
				array(
					'flag_name'       => 'KZ',
					'html_code'       => '&#8376;',
					'currency_symbol' => '₸',
				),
			'MNT' =>
				array(
					'flag_name'       => 'MN',
					'html_code'       => '&#8366;',
					'currency_symbol' => '₮',
				),
			'MXN' =>
				array(
					'flag_name'       => 'MX',
					'html_code'       => '&#36;',
					'currency_symbol' => '$',
				),
			'NGN' =>
				array(
					'flag_name'       => 'NG',
					'html_code'       => '&#8358;',
					'currency_symbol' => '₦',
				),
			'NOK' =>
				array(
					'flag_name'       => 'NO',
					'html_code'       => '&#107;&#114;',
					'currency_symbol' => 'kr',
				),
			'NZD' =>
				array(
					'flag_name'       => 'NZ',
					'html_code'       => '&#36;',
					'currency_symbol' => '$',
				),
			'PHP' =>
				array(
					'flag_name'       => 'PH',
					'html_code'       => '&#8369;',
					'currency_symbol' => '₱',
				),
			'PKR' =>
				array(
					'flag_name'       => 'PK',
					'html_code'       => '&#8360;',
					'currency_symbol' => '₨',
				),
			'RUB' =>
				array(
					'flag_name'       => 'RU',
					'html_code'       => '&#8381;',
					'currency_symbol' => 'руб.',
				),
			'SEK' =>
				array(
					'flag_name'       => 'SE',
					'html_code'       => '&#107;&#114;',
					'currency_symbol' => 'kr',
				),
			'THB' =>
				array(
					'flag_name'       => 'TH',
					'html_code'       => '&#3647;',
					'currency_symbol' => '฿',
				),
			'TJS' =>
				array(
					'flag_name'       => 'TJ',
					'html_code'       => null,
					'currency_symbol' => 'смн.',
				),
			'TRY' =>
				array(
					'flag_name'       => 'TR',
					'html_code'       => '&#8378;',
					'currency_symbol' => '₺',
				),
			'UAH' =>
				array(
					'flag_name'       => 'UA',
					'html_code'       => '&#8372;',
					'currency_symbol' => '₴',
				),
			'USD' =>
				array(
					'flag_name'       => 'US',
					'html_code'       => '&#36;',
					'currency_symbol' => '$',
				),
			'UZS' =>
				array(
					'flag_name'       => 'UZ',
					'html_code'       => null,
					'currency_symbol' => 'сўм',
				),
			'VND' =>
				array(
					'flag_name'       => 'VN',
					'html_code'       => '&#8363;',
					'currency_symbol' => '₫',
				),
		);

		if ( !empty( $currencies[$currency] ) ) {
			return $currencies[$currency];
		}
		else {
			return false;
		}
	}
}
