<?php
namespace Korobochkin\CurrencyConverter\Service;

use Korobochkin\CurrencyConverter\Plugin;

class ScriptStyles {

	public static function register() {
		wp_register_style(
			'plugin-' . Plugin::NAME . '-widgets',
			plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path ) . 'styles/frontend/frontend.css',
			array(),
			'0.5.1'
		);

		wp_register_style(
			'plugin-' . Plugin::NAME . '-fonts',
			self::fonts_url(),
			array(),
			'0.5.1'
		);
	}

	public static function fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		if ( 'off' !== _x( 'on', 'Open Sans font: on or off', Plugin::NAME ) ) {
			$fonts[] = 'Open Sans:300,400';
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', Plugin::NAME );
		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}
		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}
		return $fonts_url;
	}
}
