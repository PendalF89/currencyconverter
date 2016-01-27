<?php
namespace Korobochkin\CurrencyConverter\Models\Currencies;

use Korobochkin\CurrencyConverter\Plugin;

class Currencies {

	/**
	 * This list of currencies doesn't have home pages on our site (http://exchangerate.guru).
	 *
	 * @return array List of currencies short names.
	 */
	public static function get_currencies_list_without_home_pages() {
		return array( 'XPD', 'XPT', 'XAG', 'XAU' );
	}

	public static function get_currencies_as_numeric_array() {
		$items = self::get_currencies();
		$new_items = array();
		foreach( $items as $key => $value ) {
			$value['currency_iso'] = $key;
			$new_items[] = $value;
		}
		return $new_items;
	}

	public static function get_currencies() {
		return array(
			'AED' => array(
				'flag' => 'AE',
				'currency_name' => __( 'United Arab Emirates Dirham', Plugin::NAME ),
				'country_name' => __( 'UAE', Plugin::NAME )
			),
			'AFN' => array(
				'flag' => 'AF',
				'currency_name' => __( 'Afghan Afghani', Plugin::NAME ),
				'country_name' => __( 'Afghanistan', Plugin::NAME )
			),
			'ALL' => array(
				'flag' => 'AL',
				'currency_name' => __( 'Albanian Lek', Plugin::NAME ),
				'country_name' => __( 'Albania', Plugin::NAME )
			),
			'AMD' => array(
				'flag' => 'AM',
				'currency_name' => __( 'Armenian Dram', Plugin::NAME ),
				'country_name' => __( 'Armenia', Plugin::NAME )
			),
			'ANG' => array(
				'flag' => 'AN',
				'currency_name' => __( 'Netherlands Antillean Guilder', Plugin::NAME ),
				'country_name' => __( 'Netherlands Antilles', Plugin::NAME )
			),
			'AOA' => array(
				'flag' => 'AO',
				'currency_name' => __( 'Angolan Kwanza', Plugin::NAME ),
				'country_name' => __( 'Angola', Plugin::NAME )
			),
			'ARS' => array(
				'flag' => 'AR',
				'currency_name' => __( 'Argentine Peso', Plugin::NAME ),
				'country_name' => __( 'Argentina', Plugin::NAME )
			),
			'AUD' => array(
				'flag' => 'AU',
				'currency_name' => __( 'Australian Dollar', Plugin::NAME ),
				'country_name' => __( 'Australia', Plugin::NAME )
			),
			'AWG' => array(
				'flag' => 'AW',
				'currency_name' => __( 'Aruban Florin', Plugin::NAME ),
				'country_name' => __( 'Aruba', Plugin::NAME )
			),
			'AZN' => array(
				'flag' => 'AZ',
				'currency_name' => __( 'Azerbaijanian Manat', Plugin::NAME ),
				'country_name' => __( 'Azerbaijan', Plugin::NAME )
			),
			'BAM' => array(
				'flag' => 'BA',
				'currency_name' => __( 'Convertible Mark', Plugin::NAME ),
				'country_name' => __( 'Bosnia and Herzegovina', Plugin::NAME )
			),
			'BBD' => array(
				'flag' => 'BB',
				'currency_name' => __( 'Barbados Dollar', Plugin::NAME ),
				'country_name' => __( 'Barbados', Plugin::NAME )
			),
			'BDT' => array(
				'flag' => 'BD',
				'currency_name' => __( 'Bangladeshi Taka', Plugin::NAME ),
				'country_name' => __( 'Bangladesh', Plugin::NAME )
			),
			'BGN' => array(
				'flag' => 'BG',
				'currency_name' => __( 'Bulgarian Lev', Plugin::NAME ),
				'country_name' => __( 'Bulgaria', Plugin::NAME )
			),
			'BHD' => array(
				'flag' => 'BH',
				'currency_name' => __( 'Bahraini Dinar', Plugin::NAME ),
				'country_name' => __( 'Bahrain', Plugin::NAME )
			),
			'BIF' => array(
				'flag' => 'BI',
				'currency_name' => __( 'Burundi Franc', Plugin::NAME ),
				'country_name' => __( 'Burundi', Plugin::NAME )
			),
			'BMD' => array(
				'flag' => 'BM',
				'currency_name' => __( 'Bermudian Dollar', Plugin::NAME ),
				'country_name' => __( 'Bermuda', Plugin::NAME )
			),
			'BND' => array(
				'flag' => 'BN',
				'currency_name' => __( 'Brunei Dollar', Plugin::NAME ),
				'country_name' => __( 'Brunei Darussalam', Plugin::NAME )
			),
			'BOB' => array(
				'flag' => 'BO',
				'currency_name' => __( 'Boliviano', Plugin::NAME ),
				'country_name' => __( 'Plurinational State of Bolivia', Plugin::NAME )
			),
			'BRL' => array(
				'flag' => 'BR',
				'currency_name' => __( 'Brazilian Real', Plugin::NAME ),
				'country_name' => __( 'Brazil', Plugin::NAME )
			),
			'BSD' => array(
				'flag' => 'BS',
				'currency_name' => __( 'Bahamian Dollar', Plugin::NAME ),
				'country_name' => __( 'The Bahamas', Plugin::NAME )
			),
			'BTC' => array(
				'flag' => '',
				'currency_name' => __( 'Bitcoin', Plugin::NAME ),
				'country_name' => __( 'Crypto-currency', Plugin::NAME )
			),
			'BTN' => array(
				'flag' => 'BT',
				'currency_name' => __( 'Bhutanese Ngultrum', Plugin::NAME ),
				'country_name' => __( 'Bhutan', Plugin::NAME )
			),
			'BWP' => array(
				'flag' => 'BW',
				'currency_name' => __( 'Botswana Pula', Plugin::NAME ),
				'country_name' => __( 'Botswana', Plugin::NAME )
			),
			'BYR' => array(
				'flag' => 'BY',
				'currency_name' => __( 'Belarussian Ruble', Plugin::NAME ),
				'country_name' => __( 'Belarus', Plugin::NAME )
			),
			'BZD' => array(
				'flag' => 'BZ',
				'currency_name' => __( 'Belize Dollar', Plugin::NAME ),
				'country_name' => __( 'Belize', Plugin::NAME )
			),
			'CAD' => array(
				'flag' => 'CA',
				'currency_name' => __( 'Canadian Dollar', Plugin::NAME ),
				'country_name' => __( 'Canada', Plugin::NAME )
			),
			'CDF' => array(
				'flag' => 'CD',
				'currency_name' => __( 'Congolese Franc', Plugin::NAME ),
				'country_name' => __( 'DR Congo', Plugin::NAME )
			),
			'CHF' => array(
				'flag' => 'CH',
				'currency_name' => __( 'Swiss Franc', Plugin::NAME ),
				'country_name' => __( 'Switzerland', Plugin::NAME )
			),
			'CLP' => array(
				'flag' => 'CL',
				'currency_name' => __( 'Chilean Peso', Plugin::NAME ),
				'country_name' => __( 'Chile', Plugin::NAME )
			),
			'CNY' => array(
				'flag' => 'CN',
				'currency_name' => __( 'Chinese Yuan', Plugin::NAME ),
				'country_name' => __( 'China', Plugin::NAME )
			),
			'COP' => array(
				'flag' => 'CO',
				'currency_name' => __( 'Colombian Peso', Plugin::NAME ),
				'country_name' => __( 'Colombia', Plugin::NAME )
			),
			'CRC' => array(
				'flag' => 'CR',
				'currency_name' => __( 'Costa Rican Colon', Plugin::NAME ),
				'country_name' => __( 'Costa Rica', Plugin::NAME )
			),
			'CUP' => array(
				'flag' => 'CU',
				'currency_name' => __( 'Cuban Peso', Plugin::NAME ),
				'country_name' => __( 'Cuba', Plugin::NAME )
			),
			'CVE' => array(
				'flag' => 'CV',
				'currency_name' => __( 'Cabo Verde Escudo', Plugin::NAME ),
				'country_name' => __( 'Cape Verde', Plugin::NAME )
			),
			'CZK' => array(
				'flag' => 'CZ',
				'currency_name' => __( 'Czech Koruna', Plugin::NAME ),
				'country_name' => __( 'Czech Republic', Plugin::NAME )
			),
			'DJF' => array(
				'flag' => 'DJ',
				'currency_name' => __( 'Djibouti Franc', Plugin::NAME ),
				'country_name' => __( 'Djibouti', Plugin::NAME )
			),
			'DKK' => array(
				'flag' => 'DK',
				'currency_name' => __( 'Danish Krone', Plugin::NAME ),
				'country_name' => __( 'Denmark', Plugin::NAME )
			),
			'DOP' => array(
				'flag' => 'DO',
				'currency_name' => __( 'Dominican Peso', Plugin::NAME ),
				'country_name' => __( 'Dominican Republic', Plugin::NAME )
			),
			'DZD' => array(
				'flag' => 'DZ',
				'currency_name' => __( 'Algerian Dinar', Plugin::NAME ),
				'country_name' => __( 'Algeria', Plugin::NAME )
			),
			'EGP' => array(
				'flag' => 'EG',
				'currency_name' => __( 'Egyptian Pound', Plugin::NAME ),
				'country_name' => __( 'Egypt', Plugin::NAME )
			),
			'ERN' => array(
				'flag' => 'ER',
				'currency_name' => __( 'Eritrean Nakfa', Plugin::NAME ),
				'country_name' => __( 'Eritrea', Plugin::NAME )
			),
			'ETB' => array(
				'flag' => 'ET',
				'currency_name' => __( 'Ethiopian Birr', Plugin::NAME ),
				'country_name' => __( 'Ethiopia', Plugin::NAME )
			),
			'EUR' => array(
				'flag' => 'EU',
				'currency_name' => __( 'Euro', Plugin::NAME ),
				'country_name' => __( 'European Union', Plugin::NAME )
			),
			'FJD' => array(
				'flag' => 'FJ',
				'currency_name' => __( 'Fiji Dollar', Plugin::NAME ),
				'country_name' => __( 'Fiji', Plugin::NAME )
			),
			'FKP' => array(
				'flag' => 'FK',
				'currency_name' => __( 'Falkland Islands Pound', Plugin::NAME ),
				'country_name' => __( 'Falkland Islands', Plugin::NAME )
			),
			'GBP' => array(
				'flag' => 'GB',
				'currency_name' => __( 'British Pound', Plugin::NAME ),
				'country_name' => __( 'United Kingdom', Plugin::NAME )
			),
			'GEL' => array(
				'flag' => 'GE',
				'currency_name' => __( 'Georgian Lari', Plugin::NAME ),
				'country_name' => __( 'Georgia', Plugin::NAME )
			),
			'GGP' => array(
				'flag' => 'GG',
				'currency_name' => __( 'Guernsey Pound', Plugin::NAME ),
				'country_name' => __( 'Guernsey', Plugin::NAME )
			),
			'GHS' => array(
				'flag' => 'GH',
				'currency_name' => __( 'Ghana Cedi', Plugin::NAME ),
				'country_name' => __( 'Ghana', Plugin::NAME )
			),
			'GIP' => array(
				'flag' => 'GI',
				'currency_name' => __( 'Gibraltar Pound', Plugin::NAME ),
				'country_name' => __( 'Gibraltar', Plugin::NAME )
			),
			'GMD' => array(
				'flag' => 'GM',
				'currency_name' => __( 'Gambian Dalasi', Plugin::NAME ),
				'country_name' => __( 'The Gambia', Plugin::NAME )
			),
			'GNF' => array(
				'flag' => 'GN',
				'currency_name' => __( 'Guinea Franc', Plugin::NAME ),
				'country_name' => __( 'Guinea', Plugin::NAME )
			),
			'GTQ' => array(
				'flag' => 'GT',
				'currency_name' => __( 'Guatemalan Quetzal', Plugin::NAME ),
				'country_name' => __( 'Guatemala', Plugin::NAME )
			),
			'GYD' => array(
				'flag' => 'GY',
				'currency_name' => __( 'Guyana Dollar', Plugin::NAME ),
				'country_name' => __( 'Guyana', Plugin::NAME )
			),
			'HKD' => array(
				'flag' => 'HK',
				'currency_name' => __( 'Hong Kong Dollar', Plugin::NAME ),
				'country_name' => __( 'Hong Kong', Plugin::NAME )
			),
			'HNL' => array(
				'flag' => 'HN',
				'currency_name' => __( 'Honduran Lempira', Plugin::NAME ),
				'country_name' => __( 'Honduras', Plugin::NAME )
			),
			'HRK' => array(
				'flag' => 'HR',
				'currency_name' => __( 'Croatian Kuna', Plugin::NAME ),
				'country_name' => __( 'Croatia', Plugin::NAME )
			),
			'HTG' => array(
				'flag' => 'HT',
				'currency_name' => __( 'Haitian Gourde', Plugin::NAME ),
				'country_name' => __( 'Haiti', Plugin::NAME )
			),
			'HUF' => array(
				'flag' => 'HU',
				'currency_name' => __( 'Hungarian Forint', Plugin::NAME ),
				'country_name' => __( 'Hungary', Plugin::NAME )
			),
			'IDR' => array(
				'flag' => 'ID',
				'currency_name' => __( 'Indonesian Rupiah', Plugin::NAME ),
				'country_name' => __( 'Indonesia', Plugin::NAME )
			),
			'ILS' => array(
				'flag' => 'IL',
				'currency_name' => __( 'Israeli Shekel', Plugin::NAME ),
				'country_name' => __( 'Israel', Plugin::NAME )
			),
			'INR' => array(
				'flag' => 'IN',
				'currency_name' => __( 'Indian Rupee', Plugin::NAME ),
				'country_name' => __( 'India', Plugin::NAME )
			),
			'IQD' => array(
				'flag' => 'IQ',
				'currency_name' => __( 'Iraqi Dinar', Plugin::NAME ),
				'country_name' => __( 'Iraq', Plugin::NAME )
			),
			'IRR' => array(
				'flag' => 'IR',
				'currency_name' => __( 'Iranian Rial', Plugin::NAME ),
				'country_name' => __( 'Iran', Plugin::NAME )
			),
			'ISK' => array(
				'flag' => 'IS',
				'currency_name' => __( 'Iceland Krona', Plugin::NAME ),
				'country_name' => __( 'Iceland', Plugin::NAME )
			),
			'JEP' => array(
				'flag' => 'JE',
				'currency_name' => __( 'Jersey Pound', Plugin::NAME ),
				'country_name' => __( 'Jersey', Plugin::NAME )
			),
			'JMD' => array(
				'flag' => 'JM',
				'currency_name' => __( 'Jamaican Dollar', Plugin::NAME ),
				'country_name' => __( 'Jamaica', Plugin::NAME )
			),
			'JOD' => array(
				'flag' => 'JO',
				'currency_name' => __( 'Jordanian Dinar', Plugin::NAME ),
				'country_name' => __( 'Jordan', Plugin::NAME )
			),
			'JPY' => array(
				'flag' => 'JP',
				'currency_name' => __( 'Japanese Yen', Plugin::NAME ),
				'country_name' => __( 'Japan', Plugin::NAME )
			),
			'KES' => array(
				'flag' => 'KE',
				'currency_name' => __( 'Kenyan Shilling', Plugin::NAME ),
				'country_name' => __( 'Kenya', Plugin::NAME )
			),
			'KGS' => array(
				'flag' => 'KG',
				'currency_name' => __( 'Kyrgyzstani Som', Plugin::NAME ),
				'country_name' => __( 'Kyrgyzstan', Plugin::NAME )
			),
			'KHR' => array(
				'flag' => 'KH',
				'currency_name' => __( 'Cambodian Riel', Plugin::NAME ),
				'country_name' => __( 'Cambodia', Plugin::NAME )
			),
			'KMF' => array(
				'flag' => 'KM',
				'currency_name' => __( 'Comoro Franc', Plugin::NAME ),
				'country_name' => __( 'The Comoros', Plugin::NAME )
			),
			'KPW' => array(
				'flag' => 'KP',
				'currency_name' => __( 'North Korean Won', Plugin::NAME ),
				'country_name' => __( 'North Korea', Plugin::NAME )
			),
			'KRW' => array(
				'flag' => 'KR',
				'currency_name' => __( 'South Korean Won', Plugin::NAME ),
				'country_name' => __( 'South Korea', Plugin::NAME )
			),
			'KWD' => array(
				'flag' => 'KW',
				'currency_name' => __( 'Kuwaiti Dinar', Plugin::NAME ),
				'country_name' => __( 'Kuwait', Plugin::NAME )
			),
			'KYD' => array(
				'flag' => 'KY',
				'currency_name' => __( 'Cayman Islands Dollar', Plugin::NAME ),
				'country_name' => __( 'The Cayman Islands', Plugin::NAME )
			),
			'KZT' => array(
				'flag' => 'KZ',
				'currency_name' => __( 'Kazakhstani Tenge', Plugin::NAME ),
				'country_name' => __( 'Kazakhstan', Plugin::NAME )
			),
			'LAK' => array(
				'flag' => 'LA',
				'currency_name' => __( 'Lao Kip', Plugin::NAME ),
				'country_name' => __( 'Laos', Plugin::NAME )
			),
			'LBP' => array(
				'flag' => 'LB',
				'currency_name' => __( 'Lebanese Pound', Plugin::NAME ),
				'country_name' => __( 'Lebanon', Plugin::NAME )
			),
			'LKR' => array(
				'flag' => 'LK',
				'currency_name' => __( 'Sri Lanka Rupee', Plugin::NAME ),
				'country_name' => __( 'Sri Lanka', Plugin::NAME )
			),
			'LRD' => array(
				'flag' => 'LR',
				'currency_name' => __( 'Liberian Dollar', Plugin::NAME ),
				'country_name' => __( 'Liberia', Plugin::NAME )
			),
			'LSL' => array(
				'flag' => 'LS',
				'currency_name' => __( 'Lesotho Loti', Plugin::NAME ),
				'country_name' => __( 'Lesotho', Plugin::NAME )
			),
			'LYD' => array(
				'flag' => 'LY',
				'currency_name' => __( 'Libyan Dinar', Plugin::NAME ),
				'country_name' => __( 'Libya', Plugin::NAME )
			),
			'MAD' => array(
				'flag' => 'MA',
				'currency_name' => __( 'Moroccan Dirham', Plugin::NAME ),
				'country_name' => __( 'Morocco', Plugin::NAME )
			),
			'MDL' => array(
				'flag' => 'MD',
				'currency_name' => __( 'Moldovan Leu', Plugin::NAME ),
				'country_name' => __( 'Moldova', Plugin::NAME )
			),
			'MGA' => array(
				'flag' => 'MG',
				'currency_name' => __( 'Malagasy Ariary', Plugin::NAME ),
				'country_name' => __( 'Madagascar', Plugin::NAME )
			),
			'MKD' => array(
				'flag' => 'MK',
				'currency_name' => __( 'Macedonian Denar', Plugin::NAME ),
				'country_name' => __( 'Macedonia', Plugin::NAME )
			),
			'MMK' => array(
				'flag' => 'MM',
				'currency_name' => __( 'Myanmar Kyat', Plugin::NAME ),
				'country_name' => __( 'Myanmar', Plugin::NAME )
			),
			'MNT' => array(
				'flag' => 'MN',
				'currency_name' => __( 'Mongolian Tugrik', Plugin::NAME ),
				'country_name' => __( 'Mongolia', Plugin::NAME )
			),
			'MOP' => array(
				'flag' => 'MO',
				'currency_name' => __( 'Macanese Pataca', Plugin::NAME ),
				'country_name' => __( 'Macao', Plugin::NAME )
			),
			'MRO' => array(
				'flag' => 'MR',
				'currency_name' => __( 'Mauritanian Ouguiya', Plugin::NAME ),
				'country_name' => __( 'Mauritania', Plugin::NAME )
			),
			'MUR' => array(
				'flag' => 'MU',
				'currency_name' => __( 'Mauritius Rupee', Plugin::NAME ),
				'country_name' => __( 'Mauritius', Plugin::NAME )
			),
			'MVR' => array(
				'flag' => 'MV',
				'currency_name' => __( 'Maldivian Rufiyaa', Plugin::NAME ),
				'country_name' => __( 'Maldives', Plugin::NAME )
			),
			'MWK' => array(
				'flag' => 'MW',
				'currency_name' => __( 'Malawian Kwacha', Plugin::NAME ),
				'country_name' => __( 'Malawi', Plugin::NAME )
			),
			'MXN' => array(
				'flag' => 'MX',
				'currency_name' => __( 'Mexican Peso', Plugin::NAME ),
				'country_name' => __( 'Mexico', Plugin::NAME )
			),
			'MYR' => array(
				'flag' => 'MY',
				'currency_name' => __( 'Malaysian Ringgit', Plugin::NAME ),
				'country_name' => __( 'Malaysia', Plugin::NAME )
			),
			'MZN' => array(
				'flag' => 'MZ',
				'currency_name' => __( 'Mozambique Metical', Plugin::NAME ),
				'country_name' => __( 'Mozambique', Plugin::NAME )
			),
			'NAD' => array(
				'flag' => 'NA',
				'currency_name' => __( 'Namibia Dollar', Plugin::NAME ),
				'country_name' => __( 'Namibia', Plugin::NAME )
			),
			'NGN' => array(
				'flag' => 'NG',
				'currency_name' => __( 'Nigerian Naira', Plugin::NAME ),
				'country_name' => __( 'Nigeria', Plugin::NAME )
			),
			'NIO' => array(
				'flag' => 'NI',
				'currency_name' => __( 'Cordoba Oro', Plugin::NAME ),
				'country_name' => __( 'Nicaragua', Plugin::NAME )
			),
			'NOK' => array(
				'flag' => 'NO',
				'currency_name' => __( 'Norwegian Krone', Plugin::NAME ),
				'country_name' => __( 'Norway', Plugin::NAME )
			),
			'NPR' => array(
				'flag' => 'NP',
				'currency_name' => __( 'Nepalese Rupee', Plugin::NAME ),
				'country_name' => __( 'Nepal', Plugin::NAME )
			),
			'NZD' => array(
				'flag' => 'NZ',
				'currency_name' => __( 'New Zealand Dollar', Plugin::NAME ),
				'country_name' => __( 'New Zealand', Plugin::NAME )
			),
			'OMR' => array(
				'flag' => 'OM',
				'currency_name' => __( 'Rial Omani', Plugin::NAME ),
				'country_name' => __( 'Oman', Plugin::NAME )
			),
			'PAB' => array(
				'flag' => 'PA',
				'currency_name' => __( 'Panamanian Balboa', Plugin::NAME ),
				'country_name' => __( 'Panama', Plugin::NAME )
			),
			'PEN' => array(
				'flag' => 'PE',
				'currency_name' => __( 'Peruvian Sol', Plugin::NAME ),
				'country_name' => __( 'Peru', Plugin::NAME )
			),
			'PGK' => array(
				'flag' => 'PG',
				'currency_name' => __( 'Papua New Guinean Kina', Plugin::NAME ),
				'country_name' => __( 'Papua New Guinea', Plugin::NAME )
			),
			'PHP' => array(
				'flag' => 'PH',
				'currency_name' => __( 'Philippine Peso', Plugin::NAME ),
				'country_name' => __( 'Philippines', Plugin::NAME )
			),
			'PKR' => array(
				'flag' => 'PK',
				'currency_name' => __( 'Pakistani Rupee', Plugin::NAME ),
				'country_name' => __( 'Pakistan', Plugin::NAME )
			),
			'PLN' => array(
				'flag' => 'PL',
				'currency_name' => __( 'Polish Zloty', Plugin::NAME ),
				'country_name' => __( 'Poland', Plugin::NAME )
			),
			'PYG' => array(
				'flag' => 'PY',
				'currency_name' => __( 'Paraguayan Guarani', Plugin::NAME ),
				'country_name' => __( 'Paraguay', Plugin::NAME )
			),
			'QAR' => array(
				'flag' => 'QA',
				'currency_name' => __( 'Qatari Rial', Plugin::NAME ),
				'country_name' => __( 'Qatar', Plugin::NAME )
			),
			'RON' => array(
				'flag' => 'RO',
				'currency_name' => __( 'Romanian Leu', Plugin::NAME ),
				'country_name' => __( 'Romania', Plugin::NAME )
			),
			'RSD' => array(
				'flag' => 'RS',
				'currency_name' => __( 'Serbian Dinar', Plugin::NAME ),
				'country_name' => __( 'Serbia', Plugin::NAME )
			),
			'RUB' => array(
				'flag' => 'RU',
				'currency_name' => __( 'Russian Ruble', Plugin::NAME ),
				'country_name' => __( 'Russia', Plugin::NAME )
			),
			'RWF' => array(
				'flag' => 'RW',
				'currency_name' => __( 'Rwanda Franc', Plugin::NAME ),
				'country_name' => __( 'Rwanda', Plugin::NAME )
			),
			'SAR' => array(
				'flag' => 'SA',
				'currency_name' => __( 'Saudi Riyal', Plugin::NAME ),
				'country_name' => __( 'Saudi Arabia', Plugin::NAME )
			),
			'SBD' => array(
				'flag' => 'SB',
				'currency_name' => __( 'Solomon Islands Dollar', Plugin::NAME ),
				'country_name' => __( 'Solomon Islands', Plugin::NAME )
			),
			'SCR' => array(
				'flag' => 'SC',
				'currency_name' => __( 'Seychelles Rupee', Plugin::NAME ),
				'country_name' => __( 'Seychelles', Plugin::NAME )
			),
			'SDG' => array(
				'flag' => 'SD',
				'currency_name' => __( 'Sudanese Pound', Plugin::NAME ),
				'country_name' => __( 'The Sudan', Plugin::NAME )
			),
			'SEK' => array(
				'flag' => 'SE',
				'currency_name' => __( 'Swedish Krona', Plugin::NAME ),
				'country_name' => __( 'Sweden', Plugin::NAME )
			),
			'SGD' => array(
				'flag' => 'SG',
				'currency_name' => __( 'Singapore Dollar', Plugin::NAME ),
				'country_name' => __( 'Singapore', Plugin::NAME )
			),
			'SHP' => array(
				'flag' => 'SH',
				'currency_name' => __( 'Saint Helena Pound', Plugin::NAME ),
				'country_name' => __( 'Saint Helena, Ascension And Tristan Da Cunha', Plugin::NAME )
			),
			'SLL' => array(
				'flag' => 'SL',
				'currency_name' => __( 'Sierra Leonean Leone', Plugin::NAME ),
				'country_name' => __( 'Sierra Leone', Plugin::NAME )
			),
			'SOS' => array(
				'flag' => 'SO',
				'currency_name' => __( 'Somali Shilling', Plugin::NAME ),
				'country_name' => __( 'Somalia', Plugin::NAME )
			),
			'SRD' => array(
				'flag' => 'SR',
				'currency_name' => __( 'Surinam Dollar', Plugin::NAME ),
				'country_name' => __( 'Suriname', Plugin::NAME )
			),
			'STD' => array(
				'flag' => 'ST',
				'currency_name' => __( 'Sao Tomean Dobra', Plugin::NAME ),
				'country_name' => __( 'Sao Tome And Principe', Plugin::NAME )
			),
			'SVC' => array(
				'flag' => 'SV',
				'currency_name' => __( 'El Salvador Colon', Plugin::NAME ),
				'country_name' => __( 'El Salvador', Plugin::NAME )
			),
			'SYP' => array(
				'flag' => 'SY',
				'currency_name' => __( 'Syrian Pound', Plugin::NAME ),
				'country_name' => __( 'Syrian Arab Republic', Plugin::NAME )
			),
			'SZL' => array(
				'flag' => 'SZ',
				'currency_name' => __( 'Swazi Lilangeni', Plugin::NAME ),
				'country_name' => __( 'Swaziland', Plugin::NAME )
			),
			'THB' => array(
				'flag' => 'TH',
				'currency_name' => __( 'Thai Baht', Plugin::NAME ),
				'country_name' => __( 'Thailand', Plugin::NAME )
			),
			'TJS' => array(
				'flag' => 'TJ',
				'currency_name' => __( 'Tajikistani Somoni', Plugin::NAME ),
				'country_name' => __( 'Tajikistan', Plugin::NAME )
			),
			'TMT' => array(
				'flag' => 'TM',
				'currency_name' => __( 'Turkmenistan New Manat', Plugin::NAME ),
				'country_name' => __( 'Turkmenistan', Plugin::NAME )
			),
			'TND' => array(
				'flag' => 'TN',
				'currency_name' => __( 'Tunisian Dinar', Plugin::NAME ),
				'country_name' => __( 'Tunisia', Plugin::NAME )
			),
			'TOP' => array(
				'flag' => 'TO',
				'currency_name' => __( 'Tongan Pa?anga', Plugin::NAME ),
				'country_name' => __( 'Tonga', Plugin::NAME )
			),
			'TRY' => array(
				'flag' => 'TR',
				'currency_name' => __( 'Turkish Lira', Plugin::NAME ),
				'country_name' => __( 'Turkey', Plugin::NAME )
			),
			'TTD' => array(
				'flag' => 'TT',
				'currency_name' => __( 'Trinidad and Tobago Dollar', Plugin::NAME ),
				'country_name' => __( 'Trinidad And Tobago', Plugin::NAME )
			),
			'TWD' => array(
				'flag' => 'TW',
				'currency_name' => __( 'New Taiwan Dollar', Plugin::NAME ),
				'country_name' => __( 'Taiwan', Plugin::NAME )
			),
			'TZS' => array(
				'flag' => 'TZ',
				'currency_name' => __( 'Tanzanian Shilling', Plugin::NAME ),
				'country_name' => __( 'Tanzania', Plugin::NAME )
			),
			'UAH' => array(
				'flag' => 'UA',
				'currency_name' => __( 'Ukrainian Hryvnia', Plugin::NAME ),
				'country_name' => __( 'Ukraine', Plugin::NAME )
			),
			'UGX' => array(
				'flag' => 'UG',
				'currency_name' => __( 'Uganda Shilling', Plugin::NAME ),
				'country_name' => __( 'Uganda', Plugin::NAME )
			),
			'USD' => array(
				'flag' => 'US',
				'currency_name' => __( 'United States Dollar', Plugin::NAME ),
				'country_name' => __( 'USA', Plugin::NAME )
			),
			'UYU' => array(
				'flag' => 'UY',
				'currency_name' => __( 'Peso Uruguayo', Plugin::NAME ),
				'country_name' => __( 'Uruguay', Plugin::NAME )
			),
			'UZS' => array(
				'flag' => 'UZ',
				'currency_name' => __( 'Uzbekistan Sum', Plugin::NAME ),
				'country_name' => __( 'Uzbekistan', Plugin::NAME )
			),
			'VEF' => array(
				'flag' => 'VE',
				'currency_name' => __( 'Venezuelan Bolivar', Plugin::NAME ),
				'country_name' => __( 'Venezuela', Plugin::NAME )
			),
			'VND' => array(
				'flag' => 'VN',
				'currency_name' => __( 'Vietnamese Dong', Plugin::NAME ),
				'country_name' => __( 'Vietnam', Plugin::NAME )
			),
			'VUV' => array(
				'flag' => 'VU',
				'currency_name' => __( 'Vanuatu Vatu', Plugin::NAME ),
				'country_name' => __( 'Vanuatu', Plugin::NAME )
			),
			'WST' => array(
				'flag' => 'WS',
				'currency_name' => __( 'Samoan Tala', Plugin::NAME ),
				'country_name' => __( 'Samoa', Plugin::NAME )
			),
			'XAF' => array(
				'flag' => 'CF',
				'currency_name' => __( 'CFA Franc BEAC', Plugin::NAME ),
				'country_name' => __( 'Bank of Central African States', Plugin::NAME )
			),
			'XCD' => array(
				'flag' => false,
				'currency_name' => __( 'East Caribbean Dollar', Plugin::NAME ),
				'country_name' => __( 'Organisation of Eastern Caribbean States', Plugin::NAME )
			),
			'XOF' => array(
				'flag' => false,
				'currency_name' => __( 'CFA Franc BCEAO', Plugin::NAME ),
				'country_name' => __( 'Central Bank of West African States', Plugin::NAME )
			),
			'XPF' => array(
				'flag' => false,
				'currency_name' => __( 'CFP Franc', Plugin::NAME ),
				'country_name' => __( 'IEOM', Plugin::NAME )
			),
			'YER' => array(
				'flag' => 'YE',
				'currency_name' => __( 'Yemeni Rial', Plugin::NAME ),
				'country_name' => __( 'Yemen', Plugin::NAME )
			),
			'ZAR' => array(
				'flag' => 'ZA',
				'currency_name' => __( 'South African Rand', Plugin::NAME ),
				'country_name' => __( 'Republic of South Africa', Plugin::NAME )
			),
			'ZMW' => array(
				'flag' => 'ZM',
				'currency_name' => __( 'Zambian Kwacha', Plugin::NAME ),
				'country_name' => __( 'Zambia', Plugin::NAME )
			),
			'ZWL' => array(
				'flag' => 'ZW',
				'currency_name' => __( 'Zimbabwean Dollar', Plugin::NAME ),
				'country_name' => __( 'Zimbabwe', Plugin::NAME )
			)
		);
	}
}
